<?php

/**
 * AdminController
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Article_AdminController extends MF_Controller_Action {
    
    public function listArticleAction() {
        if($dashboardTime = $this->_helper->user->get('dashboard_time')) {
            if(isset($dashboardTime['new_articles'])) {
                $dashboardTime['new_articles'] = time();
                $this->_helper->user->set('dashboard_time', $dashboardTime);
            }
        }
    }
    
    public function listArticleDataAction() {
        $table = Doctrine_Core::getTable('Article_Model_Doctrine_Article');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Article_DataTables_Article', 
            'columns' => array('x.title', 'u.last_name', 'c.name', 'x.created_at'),
            'searchFields' => array('x.title', 'CONCAT_WS(" ", u.first_name, u.last_name)', 'c.name')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result['id'];
            if(MF_Code::STATUS_NEW == $result['status']) {
                $row['DT_RowClass'] = 'success';
            } elseif(MF_Code::STATUS_REJECTED == $result['status']) {
                $row['DT_RowClass'] = 'inactive';
            }
            $row[] = $result['title'];
            $row[] = $result['Category']['name'];
            $row[] = $result['User']['first_name'] . ' ' . $result['User']['last_name'];
            $row[] = MF_Text::timeFormat($result['created_at'], 'H:i d/m/Y');
            $options = '<a href="' . $this->view->adminUrl('edit-article', 'article', array('id' => $result['id'])) . '" title="' . $this->view->translate('Edit') . '"><span class="icon16 icon-edit"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-article', 'article', array('id' => $result['id'])) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function editArticleAction() {
        $articleService = $this->_service->getService('Article_Service_Article');
        
        if(!$article = $articleService->getArticle((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Article not found');
        }
        
        $form = $articleService->getArticleForm($article);
        $form->setAction($this->view->adminUrl('edit-article', 'article'));
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    if(MF_Code::STATUS_REJECTED != $article->getStatus()) {
                        $values['status'] = MF_Code::STATUS_ACTIVE;
                    }
                    
                    $articleService->saveArticleFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-article', 'article'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('article', $article);
        $this->view->assign('form', $form);
    }
    
    // ajax actions
    
    public function addArticlePhotoAction() {
        $articleService = $this->_service->getService('Article_Service_Article');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$article = $articleService->getArticle((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Article not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $href = $this->getRequest()->getParam('hrefs');

        if(is_string($href) && strlen($href)) {
            $path = str_replace("http://" . $options['domain'], "", $href);
            $filePath = urldecode($options['publicDir'] . $path);
            if(file_exists($filePath)) {
                $pathinfo = pathinfo($filePath);
                $slug = MF_Text::createSlug($pathinfo['basename']);
                $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $root = $article->get('PhotoRoot');
                    if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(News_Model_Doctrine_Article::getArticlePhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(News_Model_Doctrine_Article::getArticlePhotoDimensions()), false);
                    }

                    $article->set('PhotoRoot', $photo);
                    $article->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $list = '';
        
        $articlePhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $article->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $articlePhotos->add($root);
            $list = $this->view->partial('admin/article-main-photo.phtml', 'article', array('photos' => $articlePhotos, 'article' => $article));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $article->getId()
        ));
        
    }
    
    public function editArticlePhotoAction() {
        $articleService = $this->_service->getService('Article_Service_Article');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$article = $articleService->getArticle((int) $this->getRequest()->getParam('article-id'))) {
            throw new Zend_Controller_Action_Exception('Article not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Escort photo not found');
        }

        $form = $photoService->getPhotoForm($photo);
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-article-photo', 'article', array('id' => $article->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-article', 'article', array('id' => $article->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        //$this->view->admincontainer->findOneBy('id', 'croparticlephoto')->setActive();
        $this->view->admincontainer->findOneBy('id', 'editarticle')->setLabel($article->getTitle());
        $this->view->admincontainer->findOneBy('id', 'editarticle')->setParam('id', $article->getId());
        //$this->view->adminTitle = $this->view->translate($this->view->admincontainer->findOneBy('id', 'croparticlephoto')->getLabel());
        
        $this->view->assign('article', $article);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Article_Model_Doctrine_Article::getArticlePhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeArticlePhotoAction() {
        $articleService = $this->_service->getService('Article_Service_Article');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$article = $articleService->getArticle((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Article not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $article->get('PhotoRoot')) {
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
        
        $articlePhotos = new Doctrine_Collection('Media_Model_Doctrine_Photo');
        $root = $article->get('PhotoRoot');
        if($root && !$root->isInProxyState()) {
            $articlePhotos->add($root);
            $list = $this->view->partial('admin/article-main-photo.phtml', 'article', array('photos' => $articlePhotos, 'article' => $article));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $article->getId()
        ));
        
    }
    
}

