<?php

/**
 * Blog_AdminController
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Blog_AdminController extends MF_Controller_Action 
{
    public function init() {
        parent::init();
    }
    
    public function listBlogEntryAction() {
        
    }
    
    public function listBlogEntryDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Blog_Model_Doctrine_Blog');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Blog_DataTables_Blog', 
            'columns' => array('xt.title', 'x.created_at'),
            'searchFields' => array('xt.title')
        ));
        
        $results = $dataTables->getResult();
        
        $language = $i18nService->getAdminLanguage();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = MF_Text::timeFormat($result->publish_date, 'H:i d/m/Y');
            $options = '<a href="' . $this->view->adminUrl('edit-blog-entry', 'blog', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-blog-entry', 'blog', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function addBlogEntryAction() {
        $blogService = $this->_service->getService('Blog_Service_Blog');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $blogService->getBlogForm();
        
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $blogEntry = $blogService->saveEntryFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-blog-entry', 'blog', array('id' => $blogEntry->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function editBlogEntryAction() {
        $blogService = $this->_service->getService('Blog_Service_Blog');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $translator = $this->_service->get('translate');
        
        if(!$blogEntry = $blogService->getBlogEntry($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Entry not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $blogService->getBlogForm($blogEntry);
  
        $metatagsForm = $metatagService->getMetatagsSubForm($blogEntry->get('Metatags'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    if($metatags = $metatagService->saveMetatagsFromArray($blogEntry->get('Metatags'), $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $blogEntry = $blogService->saveEntryFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-blog-entry', 'blog'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('blog', $blogEntry);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function addBlogEntryPhotoAction() {
        $blogService = $this->_service->getService('Blog_Service_Blog');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$blogEntry = $blogService->getBlogEntry((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Entry not found');
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

                    $root = $blogEntry->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Blog_Model_Doctrine_Blog::getBlogEntryPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Blog_Model_Doctrine_Blog::getBlogEntryPhotoDimensions()), false);
                    }

                    $blogEntry->set('PhotoRoot', $photo);
                    $blogEntry->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $blogEntryPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $blogEntry->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $blogEntryPhotos->add($root);
            $list = $this->view->partial('admin/blog-entry-main-photo.phtml', 'blog', array('photos' => $blogEntryPhotos, 'blog' => $blogEntry));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $blogEntry->getId()
        ));
    }
    
    public function editBlogEntryPhotoAction() {
        $blogService = $this->_service->getService('Blog_Service_Blog');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$blogEntry = $blogService->getBlogEntry((int) $this->getRequest()->getParam('blog-id'))) {
            throw new Zend_Controller_Action_Exception('Entry not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Photo photo not found');
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-blog-entry-photo', 'blog', array('blog-id' => $blogEntry->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-blog-entry-photo', 'blog', array('id' => $blogEntry->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-blog-entry', 'blog', array('id' => $blogEntry->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        
        $this->view->admincontainer->findOneBy('id', 'cropblogentryphoto')->setActive();
        $this->view->admincontainer->findOneBy('id', 'editblogentry')->setLabel($blogEntry->Translation[$adminLanguage->getId()]->title);
        $this->view->admincontainer->findOneBy('id', 'editblogentry')->setParam('id', $blogEntry->getId());
        $this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'cropblogentryphoto')->getLabel());
        
        $this->view->assign('blog', $blogEntry);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Blog_Model_Doctrine_Blog::getBlogEntryPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeBlogEntryPhotoAction() {
        $blogService = $this->_service->getService('Blog_Service_Blog');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$blogEntry = $blogService->getBlogEntry((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Entry not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $blogEntry->get('PhotoRoot')) {
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
        
        $blogEntryPhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $blogEntry->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $blogEntryPhotos->add($root);
            $list = $this->view->partial('admin/blog-entry-main-photo.phtml', 'blog', array('photos' => $blogEntryPhotos, 'blog' => $blogEntry));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $blogEntry->getId()
        ));
    }
    
    public function removeBlogEntryAction() {
       $blogService = $this->_service->getService('Blog_Service_Blog');
       $metatagService = $this->_service->getService('Default_Service_Metatag');
       $metatagTranslationService = $this->_service->getService('Default_Service_MetatagTranslation');
       $photoService = $this->_service->getService('Media_Service_Photo');
        
        if($blogEntry = $blogService->getBlogEntry($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $blogEntry->getMetatagId());
                $metatagTranslation = $metatagTranslationService->getMetatagTranslation((int) $blogEntry->getMetatagId());

                $photoRoot = $blogEntry->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);
                
                $blogService->removeBlogEntry($blogEntry);

                $metatagService->removeMetatag($metatag);
                $metatagTranslationService->removeMetatagTranslation($metatagTranslation);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-blog-entry', 'blog'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-blog-entry', 'blog'));
    }
    
}

