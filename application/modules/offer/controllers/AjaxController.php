<?php

/**
 * Indexcontroler
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_AjaxController extends MF_Controller_Action {
    
    public function init() {
        $this->_helper->ajaxContext()
                ->addActionContext('city-select-options', 'json')
                ->addActionContext('update-deal-message-status', 'json')
                ->initContext();
        parent::init();
    }
    
    public function citySelectOptionsAction() {
        $offerService = $this->_service->getService('Offer_Service_Offer');
        
        $this->view->clearVars();
        
        $options = array();
        
        if($id = (int) $this->getRequest()->getParam('id')) {
            $selectOptions = $offerService->getCitySelectOptions($id);
            foreach($selectOptions as $id => $label) {
                $option = array('id' => $id, 'label' => $label);
                $options[] = $option;
            }
        }

        $this->view->assign('options', $options);
    }
    
    public function updateDealMessageStatusAction() {
        $dealService = $this->_service->getService('Offer_Service_Deal');
        
        $this->view->clearVars();
        
        if($dealMessage = $dealService->getDealMessage((int) $this->getRequest()->getParam('id'))) {
            $dealMessage = $dealService->updateDealMessageStatus($dealMessage, $this->getRequest()->getParam('status'));
            $this->view->assign('id', $dealMessage->getId());
        }
        
    }
}

