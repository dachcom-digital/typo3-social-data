<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Repository;

use DachcomDigital\SocialData\Domain\Model\Feed;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class PostRepository extends Repository
{
    protected $defaultOrderings = ['datetime' => QueryInterface::ORDER_DESCENDING];
    
    public function __construct(ObjectManagerInterface $objectManager)
    {
        parent::__construct($objectManager);
        $querySettings = $objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $querySettings->setRespectSysLanguage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
    
    public function findOneBySocialId(string $socialId): ?object
    {
        $query = $this->createQuery();
        $query->matching($query->equals('socialId', $socialId));
        return $query->execute()->getFirst();
    }
    
    public function findByFeed(Feed $feed, ?int $limit = null): QueryResult
    {
        $query = $this->createQuery();
        $query->matching($query->equals('feed', $feed));
        $limit !== null && $query->setLimit($limit);
        return $query->execute();
    }
    
}
