<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Wall extends AbstractEntity
{
    protected string $name = '';
    
    /**
     * @var ObjectStorage<Feed>
     */
    protected ?ObjectStorage $feeds = null;
    
    public function __construct()
    {
        $this->feeds = new ObjectStorage();
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
     * @return ObjectStorage<Feed>
     */
    public function getFeeds(): ObjectStorage
    {
        return $this->feeds;
    }
    
    /**
     * @param ObjectStorage<Feed> $feeds
     */
    public function setFeeds(ObjectStorage $feeds): void
    {
        $this->feeds = $feeds;
    }
    
}
