<?php

/**
 * News_IndexController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class News_IndexController extends MF_Controller_Action {
 
    public static $articleItemCountPerPage = 10;
    
    public function indexAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $linkService = $this->_service->getService('Link_Service_Link');
        
        $query = $newsService->getArticlePaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $this->view->assign('linkService', $linkService);
        $this->view->assign('paginator', $paginator);
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function lastNewsSliderAction() {
        $newsService = $this->_service->getService('News_Service_News');
        
        $lastNews = $newsService->getLastNews(4,Doctrine_Core::HYDRATE_ARRAY);
        
        $this->view->assign('lastNews', $lastNews);
        
        
        $this->_helper->viewRenderer->setResponseSegment('lastNewsSlider');
    }
    
    public function lastNewsTopAction() {
        $newsService = $this->_service->getService('News_Service_News');
        
        $lastNews = $newsService->getLastNews(6,Doctrine_Core::HYDRATE_ARRAY);
        
        $this->view->assign('lastNews', $lastNews);
        
        
        $this->_helper->viewRenderer->setResponseSegment('lastNewsTop');
    }
    
    public function lastCategoriesNewsAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $categoryService = $this->_service->getService('News_Service_Category');
        
        
        $categories = $categoryService->getAllCategories();
        
        $newsList = array();
        foreach($categories as $category):
            $newsList[$category['title']] = $newsService->getLastCategoryNews($category['id'],2,Doctrine_Core::HYDRATE_ARRAY);
        endforeach;
        
        $this->view->assign('newsList', $newsList);
        
        
        $this->_helper->viewRenderer->setResponseSegment('lastCategoriesNews');
    }
    
    public function popularNewsAction() {
        $newsService = $this->_service->getService('News_Service_News');
        
        $popularNews = $newsService->getPopularNews(3,Doctrine_Core::HYDRATE_ARRAY);
        
        $this->view->assign('popularNews', $popularNews);
        
        
        $this->_helper->viewRenderer->setResponseSegment('popularNews');
    }
    
    public function articlesAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $linkService = $this->_service->getService('Link_Service_Link');
        
        $pageMain = $pageService->fetchPage('news', 'pl', Doctrine_Core::HYDRATE_RECORD);
        $metatagService->setViewMetatags($pageMain->get('Metatag'), $this->view);
        
        $query = $newsService->getArticlePaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $this->view->assign('linkService', $linkService);
        $this->view->assign('paginator', $paginator);
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function categoryAction(){
        
    }
    
    public function articleAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $commentService = $this->_service->getService('News_Service_Comment');
        
        
        if(!$article = $newsService->getFullArticle($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Article not found', 404);
        }
        
        $article->increaseView();
        
        $metatagService->setViewMetatags($article->get('Metatags'), $this->view);
       
        $comments = $commentService->getNewsComments($article['id'],Doctrine_Core::HYDRATE_ARRAY);
        $comments_count = $commentService->countNewsComments($article['id'],Doctrine_Core::HYDRATE_SINGLE_SCALAR);
        $this->view->assign('article', $article);
        $this->view->assign('comments', $comments);
        $this->view->assign('comment_count', $comments_count);
        
        if(isset($_POST['submit_comment'])){

            $values = $_POST;
            $values['news_id'] = $article['id'];
            
            $commentService->addComment($values,$article['id']);
                        
            return $this->_helper->redirector->goToUrl($this->view->url(array('slug' => $article['Translation'][$this->view->language]['slug']),'domain-news-article')); 
        }
        
        
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
    
      public function listNewsSerwis10Action()
    {
        $newsService = $this->_service->getService('News_Service_NewsSerwis1');
        $pageService = $this->_service->getService('Page_Service_PageSerwis10');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $linkService = $this->_service->getService('Link_Service_Link');
        
        if(!$page = $pageService->getPage('news-reviews', 'type')) {
        }
        else
            $metatagService->setViewMetatags($page['metatag_id'], $this->view);
        
        $adapter = new MF_Paginator_Adapter_Doctrine($newsService->getNewsServiceQuery(10), Doctrine_Core::HYDRATE_RECORD);
        
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $this->view->assign('linkService', $linkService);
        
        $newsList = $newsService->getAllServiceNews(10,'as.id',10);
        $this->view->assign('newsList', $newsList);
        
        $this->view->assign('paginator', $paginator);
        $this->_helper->actionStack('layout.serwis8', 'index', 'default');
    }
    
  
     public function newsSerwis10Action() {
        $newsService = $this->_service->getService('News_Service_NewsSerwis1');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $linkService = $this->_service->getService('Link_Service_Link');
        
        $item = $newsService->getFullNews($this->getRequest()->getParam('slug'),'slug');
        $metatagService->setViewMetatags($item['metatag_id'], $this->view);
        
        $this->view->assign('linkService', $linkService);
        $this->view->assign('item', $item);
        
        $newsList = $newsService->getAllServiceNews(10,'as.id',10);
        $this->view->assign('newsList', $newsList);
        
        $this->_helper->actionStack('layout.serwis10', 'index', 'default');
    }
    
    public function facebookAction(){
        
    }
    
}

