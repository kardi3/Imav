<?php

/**
 * Newsletter_AdminController
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Newsletter_AdminController extends MF_Controller_Action {
  
    
    
    public function listMessageAction() {
        
    }
    
    public function listMessageDataAction() {
        
        $table = Doctrine_Core::getTable('Newsletter_Model_Doctrine_Message');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Newsletter_DataTables_Message', 
            'columns' => array('x.title','c.name', 'x.send_at','x.sent'),
            'searchFields' => array('x.id','x.title','c.name', 'x.send_at','x.sent')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result->title;
            $categories = "";
            foreach($result['Categories'] as $category):
                $categories .= $category->name."<br />";
            endforeach;
            $row[] = $categories;
            
            $row[] = MF_Text::timeFormat($result->send_at, 'Y-d-m H:i:s');
             
            if($result->sent){
                $options = '<a href="' . $this->view->adminUrl('edit-message', 'newsletter', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon32 entypo-icon-settings"></span></a>';
                $row[] = '<div class="btn btn-success">true</div>';
            }
            else{
                 $row[] = '<div class="btn btn-danger">false</div>';
                $options = '<a href="' . $this->view->adminUrl('send-message', 'newsletter', array('id' => $result->id)) . '" title="' . $this->view->translate('Send') . '"><span class="icon24 icomoon-icon-arrow-up-5"></span></a>';
                $options .= '<a href="' . $this->view->adminUrl('edit-message', 'newsletter', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon32 entypo-icon-settings"></span></a>';
            }
            $options .= '<a href="' . $this->view->adminUrl('remove-message', 'newsletter', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icomoon-icon-cancel-3"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    public function addMessageAction() {
        $newsletterService = $this->_service->getService('Newsletter_Service_Newsletter');
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        $subscribers = $subscriberService->getSubscribers();
        $groups = $subscriberService->getGroups();
        
        $form = $newsletterService->getMessageForm();
        
        $form->getElement('subscribers')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('subscribers')->setMultiOptions($subscribers);
        
        $form->getElement('groups')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('groups')->setMultiOptions($groups);
        
        if($this->getRequest()->isPost()) {
            if(($this->getRequest()->getPost())) { 
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $this->getRequest()->getParams();
                    
                    $newsletterService->saveMessageFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-message', 'newsletter'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
                
        $this->view->assign('form', $form);
    }
    
    
    public function editMessageAction() {
        $newsletterService = $this->_service->getService('Newsletter_Service_Newsletter');
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        $message = $newsletterService->getMessage($this->getRequest()->getParam('id'));
        
        $subscribers = $subscriberService->getSubscribers();
        $groups = $subscriberService->getGroups();
                
        $form = $newsletterService->getMessageForm($message);
        
        $form->getElement('subscribers')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('subscribers')->setMultiOptions($subscribers);
        
        $form->getElement('groups')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('groups')->setMultiOptions($groups);
        
        
        if($this->getRequest()->isPost()) {
            if(($this->getRequest()->getPost())) { 
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $this->getRequest()->getParams();
                  
                    $message = $newsletterService->saveMessageFromArray($values);
                    
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-message', 'newsletter'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
                
        $this->view->assign('form', $form);
        
        
    }
    
    public function sendMessageAction(){
        $newsletterService = $this->_service->getService('Newsletter_Service_Newsletter');
        
        $message = $newsletterService->getMessage($this->getRequest()->getParam('id'));
        $newsletterService->setGroupUsersToSend($message);
        
        $newsletterService->sendMessage($message);
            
         return $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-message', 'newsletter'));
    }
    
    
    /* subscribers */
    
    public function listSubscriberAction() {
        
    }
    
    public function listSubscriberDataAction() {
        
        $table = Doctrine_Core::getTable('Newsletter_Model_Doctrine_Subscriber');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Newsletter_DataTables_Subscriber', 
            'columns' => array('x.name', 'x.email','c.name'),
            'searchFields' => array('x.id', 'x.email','c.name')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result->email;
            $categories = "";
            foreach($result['Categories'] as $category):
                $categories .= $category['Translation'][$this->view->language]['name']."<br />";
            endforeach;
            $row[] = $categories;
            $options = '<a href="' . $this->view->adminUrl('edit-subscriber', 'newsletter', array('id' => $result->id)) . '" class="edit" title="' . $this->view->translate('Edit') . '"><span class="icon16 entypo-icon-settings"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-subscriber', 'newsletter', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    
    public function removeSubscriberAction(){
        
        $subsService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();                    
            $subs = $subsService->removeSubscriber($this->_request->getParam('id'));
            $this->view->messages()->add($this->translate('Item has been deleted'), 'success');                    
            $this->_service->get('doctrine')->getCurrentConnection()->commit();                

        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-subscriber', 'newsletter'));
        $this->_helper->viewRenderer->setNoRender();
                
    }
    
     public function addSubscriberAction() {
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        $categoryService = $this->_service->getService('Product_Service_Category');
        
        $categories = $categoryService->getNewsletterCategories();
        
        $form = $subscriberService->getSubscriberForm();
       
        $form->getElement('category_id')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('category_id')->setMultiOptions($categories);
        
        if($this->getRequest()->isPost()) {
            if(($form->isValid($this->getRequest()->getPost()))) { 
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $form->getValues();
                    $subscriberService->saveSubscriberFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-subscriber', 'newsletter'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
                
        $this->view->assign('form', $form);
    }
    
    public function editSubscriberAction() {
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        $categoryService = $this->_service->getService('Product_Service_Category');
        $su = $subscriberService->getAllSubscribers();
        foreach($su as $sub):
            var_dump($sub['Categories']->toArray());exit;
        endforeach;
        $form = $subscriberService->getSubscriberForm($subscriber);
       
        $form->getElement('category_id')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('category_id')->setMultiOptions($categories);
        
        if($this->getRequest()->isPost()) {
            if(($form->isValid($_POST))) { 
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $form->getValues();
                    $subscriber = $subscriberService->saveSubscriberFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-subscriber', 'newsletter'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
                
        $this->view->assign('form', $form);
    }
    
    /* groups */
    
    public function listGroupAction() {
        
    }
    
    public function listGroupDataAction() {
        
        $table = Doctrine_Core::getTable('Newsletter_Model_Doctrine_Group');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Newsletter_DataTables_Group', 
            'columns' => array('x.name'),
            'searchFields' => array('x.name')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DtRow'] = $result->id;
            $row[] = $result->name;
            
            $options = '<a href="' . $this->view->adminUrl('edit-group', 'newsletter', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-group', 'newsletter', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icomoon-icon-cancel-3"></span></a>';
            $row[] = $options;$rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    
    
    public function addGroupAction() {
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        $subscribers = $subscriberService->getSubscribers();
        
        $form = $subscriberService->getGroupForm();
       
        $form->getElement('subscribers')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('subscribers')->setMultiOptions($subscribers);
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) { 
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $this->getRequest()->getParams();
                    
                    $subscriberService->saveGroupFromArray($values);
                                        
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-group', 'newsletter'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
                
        $this->view->assign('form', $form);
    }
    
    
    
    public function removeGroupAction(){
        
        $groupService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();                    
            $groupService->removeGroup($this->_request->getParam('id'));
            $groupService->removeSubscriber($this->_request->getParam('id'));
            $this->view->messages()->add($this->translate('Item has been deleted'), 'success');                    
            $this->_service->get('doctrine')->getCurrentConnection()->commit();                

        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-group', 'newsletter'));
        $this->_helper->viewRenderer->setNoRender();
                
    }
    
    public function editGroupAction() {
        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');
        
        $subscribers = $subscriberService->getSubscribers();
        
        if(!$group = $subscriberService->getGroup((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Group not found');
        }
        
        $form = $subscriberService->getGroupForm($group);
        $form->getElement('subscribers')->setAttribs(array('multiple' => 'multiple', 'class' => 'nostyle'));
        $form->getElement('subscribers')->setMultiOptions($subscribers);
        
        if($this->getRequest()->isPost()) {
            
            if($form->isValid($this->getRequest()->getPost())) {
                
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                    $values = $form->getValues();
                    
                    $group = $subscriberService->saveGroupFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                  
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-group', 'newsletter'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
           
        }
        
        
        $this->view->assign('form', $form);
    }
    
}

