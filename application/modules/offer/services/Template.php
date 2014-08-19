<?php

/**
 * Offer_Service_Template
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Service_Template extends MF_Service_ServiceAbstract {
    
    protected $parameterTemplateTable;
    protected $parameterTable;
    protected $offerTemplateParameterTemplateTanle;
    protected $offerTemplateTable;
    protected $noticeTemplateParameterTemlpateTable;
    protected $noticeTemplateTable;
    
    public function init() {
        $this->parameterTemplateTable = Doctrine_Core::getTable('Offer_Model_Doctrine_ParameterTemplate');
        $this->offerParameterTable = Doctrine_Core::getTable('Offer_Model_Doctrine_OfferParameter');
        $this->noticeParameterTable = Doctrine_Core::getTable('Offer_Model_Doctrine_NoticeParameter');
        $this->offerTemplateParameterTemplateTanle = Doctrine_Core::getTable('Offer_Model_Doctrine_OfferTemplateParameterTemplate');
        $this->noticeTemplateParameterTemplateTable = Doctrine_Core::getTable('Offer_Model_Doctrine_NoticeTemplateParameterTemplate');
        $this->offerTemplateTable = Doctrine_Core::getTable('Offer_Model_Doctrine_OfferTemplate');
        $this->noticeTemplateTable = Doctrine_Core::getTable('Offer_Model_Doctrine_NoticeTemplate');
        parent::init();
    }
    
    public function getParameterTemplate($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->parameterTemplateTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getParameterTemplatesByNames($names, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->parameterTemplateTable->findAllByNames($names, $hydrationMode);
    }
    
//    public function getParameterTemplatesByCategory($cateogoryId, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
//        return $this->parameterTemplateTable->findAllByNames($names, $hydrationMode);
//    }
    
    public function getParameterTemplateSelectOptions() {
        $result = array();
        $parameters = $this->parameterTemplateTable->getSortedParameterTemplates();
        foreach($parameters as $parameter) {
            $result[$parameter->getId()] = $parameter->getName();
        }
        return $result;
    }
    
    public function getParameterTemplateForm(Offer_Model_Doctrine_ParameterTemplate $template = null) {
        $form = new Offer_Form_ParameterTemplate();
        $unitOptions = array_merge(array('' => null), Offer_Model_Doctrine_ParameterTemplate::$unitTypes);
        $form->getElement('unit')->setMultiOptions($unitOptions);
        if(null != $template) {
            $form->populate($template->toArray());
        }
        return $form;
    }
    
    public function getOfferTemplateParameterTemplateNames($offerTemplate) {
        $result = array();
        $root = $this->getOfferTemplateParameteTemplateRoot($offerTemplate);
        foreach($root->getNode()->getChildren() as $child) {
            $parameterTemplate = $child->get('ParameterTemplate');
            $result[] = $parameterTemplate->getName();
        }
        return $result;
    }
    
    public function getNoticeTemplateParameterTemplateNames($noticeTemplate) {
        $result = array();
        $root = $this->getNoticeTemplateParameteTemplateRoot($noticeTemplate);
        foreach($root->getNode()->getChildren() as $child) {
            $parameterTemplate = $child->get('ParameterTemplate');
            $result[] = $parameterTemplate->getName();
        }
        return $result;
    }
    
    public function getCategoryOfferTemplate(Offer_Model_Doctrine_Category $category) {
        $offerTemplate = $category->get('OfferTemplate');
        if($offerTemplate->isInProxyState()) {
            $offerTemplate = $this->offerTemplateTable->getRecord();
            $offerTemplate->set('Category', $category);
            $offerTemplate->save();
        }
        return $offerTemplate;
    }
    
    public function getCategoryNoticeTemplate(Offer_Model_Doctrine_Category $category) {
        $noticeTemplate = $category->get('NoticeTemplate');
        if($noticeTemplate->isInProxyState()) {
            $noticeTemplate = $this->noticeTemplateTable->getRecord();
            $noticeTemplate->set('Category', $category);
            $noticeTemplate->save();
        }
        return $noticeTemplate;
    }
    
    public function getOfferTemplateParameterTemplates(Offer_Model_Doctrine_OfferTemplate $offerTemplate) {
        if($root = $this->getOfferTemplateParameteTemplateRoot($offerTemplate)) {
            return $root->getNode()->getChildren();
        }
    }
    
    public function getNoticeTemplateParameterTemplates(Offer_Model_Doctrine_NoticeTemplate $noticeTemplate) {
        if($root = $this->getNoticeTemplateParameteTemplateRoot($noticeTemplate)) {
            return $root->getNode()->getChildren();
        }
    }
    
    public function getOfferTemplateParameteTemplateRoot(Offer_Model_Doctrine_OfferTemplate $offerTemplate) {
        $root = $offerTemplate->get('OfferTemplateParameterTemplateRoot');
        if($root->isInProxyState()) {
            $template = $this->offerTemplateParameterTemplateTanle->getRecord();
            $template->set('OfferTemplate', $offerTemplate);
            $template->save();
            $tree = $this->offerTemplateParameterTemplateTanle->getTree();
            $root = $tree->createRoot($template);
        }
        return $root;
    }
    
    public function getNoticeTemplateParameteTemplateRoot(Offer_Model_Doctrine_NoticeTemplate $noticeTemplate) {
        $root = $noticeTemplate->get('NoticeTemplateParameterTemplateRoot');
        if($root->isInProxyState()) {
            $template = $this->noticeTemplateParameterTemplateTable->getRecord();
            $template->set('NoticeTemplate', $noticeTemplate);
            $template->save();
            $tree = $this->noticeTemplateParameterTemplateTable->getTree();
            $root = $tree->createRoot($template);
        }
        return $root;
    }

    public function cleanOfferTemplateParameterTemplateRoot(Offer_Model_Doctrine_OfferTemplate $offerTemplate) {
        $root = $this->getOfferTemplateParameteTemplateRoot($offerTemplate);
        if($root->getNode()->getChildren()) {
            $root->getNode()->getChildren()->delete();
            $root->getNode()->setLeftValue(1);
            $root->getNode()->setRightValue(2);
            $root->save();
        }
    }
    
    public function cleanNoticeTemplateParameterTemplateRoot(Offer_Model_Doctrine_NoticeTemplate $noticeTemplate) {
        $root = $this->getNoticeTemplateParameteTemplateRoot($noticeTemplate);
        if($root->getNode()->getChildren()) {
            $root->getNode()->getChildren()->delete();
            $root->getNode()->setLeftValue(1);
            $root->getNode()->setRightValue(2);
            $root->save();
        }
    }
    
    public function bindParameterTemplatesToOfferTemplate(Doctrine_Collection $parameterTemplates, Offer_Model_Doctrine_OfferTemplate $offerTemplate) {
        $this->cleanOfferTemplateParameterTemplateRoot($offerTemplate);
        $root = $this->getOfferTemplateParameteTemplateRoot($offerTemplate);
        foreach($parameterTemplates as $template) {
            $offerTemplateParameterTemplate = $this->offerTemplateParameterTemplateTanle->getRecord();
            $offerTemplateParameterTemplate->set('ParameterTemplate', $template);
            $offerTemplateParameterTemplate->save();
            $offerTemplateParameterTemplate->getNode()->insertAsLastChildOf($root);
            $root->refresh(); // !!! root node have to be refreshed after each insert
        }
        return $offerTemplate;
    }
    
    public function bindParameterTemplatesToNoticeTemplate(Doctrine_Collection $parameterTemplates, Offer_Model_Doctrine_NoticeTemplate $noticeTemplate) {
        $this->cleanNoticeTemplateParameterTemplateRoot($noticeTemplate);
        $root = $this->getNoticeTemplateParameteTemplateRoot($noticeTemplate);
        foreach($parameterTemplates as $template) {
            $noticeTemplateParameterTemplate = $this->noticeTemplateParameterTemplateTable->getRecord();
            $noticeTemplateParameterTemplate->set('ParameterTemplate', $template);
            $noticeTemplateParameterTemplate->save();
            $noticeTemplateParameterTemplate->getNode()->insertAsLastChildOf($root);
            $root->refresh(); // !!! root node have to be refreshed after each insert
        }
        return $noticeTemplate;
    }
    
    public function saveParameterTemplateFromArray(array $values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$template = $this->getParameterTemplate((int) $values['id'])) {
            $template = $this->parameterTemplateTable->getRecord();
        }

        $template->fromArray($values);
        $template->save();
        
        return $template;
    }
    
    public function retrieveParameterTemplatesFromNames(array $parameterNames) {
        $result = new Doctrine_Collection('Offer_Model_Doctrine_ParameterTemplate');
        $parameterTemplates = $this->getParameterTemplatesByNames($parameterNames);
        foreach($parameterNames as $name) {
            foreach($parameterTemplates as $template) {
                if($template->getName() == $name) {
                    $result->add($template);
                }
            }
        }
        return $result;
    }
    
    public function createOfferParameter(Offer_Model_Doctrine_ParameterTemplate $parameterTemplate, $value) {
        $parameter = $this->offerParameterTable->getRecord();
        $parameter->set('ParameterTemplate', $parameterTemplate);
        if(is_array($value)) {
            if(isset($value[0]))
                $parameter->setValue($value[0]);
            if(isset($value[1]))
                $parameter->setValueTo($value[1]);
        } else {
            $parameter->setValue($value);
        }
        $parameter->save();
        return $parameter;
    }
    
    public function createNoticeParameter(Offer_Model_Doctrine_ParameterTemplate $parameterTemplate, $value) {
        $parameter = $this->noticeParameterTable->getRecord();
        $parameter->set('ParameterTemplate', $parameterTemplate);
        if(is_array($value)) {
            if(isset($value[0]))
                $parameter->setValue($value[0]);
            if(isset($value[1]))
                $parameter->setValueTo($value[1]);
        } else {
            $parameter->setValue($value);
        }
        $parameter->save();
        return $parameter;
    }
    
    public function saveOfferParameter(Offer_Model_Doctrine_Offer $offer, Offer_Model_Doctrine_ParameterTemplate $parameterTemplate, $value) {
        $offerParameter = $this->offerParameterTable->findOneByParameterRootIdIdAndParameterTemplateId($offer->getParameterRootId(), $parameterTemplate->getId());
        if(!is_array($value)) {
            $offerParameter->setValue($value);
        } else {
            if(isset($value[0])) {
                $offerParameter->setValue($value[0]);
            }
            if(isset($value[1])) {
                $offerParameter->setValueTo($value[1]);
            }
        }
        return $offerParameter;
    }
    
    public function saveNoticeParameter(Offer_Model_Doctrine_Notice $notice, Offer_Model_Doctrine_ParameterTemplate $parameterTemplate, $value) {
        $noticeParameter = $this->noticeParameterTable->findOneByParameterRootIdIdAndParameterTemplateId($notice->getParameterRootId(), $parameterTemplate->getId());
        if(!is_array($value)) {
            $noticeParameter->setValue($value);
        } else {
            if(isset($value[0])) {
                $noticeParameter->setValue($value[0]);
            }
            if(isset($value[1])) {
                $noticeParameter->setValueTo($value[1]);
            }
        }
        return $noticeParameter;
    }
}

