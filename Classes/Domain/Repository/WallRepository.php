<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Repository;

use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;

class WallRepository extends Repository
{

    public function __construct(ObjectManagerInterface $objectManager)
    {
        parent::__construct($objectManager);
        $defaultQuerySettings = $objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(false);
        $this->defaultQuerySettings = $defaultQuerySettings;
    }
}
