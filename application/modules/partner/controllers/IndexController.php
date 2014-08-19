<?php

/**
 * Partner_IndexController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Partner_IndexController extends MF_Controller_Action {
 
   public function listPartnerSerwis10Action(){
        $partnerService = $this->_service->getService('Partner_Service_PartnerSerwis10');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if(!$partners = $partnerService->getAllPartners()) {
            throw new Zend_Controller_Action_Exception('Partners not found ');
        }
        
        
        $this->view->assign('partners', $partners);
        $this->_helper->actionStack('layout-serwis10', 'index', 'default');
        
    }
}

