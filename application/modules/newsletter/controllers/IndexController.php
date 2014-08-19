<?php

/**
 * Newsletter_IndexController
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Newsletter_IndexController extends MF_Controller_Action {
    
   public function newsletterAction(){
        
        $pageService = $this->_service->getService('Page_Service_Page');
        $newsletterService = $this->_service->getService('Newsletter_Service_Newsletter');
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        $categoryService = $this->_service->getService('Product_Service_Category');
    
                       
        $categories = $categoryService->getCategoriesForNewsletter(Doctrine_Core::HYDRATE_ARRAY);
        $form = $newsletterService->getNewsletterForm();
        foreach($categories as $category):
            $form->getElement('category_id')->addMultiOption($category['id'],$category['Translation'][$this->view->language]['name']);
        endforeach;
        
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
        $form->removeElement('name');
        $form->removeElement('lastname');
        $form->removeElement('terms');
        $page = $pageService->getI18nPage('newsletter','slug');
        
        //$form->getElement('group_id')->setMultiOptions(array('group1'=>array('opcja1','opcja2','opcja3'),'group2'=>array('opcja4','opcja5')));
        
        if($this->getRequest()->isPost()) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                $values = $_POST;
                $this->view->messages()->clean();
                if($subscriber = $subscriberService->getSubscriber($values['email'],'email')) {
                    $this->view->messages()->add($this->view->translate('This mail is already in our database'),'errors');
                }
                else{
                    $subscriberService->saveSubscriberFromArray($values);
                    $this->view->messages()->add($this->view->translate('Your mail has been added to our database'));
                }
                $this->_service->get('doctrine')->getCurrentConnection()->commit();

                $form->reset();

                //$this->_helper->redirector->gotoUrl($this->view->adminUrl('list-message', 'newsletter'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }
        
        $this->view->assign('page', $page);
        $this->view->assign('form', $form);
        $this->_helper->actionStack('layout', 'index', 'default');
   }
   
   public function messageViewAction(){
        
       
        $newsletterService = $this->_service->getService('Newsletter_Service_Newsletter');
        $subsService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        $message_id = $this->getRequest()->getParam('id');
        //echo $message_id;
        $message = $newsletterService->getMessageById($this->getRequest()->getParam('slug'),'slug');
        
        $this->view->assign('message', $message);
        
    
   } 
   
   public function newsletterUnsubscribeAction(){
        
       $this->_helper->layout->setLayout('newsletter');
       
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        $token = $this->getRequest()->getParam('token');
        
        $result = $subscriberService->removeSubscriber($token,'token');
        
        $this->view->assign('result',$result);
    
   } 
    
}

