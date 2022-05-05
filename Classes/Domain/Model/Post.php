<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Post extends AbstractEntity implements PostInterface {
    
    protected string $type = '';
    protected string $socialId = '';
    protected ?\DateTime $datetime = null;
    protected string $title = '';
    protected string $content = '';
    protected string $url = '';
    protected string $mediaUrl = '';
    protected string $posterUrl = '';
    protected ?Feed $feed = null;
    /** @var ObjectStorage<FileReference>  */
    protected ?ObjectStorage $poster = null;
    
    public function __construct()
    {
        $this->poster = new ObjectStorage();
    }
    
    public function getSocialId(): string
    {
        return $this->socialId;
    }

    public function setSocialId(string $socialId): void
    {
        $this->socialId = $socialId;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function setType(string $type): void
    {
        $this->type = $type;
    }
    
    public function getDatetime(): ?\DateTime
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTime $datetime): void
    {
        $this->datetime = $datetime;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
    
    public function getMediaUrl(): string
    {
        return $this->mediaUrl;
    }
    
    public function setMediaUrl(string $mediaUrl): void
    {
        $this->mediaUrl = $mediaUrl;
    }

    public function getPosterUrl(): string
    {
        return $this->posterUrl;
    }
    
    public function setPosterUrl(string $posterUrl): void
    {
        $this->posterUrl = $posterUrl;
    }

    public function getFeed(): ?Feed
    {
        return $this->feed;
    }
    
    public function setFeed(?Feed $feed): void
    {
        $this->feed = $feed;
    }

    public function getPoster(): ObjectStorage
    {
        return $this->poster;
    }
    
    public function setPoster(?ObjectStorage $poster): void
    {
        $this->poster = $poster;
    }
    
    public function addPoster(FileReference $element): void
    {
        $this->poster->attach($element);
    }
    
}
