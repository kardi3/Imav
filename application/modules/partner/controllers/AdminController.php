<?php

/**
 * Partner_AdminController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Partner_AdminController extends MF_Controller_Action {
   
  
     public function listPartnerAction() {

   }
    
   public function listPartnerDataAction() {    
        $i18nService = $this->_service->getService('Default_Service_I18n');
       
        $table = Doctrine_Core::getTable('Partner_Model_Doctrine_Partner');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Partner_DataTables_Partner', 
            'columns' => array('pt.name', 'p.created_at'),
            'searchFields' => array('pt.name')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result->Translation[$language->getId()]->name;
            $row[] = $result['created_at'];
            if($result['status'] == 1){ 
                $row[] = '<a href="' . $this->view->adminUrl('refresh-status-partner', 'partner', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-2"></span></a>';
           
                   }else{
                        $row[] = '<a href="' . $this->view->adminUrl('refresh-status-partner', 'partner', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-unchecked-2"></span></a>';
         
                 }
           $options = '<a href="' . $this->view->adminUrl('edit-partner', 'partner', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-partner', 'partner', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function addPartnerAction() {
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $partnerService->getPartnerForm();
        
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $values, array('title' => 'name', 'description' => 'description', 'keywords' => 'description'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                       
                    $partner = $partnerService->savePartnerFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-partner', 'partner', array('id' => $partner->getId())));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function editPartnerAction() {
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $translator = $this->_service->get('translate');
        
        if(!$partner = $partnerService->getPartner($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Partner not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $partnerService->getPartnerForm($partner);
        
        $metatagsForm = $metatagService->getMetatagsSubForm($partner->get('Metatags'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    if($metatags = $metatagService->saveMetatagsFromArray($partner->get('Metatags'), $values, array('title' => 'name', 'description' => 'description', 'keywords' => 'description'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $partner = $partnerService->savePartnerFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-partner', 'partner'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('partner', $partner);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removePartnerAction() {
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagTranslationService = $this->_service->getService('Default_Service_MetatagTranslation');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if($partner = $partnerService->getPartner($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $partner->getMetatagId());
                $metatagTranslation = $metatagTranslationService->getMetatagTranslation((int) $partner->getMetatagId());

                $photoRoot = $partner->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);
                
                $partnerService->removePartner($partner);

                $metatagService->removeMetatag($metatag);
                $metatagTranslationService->removeMetatagTranslation($metatagTranslation);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-partner', 'partner'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-partner', 'partner'));
    }
    
    // ajax actions
    
    public function addPartnerPhotoAction() {
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$partner = $partnerService->getPartner((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Partner not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $href = $this->getRequest()->getParam('hrefs');

        if(is_string($href) && strlen($href)) {
            $path = str_replace("http://" . $options['domain'], "", urldecode($href));
            $filePath = urldecode($options['publicDir'] . $path);
            if(file_exists($filePath)) {
                $pathinfo = pathinfo($filePath);
                $slug = MF_Text::createSlug($pathinfo['basename']);
                $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $root = $partner->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Partner_Model_Doctrine_Partner::getPartnerPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Partner_Model_Doctrine_Partner::getPartnerPhotoDimensions()), false);
                    }

                    $partner->set('PhotoRoot', $photo);
                    $partner->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $partnerPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $partner->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $partnerPhotos->add($root);
            $list = $this->view->partial('admin/partner-main-photo.phtml', 'partner', array('photos' => $partnerPhotos, 'partner' => $partner));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $partner->getId()
        ));
        
    }
    
    public function editPartnerPhotoAction() {
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$partner = $partnerService->getPartner((int) $this->getRequest()->getParam('partner-id'))) {
            throw new Zend_Controller_Action_Exception('Partner not found');
        }
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-partner', 'partner', array('id' => $partner->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-partner-photo', 'partner', array('partner-id' => $partner->getId(), 'id' => $photo->getId())));
        
        $photosDir = $photoService->photosDir;
        $offsetDir = realpath($photosDir . DIRECTORY_SEPARATOR . $photo->getOffset());
        if(strlen($photo->getFilename()) > 0 && file_exists($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename())) {
            list($width, $height) = getimagesize($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename());
            $this->view->assign('imgDimensions', array('width' => $width, 'height' => $height));
        }

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $photo = $photoService->saveFromArray($values);

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    if($this->getRequest()->getParam('saveOnly') == '1')
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-partner-photo', 'partner', array('id' => $partner->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-partner', 'partner', array('id' => $partner->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
      
        $this->view->admincontainer->findOneBy('id', 'edit-partner')->setLabel($partner->Translation[$adminLanguage->getId()]->name);
        $this->view->admincontainer->findOneBy('id', 'edit-partner')->setParam('id', $partner->getId());
        $this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'croppartnerphoto')->getLabel());

        $this->view->assign('partner', $partner);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Partner_Model_Doctrine_Partner::getPartnerPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removePartnerPhotoAction() {
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$partner = $partnerService->getPartner((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Partner not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $partner->get('PhotoRoot')) {
                if($root && !$root->isInProxyState()) {
                    $photo = $photoService->updatePhoto($root);
                    $photo->setOffset(null);
                    $photo->setFilename(null);
                    $photo->setTitle(null);
                    $photo->save();
                }
            }
        
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $list = '';
        
        $partnerPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $partner->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $partnerPhotos->add($root);
            $list = $this->view->partial('admin/partner-main-photo.phtml', 'partner', array('photos' => $partnerPhotos, 'partner' => $partner));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $partner->getId()
        ));
        
    }
    
    public function refreshStatusPartnerAction() {
        $partnerService = $this->_service->getService('Partner_Service_Partner');
        
        if(!$partner = $partnerService->getPartner((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Partner not found');
        }
        
        $partnerService->refreshStatusPartner($partner);
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-partner', 'partner'));
        $this->_helper->viewRenderer->setNoRender();
    }
    
}

