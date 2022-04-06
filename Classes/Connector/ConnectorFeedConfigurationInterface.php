<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Connector;

interface ConnectorFeedConfigurationInterface
{
    /**
     * @return string
     *
     * returns path to flex form file, must be EXT: prefixed.
     */
    public function getFlexFormFile(): string;
    
    /**
     * @return string
     *
     * returns class name of status form element
     */
    public function getStatusFormElementClass(): string;
}
