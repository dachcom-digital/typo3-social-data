<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Controller;

use DachcomDigital\SocialData\Domain\Model\Wall;
use DachcomDigital\SocialData\Domain\Repository\WallRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class WallController extends ActionController
{
    
    protected wallRepository $wallRepository;
    
    public function __construct(WallRepository $wallRepository)
    {
        $this->wallRepository = $wallRepository;
    }
    
    public function showAction(): ResponseInterface
    {
        $wallId = $this->settings['wall'];
        $wall = $this->wallRepository->findByUid($wallId);
        
        if (!$wall instanceof Wall) {
            return (new HtmlResponse('no wall found'))->withStatus(404);
        }
        
        $this->view->assign('wall', $wall);
        
        return $this->htmlResponse();
    }
    
}
