<?php

/**
 * Product_IndexController 
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_IndexController extends MF_Controller_Action {
    
    public static $productCountPerPage = 10;
    
  
     public function productAction() {
        $productService = $this->_service->getService('Product_Service_Product');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        
        if(!$product = $productService->getFullProduct($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Article not found', 404);
        }
        
        $metatagService->setViewMetatags($product->get('Metatags'), $this->view);
       
        $this->view->assign('product',$product);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
//    public function productAction() {
//        
//         if($this->view->messages()->count()>1): 
//             $this->view->messages()->clear();
//         endif; 
//        
//        $productService = $this->_service->getService('Product_Service_Product');
//        $metatagService = $this->_service->getService('Default_Service_Metatag');
//
//        if(!$product = $productService->getFullProduct($this->getRequest()->getParam('product'), 'slug')) {
//            throw new Zend_Controller_Action_Exception('Product not found', 404);
//        }
//        $metatagService->setViewMetatags($product->get('metatag_id'), $this->view);
//
//       
//        $form = new Product_Form_Contact();        
//        
//        $session = new Zend_Session_Namespace('CONTACT_CSRF');
//        $form->getElement('csrf')->setSession($session)->initCsrfValidator();
//        
//        $captchaDir = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('captchaDir');
//        $form->addElement('captcha', 'captcha',
//            array(
//            'label' => 'Rewrite the chars', 
//            'captcha' => array(
//                'captcha' => 'Image',  
//                'wordLen' => 5,  
//                'timeout' => 300,  
//                'font' => APPLICATION_PATH . '/../data/arial.ttf',  
//                'imgDir' => $captchaDir,  
//                'imgUrl' => $this->view->serverUrl() . '/captcha/',  
//            )
//        )); 
//        
//        $contactEmail = $this->getFrontController()->getParam('bootstrap')->getOption('contact_email');
//
//        if(!$contactEmail) {
//            throw new Zend_Controller_Action_Exception('Contact email address not set');
//        }
//            
//        $mail = new Zend_Mail('UTF-8');
//        $mail->addTo($contactEmail);
//        
//        if($this->getRequest()->isPost()) {
//            if($form->isValid($this->getRequest()->getParams())) {
//                try {
//                    $bodyText = "Mail kontaktowy od : ".$form->getValue('name')." ".$form->getValue('lastName')."\nDane kontaktowe: telefon - ".$form->getValue('phone')." email ".$form->getValue('email')." \n";
//                    
//                    $mail->setReplyTo($form->getValue('email'));
//                    $mail->setSubject("Zapytanie o przedmiot ".$product['Translation'][$this->language]['name']." Identyfikator: ".$product['id']);
//                    $mail->setBodyText($bodyText.$form->getValue('message'));
//                    $mail->setFrom($contactEmail,$form->getValue('name'));
//                    $mail->addTo('info@dodusmaszyny.pl');
//                    $mail->addTo($contactEmail);
//                    $mail->send();
//                    $form->reset();
//                    $this->view->messages()->add($this->view->translate('Message sent'));
//                    
//                } catch(Exception $e) {
//                    $this->_service->get('Logger')->log($e->getMessage(), 4);
//                }
//            }
//            
//        }
//        $this->view->assign('form',$form);
//        $this->view->assign('product', $product);
//        $this->_helper->actionStack('layout', 'index', 'default');
//    }
    public function indexAction() {
        
        echo "d";exit;
        $productService = $this->_service->getService('Product_Service_Product');
        $linkService = $this->_service->getService('Link_Service_Link');
        
        $query = $productService->getArticlePaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $this->view->assign('linkService', $linkService);
        $this->view->assign('paginator', $paginator);
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
   public function listProductAction() {
        $productService = $this->_service->getService('Product_Service_Product');
        $categoryService = $this->_service->getService('Product_Service_Category');
        
        
        $categories = $categoryService->getAllCategories();
        
        $lastProduct = $productService->getLastProduct(3,Doctrine_Core::HYDRATE_ARRAY);
        
        $productList = array();
        foreach($categories as $category):
            $productList[$category['Translation'][$this->view->language]['name']] = $productService->getLastCategoryProduct($category['id'],2,Doctrine_Core::HYDRATE_ARRAY);
        
        endforeach;
        
        
        $this->view->assign('lastProduct', $lastProduct);
        $this->view->assign('productList', $productList);
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
    public function listCategoryProductAction() {
        $productService = $this->_service->getService('Product_Service_Product');
        $categoryService = $this->_service->getService('Product_Service_Category');
        
        if(!$category = $categoryService->getFullCategory($this->getRequest()->getParam('category'), 'slug',  Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Category not found');
        }
        
        
       $productList = $productService->getLastCategoryProduct($category['id'],null,Doctrine_Core::HYDRATE_ARRAY);
        
        
        $this->view->assign('category', $category);
        $this->view->assign('productList', $productList);
        
        $this->_helper->layout->setLayout('article');
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        
    }
}

