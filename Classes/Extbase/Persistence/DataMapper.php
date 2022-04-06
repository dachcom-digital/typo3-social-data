<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Extbase\Persistence;

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\DataHandling\TableColumnType;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper as ExtbaseDataMapper;

class DataMapper extends ExtbaseDataMapper implements SingletonInterface
{
    
    public function getPlainValue($input, $columnMap = null)
    {
        if (
            $columnMap instanceof ColumnMap &&
            $columnMap->getType() instanceof TableColumnType &&
            $columnMap->getType()->equals(TableColumnType::FLEX) &&
            $columnMap->getPropertyName() == 'connectorConfiguration' &&
            is_array($input)
        ) {
            return GeneralUtility::makeInstance(FlexFormTools::class)->flexArray2Xml($this->prepareArray($input), true);
        }
        return parent::getPlainValue($input, $columnMap);
    }
    
    protected function prepareArray($array): array
    {
        $dataArray = [
            'data' => [
                'sDEF' => [
                    'lDEF' => []
                ]
            ]
        ];
        foreach ($array as $key => $value) {
            $dataArray['data']['sDEF']['lDEF'][$key] = ['vDEF' => $value];
        }
        return $dataArray;
    }
    
}
