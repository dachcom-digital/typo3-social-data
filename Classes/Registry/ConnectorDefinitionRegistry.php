<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Registry;

use DachcomDigital\SocialData\Connector\ConnectorDefinitionInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Connector Registry
 *
 * implementing TYPO3's SingletonInterface is important to retrieve the same instance
 * via symfony container as well as with GeneralUtility::makeInstance.
 * Yes, this is awful.
 */
class ConnectorDefinitionRegistry implements SingletonInterface {
    
    protected array $connectors = [];
    
    public function register($service, $id)
    {
        if (!in_array(ConnectorDefinitionInterface::class, class_implements($service), true)) {
            throw new \InvalidArgumentException(
                sprintf('%s needs to implement "%s", "%s" given.', get_class($service), ConnectorDefinitionInterface::class, implode(', ', class_implements($service)))
            );
        }
        $this->connectors[$id] = $service;
    }
    
    /**
     * @return array
     */
    public function getConnectors(): array
    {
        return $this->connectors;
    }
    
    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->connectors);
    }
    
    /**
     * @param string $id
     * @return ConnectorDefinitionInterface|null
     */
    public function get(string $id): ?ConnectorDefinitionInterface
    {
        if ($this->has($id)) {
            return $this->connectors[$id];
        }
        return null;
    }
    
}
