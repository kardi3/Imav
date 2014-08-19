<?php

/**
 * Article_IndexController 
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Article_IndexController extends MF_Controller_Action {
    
    public static $articleItemCountPerPage = 12;
    
    public function indexAction() {
        $articleService = $this->_service->getService('Article_Service_Article');
        
        $query = $articleService->getArticlePaginationQuery();
        
        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $this->view->assign('paginator', $paginator);
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function articleAction() {
        $articleService = $this->_service->getService('Article_Service_Article');
        
        if(!$article = $articleService->getFullArticle($this->getRequest()->getParam('slug'), 'slug', Doctrine_Core::HYDRATE_ARRAY)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }
        
        $this->view->assign('article', $article);
        
        if($current = $this->view->breadcrumbscontainer->findOneBy('id', 'articlesitem')) {
            $current->setActive(true);
            $current->setLabel($article['title']);
        }
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
}

