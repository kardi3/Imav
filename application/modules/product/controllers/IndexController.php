<?php

/**
 * Product_IndexController 
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_IndexController extends MF_Controller_Action {
    
    public static $productCountPerPage = 10;
    public static $producerProductCountPerPage = 10;
    public static $producerCountPerPage = 10;
    
    public function listBestsellerAction(){
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function listCategoryAction(){
//        $categoryService = $tchis->_service->getService('Product_Service_Category');
        
//        $categories = $categoryService->getAllCategories();
        
         $productService = $this->_service->getService('Product_Service_Product');
        $products = $productService->getAllProducts();

        $this->view->assign('products', $products);
        $this->_helper->actionStack('category-header');
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function categoryAction() {
      
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $productService = $this->_service->getService('Product_Service_Product');
        $categoryService = $this->_service->getService('Product_Service_Category');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
        
        $photoDimension = $photoDimensionService->getElementDimension('product');
        
        if(!$category = $categoryService->getFullCategory($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Category not found', 404);
        }
          $products = $productService->getCategoryProducts($category->id);
        
        $metatagService->setViewMetatags($category->get('Metatags'), $this->view);
                
        $this->view->assign('products', $products);
        $this->view->assign('category', $category);
        $this->view->assign('photoDimension', $photoDimension);

    }
    
    public function categorySidebarAction() {
              
        $categoryService = $this->_service->getService('Product_Service_Category');
        
        if(!$category = $categoryService->getFullCategory('Kategorie', 'name')) {
            throw new Zend_Controller_Action_Exception('Category Kategorie not found', 404);
        }
        
        
        $this->view->assign('categoryTree',$category->getNode()->getChildren());

        $this->_helper->viewRenderer->setResponseSegment('sidebar');
    }
    
    public function categoryMenuTreeAction()
    {
        $categoryService = $this->_service->getService('Product_Service_Category');
        
        if(!$category = $categoryService->getFullCategory($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Category '.$this->getRequest()->getParam('slug').' not found', 404);
        }
            
        // jeżeli kategoria nie ma childrenów to nie jest wyświetlany widok
        // po to aby uniknąć wyświetlania się pustej listy ul
        
        if(!$category->getNode()->hasChildren()){
            $this->_helper->viewRenderer->setNoRender();
        }
        $this->view->assign('category',$category);
        $this->view->assign('categoryTree',$category->getNode()->getChildren());
    }
    
    public function productAction() {
        
         if($this->view->messages()->count()>1): 
             $this->view->messages()->clear();
         endif; 
        
        $productService = $this->_service->getService('Product_Service_Product');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if(!$product = $productService->getFullProduct($this->getRequest()->getParam('product'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Product not found', 404);
        }
        $metatagService->setViewMetatags($product->get('metatag_id'), $this->view);

       
        $form = new Product_Form_Contact();        
        
        $session = new Zend_Session_Namespace('CONTACT_CSRF');
        $form->getElement('csrf')->setSession($session)->initCsrfValidator();
        
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
        
        $contactEmail = $this->getFrontController()->getParam('bootstrap')->getOption('contact_email');

        if(!$contactEmail) {
            throw new Zend_Controller_Action_Exception('Contact email address not set');
        }
            
        $mail = new Zend_Mail('UTF-8');
        $mail->addTo($contactEmail);
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $bodyText = "Mail kontaktowy od : ".$form->getValue('name')." ".$form->getValue('lastName')."\nDane kontaktowe: telefon - ".$form->getValue('phone')." email ".$form->getValue('email')." \n";
                    
                    $mail->setReplyTo($form->getValue('email'));
                    $mail->setSubject("Zapytanie o przedmiot ".$product['Translation'][$this->language]['name']." Identyfikator: ".$product['id']);
                    $mail->setBodyText($bodyText.$form->getValue('message'));
                    $mail->setFrom($contactEmail,$form->getValue('name'));
                    $mail->addTo('info@dodusmaszyny.pl');
                    $mail->addTo($contactEmail);
                    $mail->send();
                    $form->reset();
                    $this->view->messages()->add($this->view->translate('Message sent'));
                    
                } catch(Exception $e) {
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
            
        }
        $this->view->assign('form',$form);
        $this->view->assign('product', $product);
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function listDiscountAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function promotionAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function listProducerAction(){
        $producerService = $this->_service->getService('Product_Service_Producer');
        
        $producers = $producerService->getAllProducers($this->view->language,Doctrine_Core::HYDRATE_ARRAY);
      //  Zend_Debug::dump($producers);exit;
        $this->view->assign('producers', $producers);
        
        $this->_helper->viewRenderer->setResponseSegment('producerFooter');
    }
    
    public function searchAction() {
      
        $productService = $this->_service->getService('Product_Service_Product');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
        $photoDimension = $photoDimensionService->getElementDimension('product');
        
        $query = $this->getRequest()->getParam('query');
        
        $products = $productService->searchProducts($query);
        $this->view->assign('products', $products);
        $this->view->assign('query',$query);
        $this->view->assign('photoDimension', $photoDimension);
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
   
    
      public function newProductsAction() {
        $productService = $this->_service->getService('Product_Service_Product');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        $pageService = $this->_service->getService('Page_Service_Page');
        
        $photoDimension = $photoDimensionService->getElementDimension('productmain');
        $products = $productService->getNewProducts();
        
        $page = $pageService->geti18nPage('nowosci-w-ofercie', 'slug');
        
        $this->view->assign('page',$page);
        $this->view->assign('products', $products);
        $this->view->assign('photoDimension', $photoDimension);

        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
     public function promotionProductsAction() {
        $productService = $this->_service->getService('Product_Service_Product');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        $pageService = $this->_service->getService('Page_Service_Page');
        
        $photoDimension = $photoDimensionService->getElementDimension('productmain');
        $products = $productService->getPromotionProducts();
        
        $page = $pageService->geti18nPage('promocje', 'slug');
        
        $this->view->assign('page',$page);
        $this->view->assign('products', $products);
        $this->view->assign('photoDimension', $photoDimension);

        $this->_helper->actionStack('layout', 'index', 'default');
    }
}

