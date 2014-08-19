<?php

/**
 * Blog_IndexController
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Blog_IndexController extends MF_Controller_Action 
{
    public static $entriesItemCountPerPage = 5;
    
    public function indexAction() {
        
    }
    
//    public function blogAction() {
//        $blogService = $this->_service->getService('Blog_Service_Blog');
//        $escortService = $this->_service->getService('Escort_Service_Escort');
//        $locationService = $this->_service->getService('Location_Service_Location');
//        $bannerService = $this->_service->getService('Banner_Service_Banner');
//       
//        $language = $this->view->language;
//
//        if(!$blog = $blogService->getBlog($this->getRequest()->getParam('slug'), $language, 'bt.slug', Doctrine_Core::HYDRATE_ARRAY)) {
//            throw new Zend_Controller_Action_Exception('Blog not found');
//        }
//        
//        $blogLocation = $locationService->getLocation($blog['id'], 'blog_id');
//        $rootLocation = $locationService->getRootLocation($blogLocation->getId());
//        
//        $query = $blogService->getBlogEntryPaginationQuery((int) $blog['id'], $language);
//
//        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
//        $paginator = new Zend_Paginator($adapter);
//        $paginator->setCurrentPageNumber((int) $this->getRequest()->getParam('page', 1));
//        $paginator->setItemCountPerPage(self::$countItemsPerPageForBlogs);
//
//        $faceOfDayEscort = $escortService->getFaceOfDayEscort(Doctrine_Core::HYDRATE_ARRAY);
//        $this->view->assign('faceOfDayEscort', $faceOfDayEscort);
//
//        $locationBanners = $bannerService->getBannersForLocations($rootLocation->getNode()->getDescendants(null, true)->getPrimaryKeys(), Doctrine_Core::HYDRATE_ARRAY);
//        $homeBanners = $bannerService->getBannersForRange('home', Doctrine_Core::HYDRATE_ARRAY);
//        $banners = array_merge_recursive($locationBanners, $homeBanners);
//        $this->view->assign('banners', $banners);
//        
//        $bannerItems = array();
//        if(isset($banners['top'])) {
//            $banners['top'] = array_slice($banners['top'], 0, 1);
//        }
//        foreach($banners as $position => $items) {
//            $bannerItems = array_merge($bannerItems, $items);
//        }
//        $bannerService->incrementViews($bannerItems);
//        
//        $this->view->assign('blog', $blog);
//        $this->view->assign('paginator', $paginator);
//        $this->view->assign('rootLocation', $rootLocation);
//        $this->view->assign('banners', $banners);
//
//        // metatags
//        $metaTitle = $blog['Translation'][$language]['meta_title'] . ' Blog'; 
//        $this->view->headTitle($metaTitle, 'SET');
//        $this->view->headMeta($blog['Translation'][$language]['meta_description'], 'description');
//        $this->view->headMeta($blog['Translation'][$language]['meta_keywords'], 'keywords');
//
//        $this->_helper->actionStack('layout', 'index', 'default');
//    }
    
    public function entriesAction() {
        $blogService = $this->_service->getService('Blog_Service_Blog');
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $page = $pageService->getI18nPage('blog', 'slug', $this->language, Doctrine_Core::HYDRATE_RECORD);
        
        if ($page != NULL):
            $metatagService->setViewMetatags($page->get('Metatag'), $this->view);
        endif;
        
        $query = $blogService->getEntriesPaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$entriesItemCountPerPage);
        
        $this->view->assign('paginator', $paginator);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        //$this->_helper->actionStack('layout', 'index', 'default');
        
//        $blogService = $this->_service->getService('Blog_Service_Blog');
//        $blogEntries = $blogService->getBlogEntries(50, Doctrine_Core::HYDRATE_ARRAY);
//        
//        $this->view->assign('blogEntries', $blogEntries);
        /*$blogService = $this->_service->getService('Blog_Service_Blog');
        $escortService = $this->_service->getService('Escort_Service_Escort');
        $locationService = $this->_service->getService('Location_Service_Location');
        $bannerService = $this->_service->getService('Banner_Service_Banner');
      
        $language = $this->view->language;
    
        if(!$blogEntry = $blogService->getBlogEntryBySlugAndDateAndLanguage($this->getRequest()->getParam('slug'), $this->getRequest()->getParam('date'), $language, Doctrine_Core::HYDRATE_ARRAY)) {
            throw new Zend_Controller_Action_Exception('Blog entry not found');
        }
        
        $blog = $blogService->getBlog((int) $blogEntry['blog_id'], $language, 'id', Doctrine_Core::HYDRATE_ARRAY);

        $blogLocation = $locationService->getLocation($blog['id'], 'blog_id');
        $rootLocation = $locationService->getRootLocation($blogLocation->getId());
        
        $lastBlogEntries = $blogService->getLastBlogEntries($blogEntry['blog_id'], 0, $language, Doctrine_Core::HYDRATE_ARRAY);

        $faceOfDayEscort = $escortService->getFaceOfDayEscort(Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('faceOfDayEscort', $faceOfDayEscort);

        $locationBanners = $bannerService->getBannersForLocations($rootLocation->getNode()->getDescendants(null, true)->getPrimaryKeys(), Doctrine_Core::HYDRATE_ARRAY);
        $homeBanners = $bannerService->getBannersForRange('home', Doctrine_Core::HYDRATE_ARRAY);
        $banners = array_merge_recursive($locationBanners, $homeBanners);
        $this->view->assign('banners', $banners);
        
        $bannerItems = array();
        if(isset($banners['top'])) {
            $banners['top'] = array_slice($banners['top'], 0, 1);
        }
        foreach($banners as $position => $items) {
            $bannerItems = array_merge($bannerItems, $items);
        }
        $bannerService->incrementViews($bannerItems);
        
        $this->view->assign('blogEntry', $blogEntry);
        $this->view->assign('blog', $blog);
        $this->view->assign('lastBlogEntries', $lastBlogEntries);
        $this->view->assign('rootLocation', $rootLocation);
        $this->view->assign('banners', $banners);
        
        // metatags
        $metaTitle = $blogEntry['Translation'][$language]['meta_title'] . ' - ' . $blog['Translation'][$language]['meta_title'] . ' Blog'; 
        $this->view->headTitle($metaTitle, 'SET');
        $this->view->headMeta($blogEntry['Translation'][$language]['meta_description'], 'description');
        $this->view->headMeta($blogEntry['Translation'][$language]['meta_keywords'], 'keywords');

        $this->_helper->actionStack('build-layout', 'index', 'default');
         
         */
    }
    
    public function entryAction() {
        $blogService = $this->_service->getService('Blog_Service_Blog');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if(!$entry = $blogService->getFullEntry($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Entry not found', 404);
        }
         
        $metatagService->setViewMetatags($entry->get('Metatags'), $this->view);
       
        $entry = $entry->toArray();
        $this->view->assign('entry', $entry);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        //$this->_helper->actionStack('layout', 'index', 'default');
        
/*
    
        if(!$blogEntry = $blogService->getBlogEntryBySlugAndDateAndLanguage($this->getRequest()->getParam('slug'), $this->getRequest()->getParam('date'), $language, Doctrine_Core::HYDRATE_ARRAY)) {
            throw new Zend_Controller_Action_Exception('Blog entry not found');
        }
        
        $blog = $blogService->getBlog((int) $blogEntry['blog_id'], $language, 'id', Doctrine_Core::HYDRATE_ARRAY);

        $blogLocation = $locationService->getLocation($blog['id'], 'blog_id');
        $rootLocation = $locationService->getRootLocation($blogLocation->getId());
        
        $lastBlogEntries = $blogService->getLastBlogEntries($blogEntry['blog_id'], 0, $language, Doctrine_Core::HYDRATE_ARRAY);

        $faceOfDayEscort = $escortService->getFaceOfDayEscort(Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('faceOfDayEscort', $faceOfDayEscort);

        $locationBanners = $bannerService->getBannersForLocations($rootLocation->getNode()->getDescendants(null, true)->getPrimaryKeys(), Doctrine_Core::HYDRATE_ARRAY);
        $homeBanners = $bannerService->getBannersForRange('home', Doctrine_Core::HYDRATE_ARRAY);
        $banners = array_merge_recursive($locationBanners, $homeBanners);
        $this->view->assign('banners', $banners);
        
        $bannerItems = array();
        if(isset($banners['top'])) {
            $banners['top'] = array_slice($banners['top'], 0, 1);
        }
        foreach($banners as $position => $items) {
            $bannerItems = array_merge($bannerItems, $items);
        }
        $bannerService->incrementViews($bannerItems);
        
        $this->view->assign('blogEntry', $blogEntry);
        $this->view->assign('blog', $blog);
        $this->view->assign('lastBlogEntries', $lastBlogEntries);
        $this->view->assign('rootLocation', $rootLocation);
        $this->view->assign('banners', $banners);
        
        // metatags
        $metaTitle = $blogEntry['Translation'][$language]['meta_title'] . ' - ' . $blog['Translation'][$language]['meta_title'] . ' Blog'; 
        $this->view->headTitle($metaTitle, 'SET');
        $this->view->headMeta($blogEntry['Translation'][$language]['meta_description'], 'description');
        $this->view->headMeta($blogEntry['Translation'][$language]['meta_keywords'], 'keywords');

        $this->_helper->actionStack('build-layout', 'index', 'default');
         
         */
    }
    
}

