<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\Controller;

use DachcomDigital\SocialData\Domain\Model\Post;
use DachcomDigital\SocialData\Domain\Model\Wall;
use DachcomDigital\SocialData\Domain\Repository\PostRepository;
use DachcomDigital\SocialData\Domain\Repository\WallRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class WallController extends ActionController
{
    
    protected WallRepository $wallRepository;
    protected PostRepository $postRepository;
    
    public function __construct(WallRepository $wallRepository, PostRepository $postRepository)
    {
        $this->wallRepository = $wallRepository;
        $this->postRepository = $postRepository;
    }
    
    public function showAction(): ResponseInterface
    {
        $wallId = $this->settings['wall'];
        $wall = $this->wallRepository->findByUid($wallId);
        
        if (!$wall instanceof Wall) {
            return (new HtmlResponse('no wall found'))->withStatus(404);
        }
        
        $limit = !empty($this->settings['limit']) ? (int)$this->settings['limit'] : null;
        
        $posts = [];
        foreach ($wall->getFeeds() as $feed) {
            $posts = array_merge($posts, $this->postRepository->findByFeed($feed, $limit)->toArray());
        }
        usort($posts, function(Post $postA, Post $postB) {
            return $postA->getDatetime() <= $postB->getDatetime();
        });
        $limit && array_splice($posts, $limit);
        
        $itemsPerPage = (int)(($this->settings['itemsPerPage'] ?? null) ?: 10);
        $currentPage = $this->request->getQueryParams()['page'] ? (int)$this->request->getQueryParams()['page'] : 1;
        
        $paginator = new ArrayPaginator($posts, $currentPage, $itemsPerPage);
        
        $pagination = new SimplePagination($paginator);
        
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => $pagination,
            'wall' => $wall
        ]);
        
        return $this->htmlResponse();
    }
    
}
