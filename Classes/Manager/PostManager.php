<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Manager;

use DachcomDigital\SocialData\Domain\Model\PostInterface;
use DachcomDigital\SocialData\Domain\Repository\PostRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class PostManager
{
    protected PersistenceManager $persistenceManager;
    protected PostRepository $postRepository;
    
    public function __construct(PersistenceManager $persistenceManager, PostRepository $postRepository)
    {
        $this->persistenceManager = $persistenceManager;
        $this->postRepository = $postRepository;
    }
    
    public function savePosts(array $posts): void
    {
        foreach ($posts as $post) {
            if (!$post instanceof PostInterface) {
                continue;
            }
            $existingPost = $this->postRepository->findOneBySocialId($post->getSocialId());
            if ($existingPost instanceof PostInterface) {
                $this->updatePostProperties($existingPost, $post);
                $this->postRepository->update($existingPost);
            } else {
                $this->postRepository->add($post);
            }
        }
        
        $this->persistenceManager->persistAll();
    }
    
    public function updatePostProperties(PostInterface $a, PostInterface $b)
    {
        $a->setDatetime($b->getDatetime());
        $a->setTitle($b->getTitle());
        $a->setContent($b->getContent());
        $a->setMediaUrl($b->getMediaUrl());
        $a->setPosterUrl($b->getPosterUrl());
        $a->setUrl($b->getUrl());
    }
    
}
