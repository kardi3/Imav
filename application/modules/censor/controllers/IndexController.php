<?php

/**
 * Censor_IndexController
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_IndexController extends MF_Controller_Action {
    
    public function indexAction() {
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        $censorService = $this->_service->getService('Censor_Service_Censor');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if(!$censor = $censorService->getI18nCensor($this->getRequest()->getParam('slug'), 'slug', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Censor not found');
        }
        $photoDimension = $photoDimensionService->getElementDimension('censor');
        
        $metatagService->setViewMetatags($censor['metatag_id'], $this->view);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->view->assign('censor', $censor);
        $this->view->assign('photoDimension', $photoDimension);
    }
}

