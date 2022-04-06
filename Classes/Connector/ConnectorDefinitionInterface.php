<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Connector;

interface ConnectorDefinitionInterface
{
    public function getConnector(): ConnectorInterface;
    public function setConnector(ConnectorInterface $connector);
    
    public function getConnectorFeedConfiguration(): ConnectorFeedConfigurationInterface;
}
