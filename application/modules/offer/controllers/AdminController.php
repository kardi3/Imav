<?php

/**
 * AdminController
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_AdminController extends MF_Controller_Action {
    
    public function init() {
        $this->_helper->ajaxContext()
                ->addActionContext('move-category', 'json')
                ->addActionContext('remove-category', 'json')
                ->addActionContext('get-category-data', 'json')
                ->initContext();
        parent::init();
    }
    
    public function listCategoryAction() {
        $categoryService = $this->_service->getService('Offer_Service_Category');
        
        $form = $categoryService->getCategoryForm();
        $form->setAction($this->view->adminUrl('add-category', 'offer'));
        
        if(!$categoryRoot = $categoryService->getCategoryRoot()) {
            $categoryService->createCategoryRoot($this->_service->get('translate')->translate('Categories'));
        }

        if(!$parent = $categoryService->getCategory($this->getRequest()->getParam('id', 0))) {
            $parent = $categoryService->getCategoryRoot();
        }
        
        $form->getElement('parent_id')->setValue($parent->getId());
        
        $categoryTree = $categoryService->getCategoryTree();
        
        $categoryPriceTree = $categoryService->getCategoryPriceTree();
        
        if($current = $this->view->admincontainer->findOneBy('id', 'category')) {
            $current->setActive(true);
        }
        
        $periods = array_keys(Offer_Model_Doctrine_CategoryPrice::getAvailablePeriods());
        $this->view->assign('periods', $periods);
        
        $this->view->assign('form', $form);
        $this->view->assign('parent', $parent);
        $this->view->assign('categoryTree', $categoryTree);
        $this->view->assign('categoryPriceTree', $categoryPriceTree);
    }
    
    public function listCategoryDataAction() {
        $table = Doctrine_Core::getTable('Offer_Model_Doctrine_Category');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Offer_DataTables_Category', 
            'columns' => array('x.name'),
            'searchFields' => array('x.name')
        ));
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result->name;
            $options = '<a href="' . $this->view->adminUrl('edit-category', 'offer', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon16 icon-edit"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-category', 'offer', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getTotal(),
            "iTotalDisplayRecords" => $dataTables->getDisplayTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    
    public function addCategoryAction() {
        $categoryService = $this->_service->getService('Offer_Service_Category');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $templateService = $this->_service->getService('Offer_Service_Template');
        
        $translator = $this->_service->get('translate');
        
        $form = $categoryService->getCategoryForm();
        $form->getElement('offer_parameters')->setMultiOptions($templateService->getParameterTemplateSelectOptions());
        $form->getElement('notice_parameters')->setMultiOptions($templateService->getParameterTemplateSelectOptions());
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        $form->setAction($this->view->adminUrl('add-category', 'offer'));
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    $category = $categoryService->saveCategoryFromArray($values);

                    if($metatags = $metatagService->saveMetatagsFromArray($values['metatags'], array('title' => $values['name'], 'description' => $values['description'], 'keywords' => $values['description']))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                
                    $parentId = $category->getNode()->getParent() ? $category->getNode()->getParent()->getId() : null;
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'offer', array('id' => $parentId)));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('form', $form);
    }
    
    public function editCategoryAction() {
        $categoryService = $this->_service->getService('Offer_Service_Category');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $templateService = $this->_service->getService('Offer_Service_Template');
        
        $translator = $this->_service->get('translate');
        
        if(!$category = $categoryService->getCategory((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Category not found');
        }
        
        $form = $categoryService->getCategoryForm($category);
        $form->getElement('offer_parameters')->setMultiOptions($templateService->getParameterTemplateSelectOptions());
        $form->getElement('notice_parameters')->setMultiOptions($templateService->getParameterTemplateSelectOptions());
        
        $metatagsForm = $metatagService->getMetatagsSubForm($category->get('Metatags'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        $priceForm = $categoryService->getCategoryPriceForm($category->get('Prices'));
        $form->addSubForm($priceForm, 'pricelist');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                    $values = $form->getValues();
                    
                    if($metatags = $metatagService->saveMetatagsFromArray($values['metatags'], array('title' => $values['name'], 'description' => $values['description'], 'keywords' => $values['description']))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $category = $categoryService->saveCategoryFromArray($values);

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $prices = $values['pricelist']['prices'];
                    $categoryService->saveCategoryPrices($category, $prices);
                    
                    // persisting offer tamplates with parameters
                    $offerTemplate = $templateService->getCategoryOfferTemplate($category);
                    
                    $offerParameterNames = explode(',', $this->getRequest()->getParam('offer_parameter-list'));

                    $offerParameterTemplates = $templateService->retrieveParameterTemplatesFromNames($offerParameterNames);

                    $templateService->bindParameterTemplatesToOfferTemplate($offerParameterTemplates, $offerTemplate);
                    //
                    
                    // persisting notice tamplates with parameters
                    $noticeTemplate = $templateService->getCategoryNoticeTemplate($category);
                    
                    $noticeParameterNames = explode(',', $this->getRequest()->getParam('notice_parameter-list'));

                    $noticeParameterTemplates = $templateService->retrieveParameterTemplatesFromNames($noticeParameterNames);

                    $templateService->bindParameterTemplatesToNoticeTemplate($noticeParameterTemplates, $noticeTemplate);
                    //
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
 
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-category', 'offer', array('id' => $category->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $offerTemplate = $category->get('OfferTemplate');
        $offerParameterNames = $templateService->getOfferTemplateParameterTemplateNames($offerTemplate);
        $this->view->assign('offerParameterNames', Zend_Json::encode($offerParameterNames));
        $noticeTemplate = $category->get('NoticeTemplate');
        $noticeParameterNames = $templateService->getNoticeTemplateParameterTemplateNames($noticeTemplate);
        $this->view->assign('noticeParameterNames', Zend_Json::encode($noticeParameterNames));

        $addForm = $categoryService->getCategoryForm();
        $addForm->setAction($this->view->adminUrl('add-category', 'offer'));
        
        if(!$categoryRoot = $categoryService->getCategoryRoot()) {
            $categoryService->createCategoryRoot($this->_service->get('translate')->translate('Categories'));
        }

        $addForm->getElement('parent_id')->setValue($category->getId());
        
        $categoryTree = $categoryService->getCategoryTree();
        
        if($current = $this->view->admincontainer->findOneBy('id', 'edit-category')) {
            $current->setLabel($translator->translate($current->getLabel()) . ' ' . $category->getName());
            $current->setActive(true);
            $this->view->assign('adminTitle', $current->getLabel());
        }
        
        $this->view->assign('addForm', $addForm);
        $this->view->assign('parent', $category);
        $this->view->assign('categoryTree', $categoryTree);
        $this->view->assign('form', $form);
    }
    
    public function listParameterTemplateAction() {
        $templateService = $this->_service->getService('Offer_Service_Template');
        
        $form = $templateService->getParameterTemplateForm();

        $this->view->assign('form', $form);
    }
    
    public function listParameterTemplateDataAction() {
        $table = Doctrine_Core::getTable('Offer_Model_Doctrine_ParameterTemplate');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Offer_DataTables_ParameterTemplate', 
            'columns' => array('x.name', 'x.unit'),
            'searchFields' => array('x.name')
        ));
        $results = $dataTables->getResult();
        
        $translator = $this->_service->get('Zend_Translate');
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result->name;
            $row[] = Offer_Model_Doctrine_ParameterTemplate::$unitTypes[$result->unit];
            $row[] = $result->range ? $translator->translate('Yes') : $translator->translate('No');
            $options = '<a href="' . $this->view->adminUrl('edit-parameter-template', 'offer', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon16 icon-edit"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-parameter-template', 'offer', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getTotal(),
            "iTotalDisplayRecords" => $dataTables->getDisplayTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
        
        
        
    }
    
    public function addParameterTemplateAction() {
        $templateService = $this->_service->getService('Offer_Service_Template');
        
        $form = $templateService->getParameterTemplateForm();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $values = $form->getValues();

                    $template = $templateService->saveParameterTemplateFromArray($values);
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-parameter-template', 'offer'));
                } catch(Exception $e) {
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('form', $form);
    }
    
    public function editParameterTemplateAction() {
        $templateService = $this->_service->getService('Offer_Service_Template');
        
        if(!$template = $templateService->getParameterTemplate((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Temlpate not found');
        }
        
        $form = $templateService->getParameterTemplateForm($template);

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $values = $form->getValues();

                    $template = $templateService->saveParameterTemplateFromArray($values);
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-parameter-template', 'offer'));
                } catch(Exception $e) {
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('template', $template);
        $this->view->assign('form', $form);
    }
    
    public function listOfferAction() {        
        
    }
    
    public function listOfferDataAction() {
        $table = Doctrine_Core::getTable('Offer_Model_Doctrine_Offer');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Offer_DataTables_Offer', 
            'columns' => array('x.title'),
            'searchFields' => array('x.title')
        ));
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result->title;
            $row[] = MF_Text::timeFormat($result->created_at, 'H:i d/m/Y');
            $options = '<a href="' . $this->view->adminUrl('edit-offer', 'offer', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon16 icon-edit"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-offer', 'offer', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getTotal(),
            "iTotalDisplayRecords" => $dataTables->getDisplayTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
        
    }
    
    public function listNoticeAction() {        
        $userService = $this->_service->getService('User_Service_User');
        if($this->getRequest()->getParam('user-id')) {
            $user = $userService->getUser((int) $this->getRequest()->getParam('user-id'));
            $this->view->assign('userId', $user->getId());
        }
    }
    
    public function listNoticeDataAction() {
        $table = Doctrine_Core::getTable('Offer_Model_Doctrine_Notice');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Offer_DataTables_Notice', 
            'columns' => array('c.name', 'x.title'),
            'searchFields' => array('c.name', 'x.title')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result['Category']['name'];
            $row[] = $result['title'];
            $row[] = '<a href="' . $this->view->adminUrl('list-notice-deal', 'offer', array('notice-id' => $result['id'])) . '">' . $result['deal_count'] . ' / ' . $result['deal_message_count'] . '</a>';
            $row[] = MF_Text::timeFormat($result->created_at, 'H:i d/m/Y');
            $options = '<a href="' . $this->view->adminUrl('edit-notice', 'offer', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon16 icon-edit"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-notice', 'offer', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getTotal(),
            "iTotalDisplayRecords" => $dataTables->getDisplayTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
        
    }
    
    public function listNoticeDealAction() {
        $offerService = $this->_service->getService('Offer_Service_Offer');
        $dealService = $this->_service->getService('Offer_Service_Deal');
  
        $translator = $this->_service->get('translate');
        
        if(!$notice = $offerService->getNotice((int) $this->getRequest()->getParam('notice-id'))) {
            throw new Zend_Controller_Action_Exception('Notice not found');
        }
        
        if(!$deal = $dealService->getDeal((int) $this->getRequest()->getParam('deal-id'))) {
            $deal = $dealService->getLastNoticeDeal($notice->getId());
        }

        if($current = $this->view->admincontainer->findOneBy('id', 'listnoticedeal')) {
            $this->view->assign('adminTitle', $translator->translate($current->getLabel()) . ' "' . $notice['title'] . '" ');
            $current->setLabel($notice['title'] . ' - ' . $translator->translate('Contacts'));
        }
        
        $this->view->assign('notice', $notice);
        $this->view->assign('deal', $deal);
    }
    
    public function listNoticeDealDataAction() {
        $table = Doctrine_Core::getTable('Offer_Model_Doctrine_Deal');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Offer_DataTables_Deal', 
            'columns' => array('c.name', 'x.title'),
            'searchFields' => array('c.name', 'x.title')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result['Notice']['Category']['name'];
            $row[] = '<a href="' . $this->view->adminUrl('list-notice-deal', 'offer', array('notice-id' => $result['notice_id'], 'deal-id' => $result['id'])) . '">' . $result['Notice']['title'] . '</a>';
            $row[] = MF_Text::timeFormat($result->created_at, 'H:i d/m/Y');
            $options = '<a href="' . $this->view->adminUrl('edit-notice', 'offer', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon16 icon-edit"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('remove-notice', 'offer', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getTotal(),
            "iTotalDisplayRecords" => $dataTables->getDisplayTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    
    // ajax actions
    
    public function moveCategoryAction() {
        $categoryService = $this->_service->getService('Offer_Service_Category');
     
        $this->view->clearVars();
        
        $status = 'success';
        
        $category = $categoryService->getCategory((int) $this->getRequest()->getParam('id'));
        
        $dest = $categoryService->getCategory((int) $this->getRequest()->getParam('dest_id'));
  
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
            
            $categoryService->moveCategory($category, $dest, $this->getRequest()->getParam('mode', 'after'));

            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage());
            $status= 'error';
        }
        
        $this->view->assign('status', $status);
    }
    
    public function removeCategoryAction() {
        $categoryService = $this->_service->getService('Offer_Service_Category');
     
        $this->view->clearVars();
        
        $status = 'success';
        
        if($category = $categoryService->getCategory((int) $this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $parent = $category->getNode()->getParent();
                
                $categoryService->removeCategory($category);
                
                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                
                if(!$this->getRequest()->isXmlHttpRequest()) {
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'offer', array('id' => $parent->getId())));
                }
            } catch(Exception $e) {
                $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                $this->_service->get('log')->log($e->getMessage());
                $status = 'error';
            }
        }
        
        $this->_helper->viewRenderer->setNoRender();
        
        $this->view->assign('status', $status);
    }
    
    public function getCategoryDataAction() {
        $categoryService = $this->_service->getService('Offer_Service_Category');
        
        $this->view->clearVars();
        
        if($category = $categoryService->getCategory((int) $this->getRequest()->getParam('id'), 'id', Doctrine_Core::HYDRATE_ARRAY)) {
            $this->view->assign('data', $category);
        }
    }
}

