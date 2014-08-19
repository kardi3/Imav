<?php

/**
 * Guests_AdminController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Guests_AdminController extends MF_Controller_Action {
    
    
    public function listPostAction() {

    }
    
    public function listPostDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Guests_Model_Doctrine_Post');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Guests_DataTables_Post', 
            'columns' => array('x.name', 'x.created_at'),
            'searchFields' => array('x.name')
        ));
        
        $results = $dataTables->getResult();
        
        $language = $i18nService->getAdminLanguage();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result['name'];
            if ($result['publish'] == 1)
                $row[] = '<a href="' . $this->view->adminUrl('public-post', 'guests', array('post-id' => $result['id'])) . '" title=""><span class="icon16 icomoon-icon-checkbox-2"></span></a>';
            else 
                $row[] = '<a href="' . $this->view->adminUrl('public-post', 'guests', array('post-id' => $result['id'])) . '" title=""><span class="icon16 icomoon-icon-checkbox-unchecked-2"></span></a>';
            $row[] = MF_Text::timeFormat($result->created_at, 'H:i d/m/Y');
            $options = '<a href="' . $this->view->adminUrl('edit-post', 'guests', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-post', 'guests', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function editPostAction() {
        $guestsService = $this->_service->getService('Guests_Service_Guests');

        if(!$post = $guestsService->getPost($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Post not found');
        }
        
        $translator = $this->_service->get('translate');

        $form = $guestsService->getEditPostForm($post);
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    $post = $guestsService->savePostFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-post', 'guests'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('post', $post);
        $this->view->assign('form', $form);
    }
    
    public function removePostAction() {
        $guestsService = $this->_service->getService('Guests_Service_Guests');
        
        if($post = $guestsService->getPost($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $guestsService->removePost($post);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-post', 'guests'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-post', 'guests'));
    }
    
    public function publicPostAction() {
        $guestsService = $this->_service->getService('Guests_Service_Guests');
        
        if(!$post = $guestsService->getPost((int) $this->getRequest()->getParam('post-id'))) {
            throw new Zend_Controller_Action_Exception('Post not found');
        }
        
        $guestsService->refreshPost($post);
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-post', 'guests'));
        $this->_helper->viewRenderer->setNoRender();
    }
    
}

