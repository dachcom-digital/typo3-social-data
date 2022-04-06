<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\FormEngine\Element;

use DachcomDigital\SocialData\Connector\ConnectorInterface;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractConnectorStatusElement extends AbstractFormElement
{
    public const NODE_NAME = 'socialDataConnectorStatus';
    
    protected array $connectorConfiguration = [];
    
    public function render()
    {
        throw new \Exception(sprintf('class %s must implement method %s!', __CLASS__, __METHOD__));
    }
    
    abstract protected function validateConnectorConfiguration(): bool;
    
    /**
     * returns the parsed array of the flex form
     *
     * yes, this is awful.
     */
    protected function getConnectorConfiguration(): array
    {
        if (!empty($this->connectorConfiguration)) {
            return $this->connectorConfiguration;
        }
        $flexformString = $this->getFlexFormTools()->flexArray2Xml($this->data['databaseRow']['connector_configuration']);
        $this->connectorConfiguration = $this->getFlexFormService()->convertFlexFormContentToArray($flexformString);
        return $this->connectorConfiguration;
    }
    
    protected function isConnectorConnected(): bool
    {
        return $this->data['databaseRow']['connector_status'] === ConnectorInterface::STATUS_CONNECTED;
    }
    
    protected function getFlexFormService(): FlexFormService
    {
        return GeneralUtility::makeInstance(FlexFormService::class);
    }
    
    protected function getFlexFormTools(): FlexFormTools
    {
        return GeneralUtility::makeInstance(FlexFormTools::class);
    }
    
    protected function renderStatusMessage(string $message, string $type = '', array $attributes = [], string $iconIdentifier = null): string
    {
        $alertClass = !empty($type) ? 'alert-' . $type : '';
        $html = [];
        $html[] = '<div class="my-2 d-flex alert ' . $alertClass . '" ' . GeneralUtility::implodeAttributes($attributes, true) . '>';
        $html[] =   '<div class="mx-2">';
        $html[] =      !empty($iconIdentifier) ? $this->iconFactory->getIcon($iconIdentifier, Icon::SIZE_SMALL) : '';;
        $html[] =   '</div>';
        $html[] =   '<div>';
        $html[] =      $message;
        $html[] =   '</div>';
        $html[] = '</div>';
        
        return implode(LF, $html);
    }
    
    protected function renderButton(string $title, string $type = 'default', array $attributes = [], string $iconIdentifier = null): string
    {
        $btnClass = !empty($type) ? 'btn-' . $type : '';
        $html = [];
        $html[] = '<button type="button" class="btn '. $btnClass . '" ' . GeneralUtility::implodeAttributes($attributes, true) . '>';
        $html[] =   !empty($iconIdentifier) ? $this->iconFactory->getIcon($iconIdentifier, Icon::SIZE_SMALL) : '';
        $html[] =   $title;
        $html[] = '</button>';
    
        return implode(LF, $html);
    }
}
