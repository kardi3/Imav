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
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        $bannerService = $this->_service->getService('Banner_Service_Banner');
        $menuService = $this->_service->getService('Menu_Service_Menu');
        
       
        if(!$menu = $menuService->getMenu(1)) {
            throw new Zend_Controller_Action_Exception('Menu not found');
        }
        
        if(!$submenu = $menuService->getMenu(2)) {
            throw new Zend_Controller_Action_Exception('Submenu not found');
        }
        
        $treeRoot = $menuService->getMenuItemTree($menu, $this->view->language);
        $tree = $treeRoot[0]->getNode()->getChildren();
    
        $subtreeRoot = $menuService->getMenuItemTree($submenu, $this->view->language);
        $submenu_tree = $subtreeRoot[0]->getNode()->getChildren();
        
        $route = $this->getFrontController()->getRouter()->getCurrentRouteName();
        
        $activeLanguages = $i18nService->getLanguageList();
        
        $pageService = $this->_service->getService('Page_Service_Page');

//       if(!$footer = $pageService->getI18nPage('footer', 'type', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
//            throw new Zend_Controller_Action_Exception('Footer not found');
//        }
//        
        if(!$homepage = $pageService->getI18nPage('homepage', 'type', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Homepage not found');
        }
        
        if(isset($_POST['sign_newsletter'])){
            
            $values = array(
                'name' => $_POST['email'],
                'email' => $_POST['email']
            );
            try{
                if(!$subscriber = $subscriberService->getSubscriber($values['email'],'email')){
         
                    
                        $values['token'] = MF_Text::createUniqueToken($values['salt'].$values['email']);
                $subscriber = $subscriberService->saveSubscriberFromArray($values);
                $subscriber->link('Groups',1);
                $subscriber->save();
                $this->view->messages()->add('Twój mail został dodany do naszej bazy subskrybentów');
                   
        }
        else{
                $this->view->messages()->add('Ten mail jest już w naszej bazie','error');
            
        }
            }
            catch(Exception $e){
                var_dump($e->getMessage());exit;
                if($e->getCode()=="23000"){
                    $_POST['newsletter_error'] = "Your email is already in our database";
                }
            }
        }
        
        $this->view->assign('footer', $footer);
        $this->view->assign('homepage', $homepage);
        $this->view->assign('activeLanguages', $activeLanguages);
        
        $this->view->assign('menu', $menu);
        $this->view->assign('submenu_tree', $submenu_tree);
        $this->view->assign('tree', $tree);
        $this->view->assign('route', $route);
        
        
        $this->_helper->actionStack('banner-right', 'index', 'banner'); 
        $this->_helper->actionStack('banner-sidebar2', 'index', 'banner'); 
        $this->_helper->actionStack('banner-sidebar3', 'index', 'banner'); 
        $this->_helper->actionStack('breaking-news', 'index', 'news');
        $this->_helper->actionStack('last-categories-news', 'index', 'news');
       $this->_helper->actionStack('last-news-sidebar', 'index', 'news');
        $this->_helper->actionStack('slider');
        $this->_helper->actionStack('main-page-galleries', 'index', 'gallery');
        $this->_helper->actionStack('next-events', 'index', 'district');
         
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function indexAction() {
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        if(!$homepage = $pageService->getI18nPage('homepage', 'type', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }
        
        if($homepage != NULL):
            $metatagService->setViewMetatags($homepage->get('Metatag'), $this->view);
        endif;
        
        $this->view->assign('homepage', $homepage);

        $this->_helper->actionStack('last-news', 'index', 'news');
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
     
    
    
    public function sidebarAction(){
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        
        $partners = $partnerService->getAllActivePartners();
        $this->view->assign('partners', $partners);
        
        $this->_helper->viewRenderer->setResponseSegment('sidebar');
    }
    
    public function contactAction() {
        
        $this->_helper->layout->setLayout('gallery');
        
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
 
        $contactEmail = $this->getInvokeArg('bootstrap')->getOption('contact_email');
        
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
          if(isset($_POST['submit_contact'])) {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    if(!strlen($contactEmail)){
                        $this->_helper->redirector->gotoUrl($this->view->url(array('success' => 'fail'), 'domain-contact'));
                    }
                    $values = $_POST;
                    $serviceService->sendMail($values,$contactEmail);
                    
                    $this->view->messages()->add($this->view->translate('Message sent'));
                    $this->_helper->redirector->gotoUrl($this->view->url(array('success' => 'fail'), 'domain-contact'));
                  
         }

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
 
    public function sliderAction() {
        $this->_helper->viewRenderer->setResponseSegment('slider');
        $sliderService = $this->_service->getService('Slider_Service_Slider');
        $slideLayerService = $this->_service->getService('Slider_Service_SlideLayer');
        $mainSlides = $sliderService->getSlideTree();
        $mainSlides = $mainSlides->fetchTree(array('root_id' => 1));
        unset($mainSlides[0]);
        $this->view->assign('mainSlides',$mainSlides);
        $this->_helper->viewRenderer->setResponseSegment('slider');
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
         }}
        $this->view->assign('form',$form);
   
    }
    
    public function mainMenuAction() {
        
      
    }
    
}
