<?php

/**
 * Gallery_IndexController
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Gallery_IndexController extends MF_Controller_Action {
    
    
    public static $galleryItemCountPerPage = 6;
    
    public function indexAction() {
       
        $this->_helper->layout->setLayout('gallery');
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if(!$gallery = $galleryService->getI18nGallery($this->getRequest()->getParam('slug'), 'slug', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
        }
        
        $lastCategoryOtherGalleries = $galleryService->getLastCategoryOtherGalleries($gallery,Doctrine_Core::HYDRATE_ARRAY);
        
        
        $metatagService->setViewMetatags($gallery['metatag_id'], $this->view);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->view->assign('lastCategoryOtherGalleries', $lastCategoryOtherGalleries);
        $this->view->assign('gallery', $gallery);
    }
    
    public function listGalleryAction() {
       
        $this->_helper->layout->setLayout('gallery');
        
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
//
        
         $query = $galleryService->getGalleryPaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$galleryItemCountPerPage);
        
       $page = $pageService->getPage('studencka-tworczosc','type');
//        
        $metatagService->setViewMetatags($page['metatag_id'], $this->view);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->view->assign('paginator', $paginator);
    }
    
    public function listCategoryGalleryAction() {
       
        $this->_helper->layout->setLayout('article');
        
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $categoryService = $this->_service->getService('Gallery_Service_Category');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if(!$category = $categoryService->getI18nCategory($this->getRequest()->getParam('category'), 'slug', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Category not found');
        }
        $galleries = $galleryService->getCategoryGalleries($category['id'],3,Doctrine_Core::HYDRATE_ARRAY);
        
        $metatagService->setViewMetatags($category['metatag_id'], $this->view);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->view->assign('category', $category);
        $this->view->assign('galleries', $galleries);
    }
    
    public function mainPageGalleriesAction() {
            
        $galleriesService = $this->_service->getService('Gallery_Service_Gallery');
        
        $mainPageGalleries = $galleriesService->getMainPageGalleries(Doctrine_Core::HYDRATE_ARRAY);
        
        $this->_helper->viewRenderer->setResponseSegment('mainPageGalleries');
        
        $this->view->assign('mainPageGalleries', $mainPageGalleries);
    }
}

