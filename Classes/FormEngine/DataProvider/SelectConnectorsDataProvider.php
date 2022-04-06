<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\FormEngine\DataProvider;

use DachcomDigital\SocialData\Registry\ConnectorDefinitionRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SelectConnectorsDataProvider
{
    
    public function getOptions(&$params)
    {
        foreach ($this->getConnectorRegistry()->getConnectors() as $identifier => $connector) {
            $params['items'][] = [get_class($connector), $identifier];
        }
    }
    
    /**
     * @return ConnectorDefinitionRegistry
     *
     * @deprecated remove when itemsProcFunc supports symfony services. use symfony DI then.
     */
    protected function getConnectorRegistry()
    {
        return GeneralUtility::makeInstance(ConnectorDefinitionRegistry::class);
    }
}
