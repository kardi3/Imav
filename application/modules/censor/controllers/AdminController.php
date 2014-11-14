<?php

/**
 * Censor_AdminController
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_AdminController extends MF_Controller_Action {
    
    public function listCensorAction() {
        
    }
    
    public function listCensorDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $this->getRequest()->setParam('lang', $adminLanguage->getId());
        
        $table = Doctrine_Core::getTable('Censor_Model_Doctrine_Censor');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table,
            'class' => 'Censor_DataTables_Censor', 
            'columns' => array('x.id','t.title'),
            'searchFields' => array('x.id','t.title')
        ));
        
        
        $results = $dataTables->getResult();
        
        $language = $i18nService->getAdminLanguage();
        
        
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->Translation[$language->getId()]->title;
            
            $options = '<a href="' . $this->view->adminUrl('edit-censor', 'censor', array('id' => $result->id)) . '" class="edit-item"><span class="icon24 entypo-icon-settings"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('delete-censor', 'censor', array('id' => $result->id)) . '" class="delete-item"><span class="icon24 icon-remove"></span></a>';
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
    
    public function addCensorAction() {
        $censorService = $this->_service->getService('Censor_Service_Censor');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $form = $censorService->getCensorForm();
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        $languages = $i18nService->getLanguageList();
        
        $user = $this->_helper->user();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    $censor = $censorService->saveCensorFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-censor', 'censor'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function editCensorAction() {
        $censorService = $this->_service->getService('Censor_Service_Censor');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        
        if(!$censor = $censorService->getCensor((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Censor not found');
        }
        
        $form = $censorService->getCensorForm($censor);
        
        $languages = $i18nService->getLanguageList();
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    $censor = $censorService->saveCensorFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-censor', 'censor'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('languages', $languages);
        $this->view->assign('censor', $censor);
        $this->view->assign('form', $form);
    }
    
    public function deleteCensorAction() {
        $censorService = $this->_service->getService('Censor_Service_Censor');
        
        if(!$censor = $censorService->getCensor($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Censor not found', 404);
        }

        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
            $censorService->removeCensor($censor);
           
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-censor', 'censor'));
            
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            echo $this->_service->get('log')->log($e->getMessage(), 4);
        }      
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function listIpAction() {
        
    }
    
    public function listIpDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $this->getRequest()->setParam('lang', $adminLanguage->getId());
        
        $table = Doctrine_Core::getTable('Censor_Model_Doctrine_Ip');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table,
            'class' => 'Censor_DataTables_Ip', 
            'columns' => array('x.ip'),
            'searchFields' => array('x.ip')
        ));
        
        
        $results = $dataTables->getResult();
        
        $language = $i18nService->getAdminLanguage();
        
        
        foreach($results as $result) {
            $row = array();
            $row[] = $result->ip;
            $row[] = $result->created_at;
            
            $options = '<a href="' . $this->view->adminUrl('edit-ip', 'censor', array('ip' => $result->ip)) . '" class="edit-item"><span class="icon24 entypo-icon-settings"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('delete-ip', 'censor', array('ip' => $result->ip)) . '" class="delete-item"><span class="icon24 icon-remove"></span></a>';
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
    
    public function addIpAction() {
        $ipService = $this->_service->getService('Censor_Service_Ip');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $form = $ipService->getIpForm();
        
        $languages = $i18nService->getLanguageList();
        
        $user = $this->_helper->user();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    $ip = $ipService->saveIpFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-ip', 'censor'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function editIpAction() {
        $ipService = $this->_service->getService('Censor_Service_Ip');
        
        if(!$ip = $ipService->getIp( $this->getRequest()->getParam('ip'))) {
            throw new Zend_Controller_Action_Exception('Ip not found');
        }
        
        $form = $ipService->getIpForm($ip);
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    $ip->set('ip',$values['ip']);
                    $ip->save();
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-ip', 'censor'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('ip', $ip);
        $this->view->assign('form', $form);
    }
    
    public function deleteIpAction() {
        $ipService = $this->_service->getService('Censor_Service_Ip');
        
        if(!$ip = $ipService->getIp($this->getRequest()->getParam('ip'))) {
            throw new Zend_Controller_Action_Exception('Ip not found', 404);
        }

        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
            
            $ipService->removeIp($ip);
           
            
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            echo $this->_service->get('log')->log($e->getMessage(), 4);
        }      
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-ip', 'censor'));
    }
    
}

