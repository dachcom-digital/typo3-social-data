<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Connector;

abstract class AbstractConnectorDefinition implements ConnectorDefinitionInterface
{
    protected ConnectorInterface $connector;
    
    public function setConnector(ConnectorInterface $connector): void
    {
        $this->connector = $connector;
    }
    
    public function getConnector(): ConnectorInterface
    {
        return $this->connector;
    }
}
