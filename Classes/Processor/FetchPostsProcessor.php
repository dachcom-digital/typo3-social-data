<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Processor;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use DachcomDigital\SocialData\Connector\ConnectorDefinitionInterface;
use DachcomDigital\SocialData\Domain\Model\Feed;
use DachcomDigital\SocialData\Domain\Model\Wall;
use DachcomDigital\SocialData\Domain\Model\Post;
use DachcomDigital\SocialData\Manager\PostManager;
use DachcomDigital\SocialData\Domain\Repository\WallRepository;
use DachcomDigital\SocialData\Registry\ConnectorDefinitionRegistry;

class FetchPostsProcessor implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    
    protected PropertyMapper $propertyMapper;
    protected ConnectorDefinitionRegistry $connectorRegistry;
    protected WallRepository $wallRepository;
    protected PostManager $postManager;
    
    public function __construct(
        PropertyMapper $propertyMapper,
        ConnectorDefinitionRegistry $connectorRegistry,
        WallRepository $wallRepository,
        PostManager $postManager
    ) {
        $this->propertyMapper = $propertyMapper;
        $this->connectorRegistry = $connectorRegistry;
        $this->wallRepository = $wallRepository;
        $this->postManager = $postManager;
    }
    
    public function process($wallId): void
    {
        if (!empty($wallId)) {
            $walls = $this->wallRepository->findByUid($wallId);
            if (!$walls instanceof Wall) {
                $this->logger->error(sprintf('Wall with id %d not found', $wallId));
            }
        } else {
            $walls = $this->wallRepository->findAll()->toArray();
        }
        
        $walls = is_array($walls) ? $walls : [$walls];
        
        foreach ($walls as $wall) {
            try {
                $this->processWall($wall);
            } catch (\Throwable $e) {
                $this->logger->error(sprintf('error while processing wall %s [%s]: %s', $wall->getName(),
                    $wall->getUid(), $e->getMessage()), [$wall]);
            }
        }
        
    }
    
    protected function processWall(Wall $wall): void
    {
        $feeds = $wall->getFeeds();
        
        if (count($feeds) === 0) {
            return;
        }
        
        $this->logger->debug(sprintf('processing wall %s [%s]', $wall->getName(), $wall->getUid()));
        
        foreach ($feeds as $feed) {
            $this->processFeed($feed);
        }
    }
    
    protected function processFeed(Feed $feed)
    {
        if (empty($feed->getConnectorIdentifier())) {
            $this->logger->error(sprintf('feed %s [%s] has no configured connector!', $feed->getName(),
                $feed->getUid()));
        }
        $connectorDefinition = $this->connectorRegistry->get($feed->getConnectorIdentifier());
        
        if (!$connectorDefinition instanceof ConnectorDefinitionInterface) {
            $this->logger->info(sprintf('no connector definition "%s" found!', $feed->getConnectorIdentifier()));
            return;
        }
        
        $this->logger->debug(sprintf('processing feed %s [%s]', $feed->getName(), $feed->getUid()));
        
        $connector = $connectorDefinition->getConnector();
        $connector->setConfiguration($feed->getConnectorConfiguration());
        
        try {
            $fetchedItems = $connector->fetchItems();
        } catch (\Throwable $e) {
            $this->logger->error(
                sprintf(
                    'error fetching items from connector %s of feed %s [%s]: %s',
                    $feed->getConnectorIdentifier(),
                    $feed->getName(),
                    $feed->getUid(),
                    $e->getMessage()
                )
            );
            return;
        }
        
        $posts = $this->processFetchedItems($fetchedItems, $feed);
        
        $this->postManager->savePosts($posts, $feed);
    }
    
    protected function processFetchedItems(array $items, Feed $feed): array
    {
        $posts = [];
        
        $resolver = $this->getPostItemResolver();
        
        foreach ($items as $item) {
            // @ToDo: better handling, maybe a dto
            $resolvedItem = $resolver->resolve($item);
            
            $socialId = $this->generatePostIdentifier($resolvedItem['id'], $feed);
            unset($resolvedItem['id']);
            try {
                // @ToDo: better handling, maybe custom type converter
                $post = $this->propertyMapper->convert(
                    $resolvedItem,
                    Post::class
                );
                $post->setPid($feed->getStoragePid());
                $post->setSocialId($socialId);
                $post->setType($feed->getConnectorIdentifier());
                $post->setFeed($feed);
                $posts[] = $post;
            } catch (\Throwable $e) {
                $this->logger->error(sprintf('could not convert to post: %s', $e->getMessage()));
            }
        }
        
        return $posts;
    }
    
    protected function generatePostIdentifier(string $id, Feed $feed)
    {
        return implode('-', [$feed->getUid(), $feed->getConnectorIdentifier(), $id]);
    }
    
    protected function getPostItemResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['id', 'datetime', 'title', 'content', 'url', 'mediaUrl', 'posterUrl']);
        $resolver->setRequired('id');
        $resolver->setAllowedTypes('id', 'string');
        $resolver->setAllowedTypes('title', 'string');
        $resolver->setAllowedTypes('content', 'string');
        $resolver->setAllowedTypes('datetime', ['null', 'DateTime']);
        $resolver->setAllowedTypes('url', 'string');
        $resolver->setAllowedTypes('mediaUrl', 'string');
        $resolver->setAllowedTypes('posterUrl', 'string');
        return $resolver;
    }
}
