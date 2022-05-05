<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Manager;

use DachcomDigital\SocialData\Domain\Model\Feed;
use DachcomDigital\SocialData\Domain\Model\PostInterface;
use DachcomDigital\SocialData\Domain\Repository\PostRepository;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Resource\Exception\FolderDoesNotExistException;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ExtbaseFileReference;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class PostManager
{
    protected PersistenceManager $persistenceManager;
    protected PostRepository $postRepository;
    protected StorageRepository $storageRepository;
    protected Folder $assetStorageFolder;
    
    public function __construct(PersistenceManager $persistenceManager, PostRepository $postRepository, StorageRepository $storageRepository)
    {
        $this->persistenceManager = $persistenceManager;
        $this->postRepository = $postRepository;
        $this->storageRepository = $storageRepository;
        
        $this->ensureAssetStorage();
    }
    
    protected function ensureAssetStorage(): void
    {
        $assetStoragePath = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('social_data', 'assetStoragePath');
        $assetStoragePathParts = GeneralUtility::trimExplode(':', $assetStoragePath);
        if (count($assetStoragePathParts) !== 2) {
            throw new \Exception('invalid asset storage path configuration');
        }
        $storageUid = (int)$assetStoragePathParts[0];
        $folderPath = $assetStoragePathParts[1];
    
        $storage = $this->storageRepository->findByUid($storageUid) ?? $this->storageRepository->getDefaultStorage();
        try {
            $this->assetStorageFolder = $storage->getFolder($folderPath);
        } catch (FolderDoesNotExistException $e) {
            $this->assetStorageFolder = $storage->createFolder($folderPath);
        }
    }
    
    public function savePosts(array $posts, Feed $feed): void
    {
        foreach ($posts as $post) {
            if (!$post instanceof PostInterface) {
                continue;
            }
            $newOrExistingPost = $this->postRepository->findOneBySocialId($post->getSocialId()) ?? $post;
            $this->updatePostProperties($newOrExistingPost, $post);
            if ($feed->getPersistMedia()) {
                $this->persistMedia($newOrExistingPost);
            }
            if (empty($newOrExistingPost->getUid())) {
                $this->postRepository->add($newOrExistingPost);
            } else {
                $this->postRepository->update($newOrExistingPost);
            }
        }
        
        $this->persistenceManager->persistAll();
    }
    
    public function updatePostProperties(PostInterface $a, PostInterface $b): void
    {
        $a->setSocialId($b->getSocialId());
        $a->setPid($b->getPid());
        $a->setDatetime($b->getDatetime());
        $a->setTitle($b->getTitle());
        $a->setContent($b->getContent());
        $a->setMediaUrl($b->getMediaUrl());
        $a->setPosterUrl($b->getPosterUrl());
        $a->setUrl($b->getUrl());
    }
    
    protected function persistMedia(PostInterface $post): void
    {
        if (empty($post->getPosterUrl())) {
            return;
        }
        $fileExtension = pathinfo(parse_url($post->getPosterUrl(), PHP_URL_PATH), PATHINFO_EXTENSION);
        $fileName = sprintf('%s.%s', $post->getSocialId(), $fileExtension);
        $file = $this->assetStorageFolder->getFile($fileName) ?? $this->assetStorageFolder->createFile($fileName);
        $file->setContents(file_get_contents($post->getPosterUrl()));
        
        $extbaseFileReference = $post->getPoster()->current() ?? new ExtbaseFileReference();
        $fileReference = new FileReference([
            'uid_local' => $file->getUid(),
            'uid_foreign' => uniqid('NEW_'),
            'uid' => uniqid('NEW_'),
            'crop' => null
        ]);
        $extbaseFileReference->setOriginalResource($fileReference);
        
        $post->getPoster()->removeAll($post->getPoster());
        $post->getPoster()->attach($extbaseFileReference);
    }
    
}
