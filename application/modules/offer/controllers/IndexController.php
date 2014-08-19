<?php

/**
 * Indexcontroler
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_IndexController extends MF_Controller_Action {
    
    public function categoryAction() {
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if(!$category = $categoryService->getCategory($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Page not found', 404);
        }
        
        $metatagService->setViewMetatags($category->get('Metatags'), $this->view);
        
        $this->view->assign('category', $category);
        
//var_dump($this->view->navigation()->getAcl()->isAllowed('guest', 'offer:index', 'category'));exit;
        if($categoryItem = $this->view->navigation($this->view->breadcrumbscontainer)->findOneById('offercategory')) {
            $categoryItem->setParam('slug', $category['slug']);
            $categoryItem->setLabel($category['name']);
        }
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
}

