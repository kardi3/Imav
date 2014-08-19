<?php

class Default_IndexController extends MF_Controller_Action
{
    /**
     * Homepage action controller
     */
    public static $producerCountPerPage = 12;
    public static $resultsCountPerPage = 10;
    
    public function layoutAction() { 
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $settingService = $this->_service->getService('Default_Service_Setting');
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        $route = $this->getFrontController()->getRouter()->getCurrentRouteName();
        
        $activeLanguages = $i18nService->getLanguageList();
        
        $pageService = $this->_service->getService('Page_Service_Page');

       if(!$footer = $pageService->getI18nPage('footer', 'type', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Footer not found');
        }
        
        if(!$homepage = $pageService->getI18nPage('homepage', 'type', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Homepage not found');
        }
        $settings = $settingService->getAllSettingsArray();
        
        if(isset($_POST['newsletter_submit'])){
            
            $values = array(
                'name' => $_POST['newsletter_mail'],
                'email' => $_POST['newsletter_mail']
            );
            try{
                $subscriberService->saveSubscriberFromArray($values);
                $_POST['newsletter_success'] = "Your email has been successfully registered";
            }
            catch(Exception $e){
                if($e->getCode()=="23000"){
                    $_POST['newsletter_error'] = "Your email is already in our database";
                }
            }
        }
//       var_dump(Zend_Controller_Front::getInstance()->getRouter()->getCurrentRouteName());exit;
        $this->view->assign('footer', $footer);
        $this->view->assign('homepage', $homepage);
        $this->view->assign('activeLanguages', $activeLanguages);
        
        $this->view->assign('route', $route);
        
        $this->_helper->actionStack('main', 'index', 'slider');
        $this->_helper->actionStack('last-news-slider', 'index', 'news');
        $this->_helper->actionStack('last-news-top', 'index', 'news');
        $this->_helper->actionStack('last-categories-news', 'index', 'news');
        $this->_helper->actionStack('popular-news', 'index', 'news');
        $this->_helper->actionStack('calendar', 'index', 'district');
        $this->_helper->actionStack('random-person', 'index', 'district');
        $this->_helper->actionStack('special-topic', 'index', 'district');
        $this->_helper->actionStack('main-menu');
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function indexAction() {
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $productService = $this->_service->getService('Product_Service_Product');
        
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        $photoDimension = $photoDimensionService->getElementDimension('productmain');
        $newProducts = $productService->getNewProducts();
        $promotionProducts = $productService->getPromotionProducts();
        
        
        if(!$homepage = $pageService->getI18nPage('homepage', 'type', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }
        
        if($homepage != NULL):
            $metatagService->setViewMetatags($homepage->get('Metatag'), $this->view);
        endif;
        
        $this->view->assign('homepage', $homepage);

        $this->_helper->actionStack('layout', 'index', 'default');
        $this->view->assign('photoDimension', $photoDimension);
        $this->view->assign('newProducts', $newProducts);
        $this->view->assign('promotionProducts', $promotionProducts);
    }
    
     
    
    
    public function sidebarAction(){
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        
        $partners = $partnerService->getAllActivePartners();
        $this->view->assign('partners', $partners);
        
        $this->_helper->viewRenderer->setResponseSegment('sidebar');
    }
    
    public function contactAction() {
        
        $this->_helper->layout->setLayout('page');
        
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $serviceService = $this->_service->getService('Default_Service_Service');
        $settingService = $this->_service->getService('Default_Service_Setting');
        
        $settings = $settingService->getAllSettingsArray();
        
        $company_address = $settings['company_address'];
        $company_name = $settings['company_name'];
        $company_city = $settings['company_city'];
        $company_postal_code = $settings['company_postal_code'];
        
        $this->view->assign('company_address', $company_address);
        $this->view->assign('company_name', $company_name);
        $this->view->assign('company_city', $company_city);
        $this->view->assign('company_postal_code', $company_postal_code);
        if(!$page = $pageService->getI18nPage('contact', 'type', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }
 
        $contactEmail = $settings['contact_email'];
        
        if ($page != NULL):
            $metatagService->setViewMetatags($page->get('Metatag'), $this->view);
        endif;
        $form = new Default_Form_Contact();
        
        $captchaDir = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('captchaDir');
        $form->addElement('captcha', 'captcha',
            array(
            'label' => 'Rewrite the chars', 
            'captcha' => array(
                'captcha' => 'Image',  
                'wordLen' => 5,  
                'timeout' => 300,  
                'font' => APPLICATION_PATH . '/../data/arial.ttf',  
                'imgDir' => $captchaDir,  
                'imgUrl' => $this->view->serverUrl() . '/captcha/',  
            )
        ));
        
          if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    if(!strlen($contactEmail)){
                        $this->_helper->redirector->gotoUrl($this->view->url(array('success' => 'fail'), 'domain-contact'));
                    }
                    $values = $form->getValues();
                    $serviceService->sendMail($values,$contactEmail);
                    
                    $form->reset();
                    $this->view->messages()->add($this->view->translate('Message sent'));
                  
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
         }}

        $this->view->assign('form', $form);
        $this->view->assign('page', $page);
        $this->view->assign('success',$this->getRequest()->getParam('success'));
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    
    public function rssNewsAction() {
      $newsService = $this->_service->getService('News_Service_News');
      $settingService = $this->_service->getService('Default_Service_Setting');
       
      $settings = $settingService->getAllSettingsArray();
        
      $articleEntries = $newsService->getArticles(50, Doctrine_Core::HYDRATE_ARRAY);
      
      $feed = new Zend_Feed_Writer_Feed;
      $feed->setTitle($settings['company_name'].' - Aktualności');
      $feed->setLink($this->_helper->url->url(array(), 'domain-default'));
      $feed->setFeedLink($this->_helper->url->url(array(), 'domain-rss-news'), 'atom');
      $feed->addAuthor(array(
          'name'  => $settings['company_name'],
          'email' => $settings['contact_email'],
          'uri'   => $this->_helper->url->url(array(), 'domain-default'),
      ));
      $feed->setDateModified(time());
      //$feed->addHub('http://pubsubhubbub.appspot.com/');
  
      foreach ($articleEntries as $articleEntry):
        $entry = $feed->createEntry();
        $entry->setTitle($articleEntry['Translation']['pl']['title']);
        $entry->setLink($this->_helper->url->url(array('slug' => $articleEntry['Translation']['pl']['slug']), 'domain-news-article'));

        $entry->setDateModified(time());
        $publish_date = strtotime($articleEntry['publish_date']);
        $entry->setDateCreated($publish_date);
        
        $entry->setDescription(MF_Text::truncate($articleEntry['Translation']['pl']['content'], 100));
        $entry->setContent($articleEntry['Translation']['pl']['content']);
        $feed->addEntry($entry);
      endforeach;

      $out = $feed->export('atom');
          
      header('Content-type: application/atom+xml');
      echo $out;
      
      $this->_helper->viewRenderer->setNoRender();
      $this->_helper->layout->disableLayout();
    }
    
    public function promotionsAction() {
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $page = $pageService->getI18nPage('promocje', 'slug', $this->language, Doctrine_Core::HYDRATE_RECORD);
        
        if ($page != NULL):
            $metatagService->setViewMetatags($page->get('Metatag'), $this->view);
        endif;

        $this->view->assign('page', $page);
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    public function aboutUsAction() {
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if(!$page = $pageService->getI18nPage('about-us', 'type', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }
        
        if ($page != NULL):
            $metatagService->setViewMetatags($page->get('Metatag'), $this->view);
        endif;
        
        $this->view->assign('page', $page);
        $this->_helper->actionStack('layout', 'index', 'default');
    }
 
    
    
    
    public function bannerAction() {
        $this->_helper->viewRenderer->setResponseSegment('slider');
        
        $bannerService = $this->_service->getService('Banner_Service_Banner');
        $banners = $bannerService->fetchBanners(3);
        $this->view->assign('banners', $banners);
        /*
        $this->_helper->viewRenderer->setResponseSegment('sidebar');
        
        $articleService = $this->_service->getService('Article_Service_Article');
        $bannerService = $this->_service->getService('Banner_Service_Banner');
        
        $sponsoredArticles = $articleService->getRecentArticles(3, Doctrine_Core::HYDRATE_ARRAY);
        
        $banners = $bannerService->fetchBanners(3);
        $this->view->assign('banners', $banners);

        $this->view->assign('sponsoredArticles', $sponsoredArticles);
         */
    }
    
     public function searchAction() {
        //$this->_helper->viewRenderer->setResponseSegment('search');

        $searchService = $this->_service->getService('Default_Service_Search');
        
        $form = $searchService->getSearchMainForm();
        $form->getElement('phrase')->setAttrib('class', 'search', 'placeholder');
        $form->getElement('phrase')->setAttrib('placeholder', 'Szukaj na stronie...');

       // $this->view->assign('form', $form);     
       // var_dump($this->view->language);
        //$this->_helper->actionStack('layout', 'index', 'default');
    }
    
    
    public function resultsSearchingAction() {    
        $searchService = $this->_service->getService('Default_Service_Search');
        $producerService = $this->_service->getService('Producer_Service_Producer');
        $productService = $this->_service->getService('Product_Service_Product');
        $newsService = $this->_service->getService('News_Service_News');
        
        $form = $searchService->getSearchMainForm();
        $form->getElement('phrase')->setAttrib('class', 'search');
        
        if($this->getRequest()->getParam('phrase')) { 
            if($form->isValid($this->getRequest()->getParams())) {

              $this->_service->get('doctrine')->getCurrentConnection()->setCharset('utf8');
                
              $phrase = $form->getElement('phrase')->getValue();
              
              $news = $newsService->searchNews($phrase,  Doctrine_Core::HYDRATE_ARRAY);
              $producers = $producerService->searchProducers($phrase,  Doctrine_Core::HYDRATE_ARRAY);
              $products = $productService->searchProducts($phrase,  Doctrine_Core::HYDRATE_ARRAY);
              $results = array();
              $results = array_merge($producers, $products, $news);
              $counter = count($results);
              uasort($results, array('self', 'sortByTitle'));
            }
        }   
       // $phrase = $this->getRequest()->getParam('phrase');

        //$query = http_build_query($results);
        if ($phrase == NULL):
            $results = array();
            $counter = count($results);
        endif;
        
        $adapter = new Zend_Paginator_Adapter_Array($results);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$resultsCountPerPage);
        
        $this->view->assign('counter', $counter); 
        $this->view->assign('phrase', $phrase);  
        $this->view->assign('paginator', $paginator); 
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public static function sortByTitle($array1, $array2) {
        return strcmp($array1['search_title'], $array2['search_title']);
    }
    public function newsletterAction()
    {
        $newsletterService = $this->_service->getService('Default_Service_Newsletter');
        $this->_helper->layout->setLayout('contact');
        
        $form = new Default_Form_Newsletter();
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $form->getValues();
                    $newsletterService->saveNewsletterFromArray($values);
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
             //   Zend_Debug::dump($modelCart->getPrices());
         }}
        $this->view->assign('form',$form);
   
    }
    
    public function mainMenuAction() {
        
        $menuService = $this->_service->getService('Menu_Service_Menu');
        
        $i18nService = $this->_service->getService('Default_Service_I18n');

        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$menu = $menuService->getMenu(1)) {
            throw new Zend_Controller_Action_Exception('Menu not found');
        }
        
        $treeRoot = $menuService->getMenuItemTree($menu, $adminLanguage->getId());
        $tree = $treeRoot[0]->getNode()->getChildren();
    
        $this->view->assign('root', $root);
        $this->view->assign('menu', $menu);
        $this->view->assign('tree', $tree);
        
        $this->_helper->viewRenderer->setResponseSegment('mainMenu');
    }
}
