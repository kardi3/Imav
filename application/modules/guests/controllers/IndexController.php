<?php

/**
 * Guest_IndexController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Guests_IndexController extends MF_Controller_Action {
   
     public static $entriesItemCountPerPage = 2;
    
    public function indexAction() {
        
    }
    
    public function postsAction() {
        $guestsService = $this->_service->getService('Guests_Service_Guests');
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $page = $pageService->getI18nPage('ksiega-gosci', 'slug', $this->language, Doctrine_Core::HYDRATE_RECORD);
        
        if ($page != NULL):
            $metatagService->setViewMetatags($page->get('Metatag'), $this->view);
        endif;
        
        $query = $guestsService->getEntriesPaginationQuery();

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$entriesItemCountPerPage);
        
        $this->view->assign('paginator', $paginator);
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
}

