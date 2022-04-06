<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Model;

use DachcomDigital\SocialData\Connector\ConnectorInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Feed extends AbstractEntity
{
    protected string $name = '';
    protected int $storagePid = 0;
    protected string $connectorIdentifier = '';
    protected array $connectorConfiguration = [];
    protected string $connectorStatus = '';
    /** @var ObjectStorage<Post>  */
    protected ?ObjectStorage $posts = null;
    
    public function __construct()
    {
        $this->posts = new ObjectStorage();
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return int
     */
    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
    
    /**
     * @param int $storagePid
     */
    public function setStoragePid(int $storagePid): void
    {
        $this->storagePid = $storagePid;
    }
    
    /**
     * @return string
     */
    public function getConnectorIdentifier(): string
    {
        return $this->connectorIdentifier;
    }
    
    /**
     * @param string $connectorIdentifier
     */
    public function setConnectorIdentifier(string $connectorIdentifier): void
    {
        $this->connectorIdentifier = $connectorIdentifier;
    }
    
    /**
     * @return array
     */
    public function getConnectorConfiguration(): array
    {
        return $this->connectorConfiguration;
    }
    
    /**
     * @param array $connectorConfiguration
     */
    public function setConnectorConfiguration(array $connectorConfiguration): void
    {
        $this->connectorConfiguration = $connectorConfiguration;
    }
    
    /**
     * @param string $name
     * @param mixed $value
     */
    public function setConnectorConfigurationValue(string $name, $value): void
    {
        $this->setConnectorConfiguration(
            array_merge($this->connectorConfiguration, [$name => $value])
        );
    }
    
    /**
     * @return ObjectStorage<Post>
     */
    public function getPosts(): ObjectStorage
    {
        return $this->posts;
    }
    
    /**
     * @param ObjectStorage<Post> $posts
     */
    public function setPosts(ObjectStorage $posts): void
    {
        $this->posts = $posts;
    }
    
    public function addPost(Post $post): void
    {
        $post->setFeed($this);
        $this->posts->attach($post);
    }
    
    /**
     * @return string
     */
    public function getConnectorStatus(): string
    {
        return $this->connectorStatus;
    }
    
    /**
     * @param string $connectorStatus
     */
    public function setConnectorStatus(string $connectorStatus): void
    {
        $this->connectorStatus = $connectorStatus;
    }
    
    public function isConnectorConnected(): bool
    {
        return $this->connectorStatus === ConnectorInterface::STATUS_CONNECTED;
    }
}
