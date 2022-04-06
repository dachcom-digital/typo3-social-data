<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Connector;

interface ConnectorInterface
{
    public const STATUS_CONNECTED = 'connected';
    
    public function setConfiguration(array $configuration);
    public function fetchItems(): array;
}
