<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

class PostRepository extends Repository
{
    public function findBySocialId(string $socialId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('social_id', $socialId));
        return $query->execute()->getFirst();
    }
    
}
