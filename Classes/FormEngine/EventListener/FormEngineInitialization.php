<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\FormEngine\EventListener;

use DachcomDigital\SocialData\Domain\Model\Feed;
use DachcomDigital\SocialData\Domain\Repository\FeedRepository;
use DachcomDigital\SocialData\Registry\ConnectorDefinitionRegistry;
use TYPO3\CMS\Backend\Controller\Event\BeforeFormEnginePageInitializedEvent;
use TYPO3\CMS\Core\Page\PageRenderer;
use function Deployer\timestamp;

class FormEngineInitialization
{
    protected FeedRepository $feedRepository;
    protected ConnectorDefinitionRegistry $connectorRegistry;
    protected PageRenderer $pageRenderer;
    
    public function __construct(PageRenderer $pageRenderer, ConnectorDefinitionRegistry $connectorRegistry, FeedRepository $feedRepository)
    {
        $this->pageRenderer = $pageRenderer;
        $this->connectorRegistry = $connectorRegistry;
        $this->feedRepository = $feedRepository;
    }
    
    public function onInitialize(BeforeFormEnginePageInitializedEvent $event)
    {
        $queryParams = $event->getRequest()->getQueryParams();
        if (array_key_exists('tx_socialdata_domain_model_feed', $queryParams['edit'])) {
            $feedId = array_key_first($queryParams['edit']['tx_socialdata_domain_model_feed']);
            if ($queryParams['edit']['tx_socialdata_domain_model_feed'][$feedId] == 'edit') {
                $feed = $this->feedRepository->findByUid($feedId);
                if ($feed instanceof Feed) {
                    $this->adjustConnectorForm($feed);
                }
            }
        }
    }
    
    protected function adjustConnectorForm(Feed $feed) {
        $connectorId = $feed->getConnectorIdentifier();
        if ($this->connectorRegistry->has($connectorId)) {
            $connectorDefinition = $this->connectorRegistry->get($connectorId);
            // set the flexform
            $GLOBALS['TCA']['tx_socialdata_domain_model_feed']['columns']['connector_configuration']['config']['ds'][$connectorId] =
                sprintf('FILE:%s', $connectorDefinition->getConnectorFeedConfiguration()->getFlexFormFile());
            
            // register corresponding field
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1648803119] = [
                'nodeName' => \DachcomDigital\SocialData\FormEngine\Element\AbstractConnectorStatusElement::NODE_NAME,
                'priority' => 40,
                'class' => $connectorDefinition->getConnectorFeedConfiguration()->getStatusFormElementClass(),
            ];
        }
    }
}
