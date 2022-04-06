<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\EventListener;

use DachcomDigital\SocialData\Domain\Model\Feed;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Extbase\Event\Persistence\AfterObjectThawedEvent;

class ExtbasePersistenceListener
{
    protected FlexFormService $flexFormService;
    
    public function __construct(FlexFormService $flexFormService)
    {
        $this->flexFormService = $flexFormService;
    }
    
    public function modifyQueryResult(AfterObjectThawedEvent $event)
    {
        $object = $event->getObject();
        if ($object instanceof Feed) {
            $originalRecord = $event->getRecord();
            
            if (!empty($originalRecord['connector_configuration'])) {
                $object->setConnectorConfiguration($this->flexFormService->convertFlexFormContentToArray($originalRecord['connector_configuration']));
            }
        }
    }
    
}
