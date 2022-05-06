<?php

declare(strict_types=1);

namespace DachcomDigital\SocialData\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference as ExtbaseFileReference;

class FileReference extends ExtbaseFileReference
{
    
    protected $tableLocal = 'sys_file';
    
    /**
     * @return string
     */
    public function getTableLocal(): string
    {
        return $this->tableLocal;
    }
    
    /**
     * @param string $tableLocal
     */
    public function setTableLocal(string $tableLocal): void
    {
        $this->tableLocal = $tableLocal;
    }
    
}
