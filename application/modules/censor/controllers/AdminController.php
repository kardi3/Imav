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
        $censorService = $this->_service->getService('Censor_Service_Censor');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $this->getRequest()->setParam('lang', $adminLanguage->getId());
        
        $table = Doctrine_Core::getTable('Censor_Model_Doctrine_Censor');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table,
            'class' => 'Censor_DataTables_Censor', 
            'columns' => array('t.title'),
            'searchFields' => array('t.title')
        ));
        
        $types = Censor_Model_Doctrine_Censor::getAvailableTypes();
        foreach($types as $type => $label) {
            $censorService->fetchCensor($type, $adminLanguage->getId());
        }
        
        $results = $dataTables->getResult();
        
        $language = $i18nService->getAdminLanguage();
        
        $rows = array();
    
        $sortResults = Censor_Model_Doctrine_Censor::getAvailableTypes();
        $typeCensors = 0;
        // add custom censors to result set
        foreach($results as $result) {
            if(strlen($result['type'])) {
                $typeCensors = 1;
                $sortResults[$result['type']] = $result;
            }
        }
        // clean not found results
        foreach($sortResults as $type => $result) {
            if(is_string($result)) {
                unset($sortResults[$type]);
            }
        }
        // clean results if no custom censors
        if(!$typeCensors) {
            $sortResults = array();
        }
        // add censors from database
        foreach($results as $result) {
            if(strlen($result['type']) == 0) {
                $sortResults[] = $result;
            }
        }
        
        foreach($sortResults as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            if($result['type']) {
                $row['DT_RowClass'] = 'info';
            }
            $row[] = $result->Translation[$language->getId()]->title;
            if($result['type']) {
                 $options = '<a href="' . $this->view->adminUrl('edit-censor', 'censor', array('id' => $result->id)) . '" class="edit-item"><span class="icon24 entypo-icon-settings"></span></a>';
                $row[] = $options;
                
            } else {
                $options = '<a href="' . $this->view->adminUrl('edit-censor', 'censor', array('id' => $result->id)) . '" class="edit-item"><span class="icon24 entypo-icon-settings"></span></a>';
                $options .= '<a href="' . $this->view->adminUrl('delete-censor', 'censor', array('id' => $result->id)) . '" class="delete-item"><span class="icon24 icon-remove"></span></a>';
                $row[] = $options;
            }
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
                    
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $values['user_id'] = $user->getId();
                    $censor = $censorService->saveCensorFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    if($this->getRequest()->getParam('saveOnly') == '1')
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-censor', 'censor', array('id' => $censor->getId())));
                    
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
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $types = Censor_Model_Doctrine_Censor::getAvailableTypes();

        
        if(!$censor = $censorService->getCensor((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Censor not found');
        }
        
        $form = $censorService->getCensorForm($censor);
        $metatagsForm = $metatagService->getMetatagsSubForm($censor->get('Metatag'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        $languages = $i18nService->getLanguageList();
        
        $user = $this->_helper->user();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    if($metatags = $metatagService->saveMetatagsFromArray($censor->get('Metatag'), $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $values['user_id'] = $user->getId();
                    
                    $censor = $censorService->saveCensorFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    if($this->getRequest()->getParam('saveOnly') == '1')
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-censor', 'censor', array('id' => $censor->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-censor', 'censor'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->admincontainer->findOneBy('id', 'editcensor')->setLabel($translator->translate($this->view->admincontainer->findOneBy('id', 'editcensor')->getLabel(), $adminLanguage->getId()) . ' ' . $translator->translate($types[$censor->getType()], $adminLanguage->getId()));
        
        $this->view->assign('languages', $languages);
        $this->view->assign('censor', $censor);
        $this->view->assign('form', $form);
    }
    
    public function deleteCensorAction() {
        $censorService = $this->_service->getService('Censor_Service_Censor');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagTranslationService = $this->_service->getService('Default_Service_MetatagTranslation');
        
        if(!$censor = $censorService->getCensor($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Censor not found', 404);
        }

        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
            
            $censor->get('Metatag')->delete();
            $censorService->removeCensor($censor);
           
            
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            echo $this->_service->get('log')->log($e->getMessage(), 4);
        }      
       // $this->_helper->viewRenderer->setNoRender();
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-censor', 'censor'));
    }
    
    public function addCensorPhotoAction() {
         $censorService = $this->_service->getService('Censor_Service_Censor');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
  
        $photoDimension = $photoDimensionService->getDimension('censor');
        
        if(!$censor = $censorService->getCensor((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Censor not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $hrefs = $this->getRequest()->getParam('hrefs');

        if(is_array($hrefs) && count($hrefs)) {
            foreach($hrefs as $href) {
                $path = str_replace("http://" . $options['domain'], "", urldecode($href));
                $filePath = $options['publicDir'] . $path;
                if(file_exists($filePath)) {
                    $pathinfo = pathinfo($filePath);
                    $slug = MF_Text::createSlug($pathinfo['basename']);
                    $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                        $root = $censor->get('PhotoRoot');
                        if($root->isInProxyState()) {
                            $root = $photoService->createPhotoRoot();
                            $censor->set('PhotoRoot', $root);
                            $censor->save();
                        }

                       $photoService->createPhoto($filePath, $name, $pathinfo['filename'], $photoDimension, $root, true);

                       $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('Logger')->log($e->getMessage(), 4);
                    }
                }
            }
        }
        $list = '';
        
        $root = $censor->get('PhotoRoot');
        $root->refresh();
        if(!$root->isInProxyState()) {
            $censorPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/censor-photos.phtml', 'product', array('photos' => $censorPhotos, 'censor' => $censor));
        }
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $censor->getId()
        ));
    }
    
    public function moveCensorPhotoAction() {
        $photoService = $this->_service->getService('Media_Service_Photo');
        $censorService = $this->_service->getService('Censor_Service_Censor');
        
        if(!$censor = $censorService->getCensor($this->getRequest()->getParam('censor'))) {
            throw new Zend_Controller_Action_Exception('Censor not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Censor photo not found');
        }

        $photoService->movePhoto($photo, $this->getRequest()->getParam('move', 'down'));
        
        $list = '';
        
        $root = $censor->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $censorPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/censor-photos.phtml', 'censor', array('photos' => $censorPhotos, 'censor' => $censor));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $censor->getId()
        ));
    }
    
    public function removeCensorPhotoAction() {   
        $censorService = $this->_service->getService('Censor_Service_Censor');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$censor = $censorService->getCensor((int) $this->getRequest()->getParam('censor-id'))) {
            throw new Zend_Controller_Action_Exception('Censor not found');
        }
        
        if(!$photo = $photoService->getPhoto($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Photo photo not found');
        }
        
        try {
            $photoService->removePhoto($photo);
            
        } catch(Exception $e) {
            $this->_service->get('Logger')->log($e->getMessage(), 4);
        }
              
        $list = '';
        
        $root = $censor->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $censorPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/censor-photos.phtml', 'censor', array('photos' => $censorPhotos, 'censor' => $censor));
        }   
        
         $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $photo->getId()
        ));
    }
    
}

