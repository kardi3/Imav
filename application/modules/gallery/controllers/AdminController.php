<?php

/**
 * Gallery_AdminController
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Gallery_AdminController extends MF_Controller_Action {
    
    public function listGalleryAction() {
        
    }
    
    public function listGalleryDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
                
        $table = Doctrine_Core::getTable('Gallery_Model_Doctrine_Gallery');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table,
            'class' => 'Gallery_DataTables_Gallery', 
            'columns' => array('x.id','t.title','c.title','x.created_at','x.updated_at'),
            'searchFields' => array('x.id','t.title','c.title','x.created_at','x.updated_at')
        ));
        
       
        $results = $dataTables->getResult();
        
        $language = $i18nService->getAdminLanguage();
        
        $rows = array();
    
        
        foreach($results as $result) {
            $row = array();
            $row[] = $result['id'];
            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['Category']->title;
            $row[] = $result['created_at'];
            $row[] = $result['updated_at'];
           
            if($result['main_page'] == 1){ 
                $row[] = '<a href="' . $this->view->adminUrl('set-main-page-gallery', 'gallery', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-2"><span class="spaninspan">Tak</span></span></a>';
            }
            else{
                $row[] = '<a href="' . $this->view->adminUrl('set-main-page-gallery', 'gallery', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-unchecked-2"><span class="spaninspan">Nie</span></span></a>';
            }
            
            $options = '<a href="' . $this->view->adminUrl('edit-gallery', 'gallery', array('id' => $result->id)) . '" class="edit-item"><span class="icon24 entypo-icon-settings"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('delete-gallery', 'gallery', array('id' => $result->id)) . '" class="delete-item"><span class="icon24 icon-remove"></span></a>';
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
    
    public function addGalleryAction() {
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $categoryService = $this->_service->getService('Gallery_Service_Category');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $form = $galleryService->getGalleryForm();
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        $form->getElement('category_id')->setMultiOptions($categoryService->getCategorySelectOptions($adminLanguage->getId(),true));
        
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
                    $gallery = $galleryService->saveGalleryFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-gallery', 'gallery', array('id' => $gallery->getId())));
                    
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function editGalleryAction() {
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $categoryService = $this->_service->getService('Gallery_Service_Category');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        if(!$gallery = $galleryService->getGallery((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
        }
        
        $form = $galleryService->getGalleryForm($gallery);
        $metatagsForm = $metatagService->getMetatagsSubForm($gallery->get('Metatag'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        $form->getElement('category_id')->setMultiOptions($categoryService->getCategorySelectOptions($adminLanguage->getId(),true));
        $form->getElement('category_id')->setValue($gallery['category_id']);
                
        $languages = $i18nService->getLanguageList();
        
        $user = $this->_helper->user();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    if($metatags = $metatagService->saveMetatagsFromArray($gallery->get('Metatag'), $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $values['user_id'] = $user->getId();
                    
                    $gallery = $galleryService->saveGalleryFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    if(isset($_POST['save_only']))
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-gallery', 'gallery', array('id' => $gallery->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-gallery', 'gallery'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        //$this->view->admincontainer->findOneBy('id', 'editgallery')->setLabel($translator->translate($this->view->admincontainer->findOneBy('id', 'editgallery')->getLabel(), $adminLanguage->getId()) . ' ' . $translator->translate($types[$gallery->getType()], $adminLanguage->getId()));
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('gallery', $gallery);
        $this->view->assign('form', $form);
    }
    
    
    
    public function deleteGalleryAction() {
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagTranslationService = $this->_service->getService('Default_Service_MetatagTranslation');
        
        if(!$gallery = $galleryService->getGallery($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found', 404);
        }

        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
            
            $gallery->get('Metatag')->delete();
            $galleryService->removeGallery($gallery);
           
            
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            echo $this->_service->get('log')->log($e->getMessage(), 4);
        }      
       // $this->_helper->viewRenderer->setNoRender();
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-gallery', 'gallery'));
    }
    
     public function addGalleryMainPhotoAction() {
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$gallery = $galleryService->getGallery((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
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

                    $root = $gallery->get('PhotoRoot');
                    
                     if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Gallery_Model_Doctrine_Gallery::getGalleryPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);       
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Gallery_Model_Doctrine_Gallery::getGalleryPhotoDimensions()), false);                    
                    }
                    
                    $gallery->set('PhotoRoot', $photo);
                    $gallery->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        
       
        $root = $gallery->get('PhotoRoot');
        $root->refresh();
        $list = $this->view->partial('admin/gallery-main-photo.phtml', 'gallery', array('root' => $root, 'gallery' => $gallery));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $gallery->getId()
        ));
        
    }
    
    public function removeGalleryMainPhotoAction() {
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$gallery = $galleryService->getGallery((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $gallery->get('PhotoRoot')) {
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
        
        $root = $gallery->get('PhotoRoot');
        $list = $this->view->partial('admin/gallery-main-photo.phtml', 'gallery', array('photos' => $root , 'gallery' => $gallery));
        
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $gallery->getId()
        ));
        
    }
    
    
    
    public function addGalleryPhotoAction() {
        $photoService = $this->_service->getService('Media_Service_Photo');
         $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        
  
        
        if(!$gallery = $galleryService->getGallery((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
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

                        $root = $gallery->get('PhotoRoot');
                        if($root->isInProxyState()) {
                            $root = $photoService->createPhotoRoot();
                            $gallery->set('PhotoRoot', $root);
                            $gallery->save();
                        }

                       $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Gallery_Model_Doctrine_Gallery::getGalleryPhotoDimensions()), $root, true);

                       $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('Logger')->log($e->getMessage(), 4);
                    }
                }
            }
        }
        $list = '';
        
        $root = $gallery->get('PhotoRoot');
        $root->refresh();
        if(!$root->isInProxyState()) {
            $galleryPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/gallery-photos.phtml', 'product', array('photos' => $galleryPhotos, 'gallery' => $gallery));
        }
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $gallery->getId()
        ));
    }
    
    public function moveGalleryPhotoAction() {
        $photoService = $this->_service->getService('Media_Service_Photo');
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        
        if(!$gallery = $galleryService->getGallery($this->getRequest()->getParam('gallery'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Gallery photo not found');
        }

        $photoService->movePhoto($photo, $this->getRequest()->getParam('move', 'down'));
        
        $list = '';
        
        $root = $gallery->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $galleryPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/gallery-photos.phtml', 'gallery', array('photos' => $galleryPhotos, 'gallery' => $gallery));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $gallery->getId()
        ));
    
    }
    
    public function editGalleryPhotoAction() {
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$gallery = $galleryService->getGallery((int) $this->getRequest()->getParam('gallery-id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-gallery', 'gallery', array('id' => $gallery->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-gallery-photo', 'gallery', array('gallery-id' => $gallery->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-gallery-photo', 'gallery', array('id' => $gallery->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-gallery', 'gallery', array('id' => $gallery->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('gallery', $gallery);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Gallery_Model_Doctrine_Gallery::getGalleryPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function changePhotoNameAction() {   
        $photoService = $this->_service->getService('Media_Service_Photo');
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        
        if(!$gallery = $galleryService->getGallery((int) $this->getRequest()->getParam('gallery-id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
        }
        
        
        if(!$photo = $photoService->getPhoto($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Photo not found');
        }
        
        $photo->setTitle($this->getRequest()->getParam('name'));
        $photo->save();
        
        
        $list = '';
        
        $root = $gallery->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $galleryPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/gallery-photos.phtml', 'gallery', array('photos' => $galleryPhotos, 'gallery' => $gallery));
        }   
        
         $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $photo->getId()
        ));
    }
    
    public function removeGalleryPhotoAction() {   
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$gallery = $galleryService->getGallery((int) $this->getRequest()->getParam('gallery-id'))) {
            throw new Zend_Controller_Action_Exception('Gallery not found');
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
        
        $root = $gallery->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $galleryPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/gallery-photos.phtml', 'gallery', array('photos' => $galleryPhotos, 'gallery' => $gallery));
        }   
        
         $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $photo->getId()
        ));
    }
    
     public function setMainPageGalleryAction() {
        $galleryService = $this->_service->getService('Gallery_Service_Gallery');
        
        if($gallery = $galleryService->getGallery($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($gallery->main_page){
                    $gallery->set('main_page',0);
                }
                else{
                    $gallery->set('main_page',1);
                }
                    $gallery->save();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-gallery', 'gallery'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
}

