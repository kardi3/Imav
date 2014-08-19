<?php

/**
 * Attachment_AdminController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Attachment_AdminController extends MF_Controller_Action {
   
    public function listAttachmentSerwis1Action() {
        
    }
    
    public function listAttachmentSerwis1DataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Attachment_Model_Doctrine_AttachmentSerwis1');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Attachment_DataTables_AttachmentSerwis1', 
            'columns' => array('a.title'),
            'searchFields' => array('a.title')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['extension'];
            $options = '<a href="' . $this->view->adminUrl('edit-attachment-serwis1', 'attachment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-attachment-serwis1', 'attachment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function addAttachmentSerwis1Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis1'); 

        $fileForm = new Attachment_Form_UploadAttachment();
        $fileForm->setDecorators(array('FormElements'));
        $fileForm->removeElement('submit');
        $fileForm->getElement('file')->setValueDisabled(true);
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if($this->getRequest()->isPost()) {
            if($fileForm->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $attachment = $attachmentService->createAttachmentFromUpload($fileForm->getElement('file')->getName(), $fileForm->getValue('file'), null, $adminLanguage->getId());

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();             
                } catch(Exception $e) {
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                    var_dump($e->getMessage()); exit;
                }
     
            }
        }
        $this->_helper->viewRenderer->setNoRender();  
    }
    
    public function editAttachmentSerwis1Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis1');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        $form = $attachmentService->getAttachmentForm($attachment);
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $attachmentService->saveAttachmentFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis1', 'attachment'));
                } catch(Exception $e) {
                    var_dump($e->getMessage()); exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
        $this->view->assign('attachment', $attachment);
    } 
    
    public function removeAttachmentSerwis1Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis1');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if($attachment = $attachmentService->getAttachment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $attachmentService->removeAttachment($attachment);
                
                $photoRoot = $attachment->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis1', 'attachment'));
            } catch(Exception $e) {
               var_dump($e->getMessage()); exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis1', 'attachment'));
    }
    
    public function addAttachmentPhotoSerwis1Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis1');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
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

                    $root = $attachment->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis1::getAttachmentPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis1::getAttachmentPhotoDimensions()), false);
                    }

                    $attachment->set('PhotoRoot', $photo);
                    $attachment->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis1.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function editAttachmentPhotoSerwis1Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis1');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('attachment-id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis1', 'attachment', array('id' => $attachment->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-attachment-photo-serwis1', 'attachment', array('attachment-id' => $attachment->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-photo-serwis1', 'attachment', array('id' => $attachment->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis1', 'attachment', array('id' => $attachment->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
      
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis1')->setLabel($attachment->Translation[$adminLanguage->getId()]->title);
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis1')->setParam('id', $attachment->getId());
        $this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'cropattachmentserwis1photo')->getLabel());

        $this->view->assign('attachment', $attachment);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Attachment_Model_Doctrine_AttachmentSerwis1::getAttachmentPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeAttachmentPhotoSerwis1Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis1');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $attachment->get('PhotoRoot')) {
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
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis1.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function listAttachmentSerwis5Action() {
        
    }
    
    public function listAttachmentSerwis5DataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Attachment_Model_Doctrine_AttachmentSerwis5');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Attachment_DataTables_AttachmentSerwis5', 
            'columns' => array('a.title'),
            'searchFields' => array('a.title')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['extension'];
            $options = '<a href="' . $this->view->adminUrl('edit-attachment-serwis5', 'attachment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-attachment-serwis5', 'attachment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function addAttachmentSerwis5Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis5'); 

        $fileForm = new Attachment_Form_UploadAttachment();
        $fileForm->setDecorators(array('FormElements'));
        $fileForm->removeElement('submit');
        $fileForm->getElement('file')->setValueDisabled(true);
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if($this->getRequest()->isPost()) {
            if($fileForm->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $attachment = $attachmentService->createAttachmentFromUpload($fileForm->getElement('file')->getName(), $fileForm->getValue('file'), null, $adminLanguage->getId());

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();             
                } catch(Exception $e) {
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                    var_dump($e->getMessage()); exit;
                }
     
            }
        }
        $this->_helper->viewRenderer->setNoRender();  
    }
    
    public function editAttachmentSerwis5Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis5');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        $form = $attachmentService->getAttachmentForm($attachment);
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $attachmentService->saveAttachmentFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis5', 'attachment'));
                } catch(Exception $e) {
                    var_dump($e->getMessage()); exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
        $this->view->assign('attachment', $attachment);
    } 
    
    public function removeAttachmentSerwis5Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis5');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if($attachment = $attachmentService->getAttachment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $attachmentService->removeAttachment($attachment);
                
                $photoRoot = $attachment->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis5', 'attachment'));
            } catch(Exception $e) {
               var_dump($e->getMessage()); exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis5', 'attachment'));
    }
    
    public function addAttachmentPhotoSerwis5Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis5');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
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

                    $root = $attachment->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis5::getAttachmentPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis5::getAttachmentPhotoDimensions()), false);
                    }

                    $attachment->set('PhotoRoot', $photo);
                    $attachment->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis5.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function editAttachmentPhotoSerwis5Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis5');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('attachment-id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis5', 'attachment', array('id' => $attachment->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-attachment-photo-serwis5', 'attachment', array('attachment-id' => $attachment->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-photo-serwis5', 'attachment', array('id' => $attachment->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis5', 'attachment', array('id' => $attachment->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
      
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis5')->setLabel($attachment->Translation[$adminLanguage->getId()]->title);
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis5')->setParam('id', $attachment->getId());
        $this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'cropattachmentserwis5photo')->getLabel());

        $this->view->assign('attachment', $attachment);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Attachment_Model_Doctrine_AttachmentSerwis5::getAttachmentPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeAttachmentPhotoSerwis5Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis5');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $attachment->get('PhotoRoot')) {
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
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis5.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function listAttachmentSerwis6Action() {
        
    }
    
    public function listAttachmentSerwis6DataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Attachment_Model_Doctrine_AttachmentSerwis6');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Attachment_DataTables_AttachmentSerwis6', 
            'columns' => array('a.title'),
            'searchFields' => array('a.title')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['extension'];
            $options = '<a href="' . $this->view->adminUrl('edit-attachment-serwis6', 'attachment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-attachment-serwis6', 'attachment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function addAttachmentSerwis6Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis6'); 

        $fileForm = new Attachment_Form_UploadAttachment();
        $fileForm->setDecorators(array('FormElements'));
        $fileForm->removeElement('submit');
        $fileForm->getElement('file')->setValueDisabled(true);
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if($this->getRequest()->isPost()) {
            if($fileForm->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $attachment = $attachmentService->createAttachmentFromUpload($fileForm->getElement('file')->getName(), $fileForm->getValue('file'), null, $adminLanguage->getId());

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();             
                } catch(Exception $e) {
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                    var_dump($e->getMessage()); exit;
                }
     
            }
        }
        $this->_helper->viewRenderer->setNoRender();  
    }
    
    public function editAttachmentSerwis6Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis6');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        $form = $attachmentService->getAttachmentForm($attachment);
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $attachmentService->saveAttachmentFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis6', 'attachment'));
                } catch(Exception $e) {
                    var_dump($e->getMessage()); exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
        $this->view->assign('attachment', $attachment);
    } 
    
    public function removeAttachmentSerwis6Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis6');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if($attachment = $attachmentService->getAttachment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $attachmentService->removeAttachment($attachment);
                
                $photoRoot = $attachment->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis6', 'attachment'));
            } catch(Exception $e) {
               var_dump($e->getMessage()); exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis6', 'attachment'));
    }
    
    public function addAttachmentPhotoSerwis6Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis6');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
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

                    $root = $attachment->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis6::getAttachmentPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis6::getAttachmentPhotoDimensions()), false);
                    }

                    $attachment->set('PhotoRoot', $photo);
                    $attachment->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis6.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function editAttachmentPhotoSerwis6Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis6');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('attachment-id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis6', 'attachment', array('id' => $attachment->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-attachment-photo-serwis6', 'attachment', array('attachment-id' => $attachment->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-photo-serwis6', 'attachment', array('id' => $attachment->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis6', 'attachment', array('id' => $attachment->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
      
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis6')->setLabel($attachment->Translation[$adminLanguage->getId()]->title);
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis6')->setParam('id', $attachment->getId());
        $this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'cropattachmentserwis6photo')->getLabel());

        $this->view->assign('attachment', $attachment);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Attachment_Model_Doctrine_AttachmentSerwis6::getAttachmentPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeAttachmentPhotoSerwis6Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis6');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $attachment->get('PhotoRoot')) {
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
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis6.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function listAttachmentSerwis7Action() {
        
    }
    
    public function listAttachmentSerwis7DataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Attachment_Model_Doctrine_AttachmentSerwis7');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Attachment_DataTables_AttachmentSerwis7', 
            'columns' => array('a.title'),
            'searchFields' => array('a.title')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['extension'];
            $options = '<a href="' . $this->view->adminUrl('edit-attachment-serwis7', 'attachment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-attachment-serwis7', 'attachment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function addAttachmentSerwis7Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis7'); 

        $fileForm = new Attachment_Form_UploadAttachment();
        $fileForm->setDecorators(array('FormElements'));
        $fileForm->removeElement('submit');
        $fileForm->getElement('file')->setValueDisabled(true);
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if($this->getRequest()->isPost()) {
            if($fileForm->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $attachment = $attachmentService->createAttachmentFromUpload($fileForm->getElement('file')->getName(), $fileForm->getValue('file'), null, $adminLanguage->getId());

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();             
                } catch(Exception $e) {
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                    var_dump($e->getMessage()); exit;
                }
     
            }
        }
        $this->_helper->viewRenderer->setNoRender();  
    }
    
    public function editAttachmentSerwis7Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis7');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        $form = $attachmentService->getAttachmentForm($attachment);
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $attachmentService->saveAttachmentFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis7', 'attachment'));
                } catch(Exception $e) {
                    var_dump($e->getMessage()); exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
        $this->view->assign('attachment', $attachment);
    } 
    
    public function removeAttachmentSerwis7Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis7');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if($attachment = $attachmentService->getAttachment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $attachmentService->removeAttachment($attachment);
                
                $photoRoot = $attachment->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis7', 'attachment'));
            } catch(Exception $e) {
               var_dump($e->getMessage()); exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis7', 'attachment'));
    }
    
    public function addAttachmentPhotoSerwis7Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis7');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
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

                    $root = $attachment->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis7::getAttachmentPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis7::getAttachmentPhotoDimensions()), false);
                    }

                    $attachment->set('PhotoRoot', $photo);
                    $attachment->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis7.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function editAttachmentPhotoSerwis7Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis7');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('attachment-id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis7', 'attachment', array('id' => $attachment->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-attachment-photo-serwis7', 'attachment', array('attachment-id' => $attachment->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-photo-serwis7', 'attachment', array('id' => $attachment->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis7', 'attachment', array('id' => $attachment->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
      
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis7')->setLabel($attachment->Translation[$adminLanguage->getId()]->title);
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis7')->setParam('id', $attachment->getId());
        $this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'cropattachmentserwis7photo')->getLabel());

        $this->view->assign('attachment', $attachment);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Attachment_Model_Doctrine_AttachmentSerwis7::getAttachmentPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeAttachmentPhotoSerwis7Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis7');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $attachment->get('PhotoRoot')) {
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
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis7.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
     public function listAttachmentSerwis8Action() {
        
    }
    
    public function listAttachmentSerwis8DataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Attachment_Model_Doctrine_AttachmentSerwis8');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Attachment_DataTables_AttachmentSerwis8', 
            'columns' => array('a.title'),
            'searchFields' => array('a.title')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['extension'];
            $options = '<a href="' . $this->view->adminUrl('edit-attachment-serwis8', 'attachment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-attachment-serwis8', 'attachment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function addAttachmentSerwis8Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis8'); 

        $fileForm = new Attachment_Form_UploadAttachment();
        $fileForm->setDecorators(array('FormElements'));
        $fileForm->removeElement('submit');
        $fileForm->getElement('file')->setValueDisabled(true);
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if($this->getRequest()->isPost()) {
            if($fileForm->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $attachment = $attachmentService->createAttachmentFromUpload($fileForm->getElement('file')->getName(), $fileForm->getValue('file'), null, $adminLanguage->getId());

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();             
                } catch(Exception $e) {
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                    var_dump($e->getMessage()); exit;
                }
     
            }
        }
        $this->_helper->viewRenderer->setNoRender();  
    }
    
    public function editAttachmentSerwis8Action() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis8');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        $form = $attachmentService->getAttachmentForm($attachment);
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $attachmentService->saveAttachmentFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis8', 'attachment'));
                } catch(Exception $e) {
                    var_dump($e->getMessage()); exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
        $this->view->assign('attachment', $attachment);
    } 
    
    public function removeAttachmentSerwis8Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis8');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if($attachment = $attachmentService->getAttachment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $attachmentService->removeAttachment($attachment);
                
                $photoRoot = $attachment->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis8', 'attachment'));
            } catch(Exception $e) {
               var_dump($e->getMessage()); exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-attachment-serwis8', 'attachment'));
    }
    
    public function addAttachmentPhotoSerwis8Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis8');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
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

                    $root = $attachment->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis8::getAttachmentPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Attachment_Model_Doctrine_AttachmentSerwis8::getAttachmentPhotoDimensions()), false);
                    }

                    $attachment->set('PhotoRoot', $photo);
                    $attachment->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis8.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }
    
    public function editAttachmentPhotoSerwis8Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis8');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('attachment-id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis8', 'attachment', array('id' => $attachment->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-attachment-photo-serwis8', 'attachment', array('attachment-id' => $attachment->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-photo-serwis8', 'attachment', array('id' => $attachment->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-attachment-serwis8', 'attachment', array('id' => $attachment->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
      
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis8')->setLabel($attachment->Translation[$adminLanguage->getId()]->title);
        $this->view->admincontainer->findOneBy('id', 'edit-attachment-serwis8')->setParam('id', $attachment->getId());
        $this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'cropattachmentserwis8photo')->getLabel());

        $this->view->assign('attachment', $attachment);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Attachment_Model_Doctrine_AttachmentSerwis8::getAttachmentPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeAttachmentPhotoSerwis8Action() {
        $attachmentService = $this->_service->getService('Attachment_Service_AttachmentSerwis8');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$attachment = $attachmentService->getAttachment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attachment not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $attachment->get('PhotoRoot')) {
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
        
        $attachmentPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $attachment->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $attachmentPhotos->add($root);
            $list = $this->view->partial('admin/attachment-main-photo-serwis8.phtml', 'attachment', array('photos' => $attachmentPhotos, 'attachment' => $attachment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $attachment->getId()
        ));
        
    }

}