<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;

interface PostInterface extends DomainObjectInterface {

    public function setType(string $type): void;
    public function getType(): string;
    
    public function getSocialId(): string;
    public function setSocialId(string $socialId): void;
    
    public function getDatetime(): ?\DateTime;
    public function setDatetime(?\DateTime $datetime): void;
    
    public function getTitle(): string;
    public function setTitle(string $title): void;
    
    public function getContent(): string;
    public function setContent(string $content): void;
    
    public function getUrl(): string;
    public function setUrl(string $url): void;
    
    public function getMediaUrl(): string;
    public function setMediaUrl(string $mediaUrl): void;

    public function getPosterUrl(): string;
    public function setPosterUrl(string $posterUrl): void;
    
    public function setFeed(?Feed $feed): void;
    public function getFeed(): ?Feed;
    
}
