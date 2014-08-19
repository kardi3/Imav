<?php

/**
 * Offer_Service_Offer
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Service_Offer extends MF_Service_ServiceAbstract {
    
    public static $offerCodePrefix = 'OF';
    
    protected $parameterTemplateTable;
    protected $offerTable;
    protected $noticeTable;
    protected $offerParameterTable;
    protected $noticeParameterTable;
    protected $parameterTable;
    protected $provinceTable;
    protected $cityTable;
    
    public function init() {
        $this->parameterTemplateTable = Doctrine_Core::getTable('Offer_Model_Doctrine_ParameterTemplate');
        $this->offerTable = Doctrine_Core::getTable('Offer_Model_Doctrine_Offer');
        $this->noticeTable = Doctrine_Core::getTable('Offer_Model_Doctrine_Notice');
        $this->offerParameterTable = Doctrine_Core::getTable('Offer_Model_Doctrine_OfferParameter');
        $this->noticeParameterTable = Doctrine_Core::getTable('Offer_Model_Doctrine_NoticeParameter');
        $this->parameterTable = Doctrine_Core::getTable('Offer_Model_Doctrine_Parameter');
        $this->provinceTable = Doctrine_Core::getTable('Default_Model_Doctrine_Province');
        $this->cityTable = Doctrine_Core::getTable('Default_Model_Doctrine_City');
        parent::init();
    }
    
    public function createOfferCode(Offer_Model_Doctrine_Offer $offer) {
        return self::$offerCodePrefix . '-' . MF_Text::timeFormat($offer['created_at'], 'ym') . '-' . $offer['id'];
    }
    
    public function getNotice($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->noticeTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getClientNotice($id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->noticeTable->getNoticeQueryWithCategoryAndNoticeTemplateAndParametersById($id);
        $q = $this->noticeTable->getNoticeQueryWithDealsAndDealMessages($q);
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getAllOffers($countOnly = false, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        if($countOnly) {
            return $this->offerTable->count();
        } else {
            return $this->offerTable->findAll($hydrationMode);
        }
    }
    
    public function getAllNotices($countOnly = false, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        if($countOnly) {
            return $this->noticeTable->count();
        } else {
            return $this->noticeTable->findAll($hydrationMode);
        }
    }
    
    public function getAgentOffer($id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->offerTable->getOfferQueryWithCategoryAndOfferTemplateAndParametersById($id);
        $q = $this->offerTable->getOfferQueryWithDealsAndDealMessages($q);
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getAgentOffers($userId, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->offerTable->getOfferQueryWithParametersByUserId($userId);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getProvinceSelectOptions() {
        $query = $this->provinceTable->getProvinceQuery();
        $provinces = $query->execute();
        $result = array();
        foreach($provinces as $province) {
            $result[$province->getId()] = $province->getName();
        }
        asort($result, SORT_LOCALE_STRING);
        return $result;
    }
    
    public function getCitySelectOptions($provinceId = null) {
        $query = $this->cityTable->getCityQuery();
        if(null != $provinceId) {
            $query->andWhere('c.province_id = ?', (int) $provinceId);
        }
        $query->orderBy('c.name ASC');
        $cities = $query->execute();
        $result = array();
        foreach($cities as $city) {
            $result[$city->getId()] = $city->getName();
        }
        asort($result, SORT_LOCALE_STRING);
        return $result;
    }
    
    public function getAgentOffersPaginationQuery($userId) {
        $q = $this->offerTable->getOfferQueryWithParametersByUserId($userId);
        $q->addOrderBy('o.created_at DESC');
        $q->addGroupBy('o.id');
        return $q;
    }
    
    public function getClientNoticesPaginationQuery($userId) {
        $q = $this->noticeTable->getNoticeQueryWithParametersByUserId($userId);
        $q = $this->noticeTable->getNoticeQueryWithDealsAndDealMessages($q);
        $q->addOrderBy('n.created_at DESC');
        $q->addGroupBy('n.id');
        return $q;
    }
    
    public function getOfferParameterTree() {
        return $this->offerParameterTable->getTree();
    }
    
    public function getNoticeParameterTree() {
        return $this->noticeParameterTable->getTree();
    }
    
    public function getOfferParameterRoot(Offer_Model_Doctrine_Offer $offer) {
        $root = $offer->get('ParameterRoot');
        if($root->isInProxyState()) {
            $root->save();
            $tree = $this->getOfferParameterTree();
            $tree->createRoot($root);
            $offer->set('ParameterRoot', $root);
            $offer->save();
        }
        return $root;
    }
    
    public function getNoticeParameterRoot(Offer_Model_Doctrine_Notice $notice) {
        $root = $notice->get('ParameterRoot');
        if($root->isInProxyState()) {
            $root->save();
            $tree = $this->getNoticeParameterTree();
            $tree->createRoot($root);
            $notice->set('ParameterRoot', $root);
            $notice->save();
        }
        return $root;
    }
    
    public function getOfferForm(Offer_Model_Doctrine_Offer $offer = null) {
        $form = new Offer_Form_Offer();
        if(null != $offer) {
            $form->populate($offer->toArray());
        }
        return $form;
    }
    
    public function getParameterSubForm($offerOrNotice = null, $offerTemplateParameterTemplates = null) {
        $translator = $this->getServiceBroker()->get('translate');
        
        $parameterFieldset = new Offer_Form_ParameterFieldset();
        $parameterFieldset->setDecorators(array('FormElements'));
        
        if(null != $offerTemplateParameterTemplates) {
            foreach($offerTemplateParameterTemplates as $template) {
                $parameterTemplate = $template->get('ParameterTemplate');
                if($parameterTemplate->isRange()) {
                    $rangeFieldset = new Zend_Form_SubForm();
                    
                    $rangeFieldset->addElement('text', 'parameter' . $parameterTemplate->getId() . 'from', array(
                        'label' => 'From',
                        'decorators' => array('ViewHelper', 'Errors', 'Label', 'Description'),
                        'attribs' => array('title' => $parameterTemplate->getDescription() . ' ' . $translator->translate('from')),
                        'required' => true
                    ));
                    $rangeFieldset->addElement('text', 'parameter' . $parameterTemplate->getId() . 'to', array(
                        'label' => 'To',
                        'decorators' => array('ViewHelper', 'Errors', 'Label', 'Description'),
                        'attribs' => array('title' => $parameterTemplate->getDescription() . ' ' . $translator->translate('to')),
                        'required' => true
                    ));
                    
                    $rangeFieldset->setDecorators(array(
                        'FormElements',
                        array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
                        array('Fieldset', array('class' => 'form-inline control-group range'))
                    ));
                    $rangeFieldset->setLegend($parameterTemplate->getName());
                    $parameterFieldset->addSubForm($rangeFieldset, 'parameter' . $parameterTemplate->getId());
                } else {
                    $parameterFieldset->addElement('text', 'parameter' . $parameterTemplate->getId(), array(
                        'label' => $parameterTemplate->getName(),
                        'decorators' => User_BootstrapForm::$bootstrapElementDecorators,
                        'attribs' => array('title' => $parameterTemplate->getDescription()),
                        'required' => true
                    ));
                }
            }
        }
 
        if($offerOrNotice && $offerOrNotice['Parameters']) {
            
            foreach($offerOrNotice['Parameters'] as $parameter) {
                if(strlen($parameter->getValueTo())) {
                    $rangeSubForm = $parameterFieldset->getSubForm('parameter' . $parameter['parameter_template_id']);
                    if($rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'from')) {
                       $rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'from')->setValue($parameter['value']);
                    }
                    if($rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'to')) {
                       $rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'to')->setValue($parameter['value_to']);
                    }
                } else {
                    if($parameterFieldset->getElement('parameter' . $parameter['parameter_template_id'])) {
                       $parameterFieldset->getElement('parameter' . $parameter['parameter_template_id'])->setValue($parameter['value']);
                    }
                }
            }
        }
        
        return $parameterFieldset;
    }
    
    public function getNoticeForm(Offer_Model_Doctrine_Notice $notice = null) {
        $form = new Offer_Form_Notice();
        if(null != $notice) {
            $form->populate($notice->toArray());
            $form->getElement('publish_date')->setValue(MF_Text::timeFormat($notice->getPublishDate(), 'd/m/Y'));
        }
        return $form;
    }
    
    public function getNoticeParameterSubForm(Offer_Model_Doctrine_Notice $notice = null, $noticeTemplateParameterTemplates = null) {
        $parameterFieldset = new Offer_Form_ParameterFieldset();
        $parameterFieldset->setDecorators(array('FormElements'));
        
        $translator = $this->getServiceBroker()->get('translate');
        
        if(null != $noticeTemplateParameterTemplates) {
            foreach($noticeTemplateParameterTemplates as $template) {
                $parameterTemplate = $template->get('ParameterTemplate');
                if($parameterTemplate->isRange()) {
                    $rangeFieldset = new Zend_Form_SubForm();
                    
                    $rangeFieldset->addElement('text', 'parameter' . $parameterTemplate->getId() . 'from', array(
                        'label' => 'From',
                        'decorators' => array('ViewHelper', 'Errors', 'Label', 'Description'),
                        'attribs' => array('title' => $parameterTemplate->getDescription() . ' ' . $translator->translate('from')),
                        'required' => true
                    ));
                    $rangeFieldset->addElement('text', 'parameter' . $parameterTemplate->getId() . 'to', array(
                        'label' => 'To',
                        'decorators' => array('ViewHelper', 'Errors', 'Label', 'Description'),
                        'attribs' => array('title' => $parameterTemplate->getDescription() . ' ' . $translator->translate('to')),
                        'required' => true
                    ));
                    
                    $rangeFieldset->setDecorators(array(
                        'FormElements',
                        array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
                        array('Fieldset', array('class' => 'form-inline control-group range'))
                    ));
                    $rangeFieldset->setLegend($parameterTemplate->getName());
                    $parameterFieldset->addSubForm($rangeFieldset, 'parameter' . $parameterTemplate->getId());
                } else {
                    $parameterFieldset->addElement('text', 'parameter' . $parameterTemplate->getId(), array(
                        'label' => $parameterTemplate->getName(),
                        'decorators' => User_BootstrapForm::$bootstrapElementDecorators,
                        'attribs' => array('title' => $parameterTemplate->getDescription()),
                        'required' => true
                    ));
                }
            }
        }
 
        if($notice['Parameters'] && $parameterFieldset) {
            
            foreach($notice['Parameters'] as $parameter) {
                if(strlen($parameter->getValueTo())) {
                    $rangeSubForm = $parameterFieldset->getSubForm('parameter' . $parameter['parameter_template_id']);
                    if($rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'from')) {
                       $rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'from')->setValue($parameter['value']);
                    }
                    if($rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'to')) {
                       $rangeSubForm->getElement('parameter' . $parameter['parameter_template_id'] . 'to')->setValue($parameter['value_to']);
                    }
                } else {
                    if($parameterFieldset->getElement('parameter' . $parameter['parameter_template_id'])) {
                       $parameterFieldset->getElement('parameter' . $parameter['parameter_template_id'])->setValue($parameter['value']);
                    }
                }
            }
        }
        
        return $parameterFieldset;
    }
    
    public function saveOfferFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$offer = $this->offerTable->getProxy($values['id'])) {
            $offer = $this->offerTable->getRecord();
        }

        $offer->fromArray($values);
        $offer->save();
        
        return $offer;
    }
    
    public function saveNoticeFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$notice = $this->noticeTable->getProxy($values['id'])) {
            $notice = $this->noticeTable->getRecord();
        }

        if(strlen($values['publish_date'])) {
            $values['publish_date'] = MF_Text::timeFormat($values['publish_date'], 'd/m/Y', 'Y-m-d H:i:s');
        }
        
        $notice->fromArray($values);
        
        $notice->save();
        
        return $notice;
    }
    
    public function bindOfferParameters(Offer_Model_Doctrine_Offer $offer, $parameters) {
        $offerParameterRoot = $this->getOfferParameterRoot($offer);
        foreach($parameters as $parameter) {
            $parameter->getNode()->insertAsLastChildOf($offerParameterRoot);
            $offerParameterRoot->refresh();
        }
        return $offer;
    }
    
    public function bindNoticeParameters(Offer_Model_Doctrine_Notice $notice, $parameters) {
        $noticeParameterRoot = $this->getNoticeParameterRoot($notice);
        foreach($parameters as $parameter) {
            $parameter->getNode()->insertAsLastChildOf($noticeParameterRoot);
            $noticeParameterRoot->refresh();
        }
        return $notice;
    }
    
    public function getNoticeSearchForm() {
        $form = new Offer_Form_NoticeSearch();
        $parameterTemplates = $this->parameterTemplateTable->findAll();
        
        $translator = $this->getServiceBroker()->get('translate');
        
        $parameterFieldset = new Offer_Form_ParameterFieldset();
        $parameterFieldset->setDecorators(array('FormElements'));
        foreach($parameterTemplates as $parameterTemplate) {
//            if($parameterTemplate->isRange()) {
                $rangeFieldset = new Zend_Form_SubForm();

                $rangeFieldset->addElement('text', 'parameter' . $parameterTemplate->getId() . 'from', array(
                    'label' => 'From',
                    'decorators' => array('ViewHelper', 'Errors', 'Label', 'Description'),
                    'attribs' => array('title' => $parameterTemplate->getDescription() . ' ' . $translator->translate('from')),
                ));
                $rangeFieldset->addElement('text', 'parameter' . $parameterTemplate->getId() . 'to', array(
                    'label' => 'To',
                    'decorators' => array('ViewHelper', 'Errors', 'Label', 'Description'),
                    'attribs' => array('title' => $parameterTemplate->getDescription() . ' ' . $translator->translate('to')),
                ));

                $rangeFieldset->setDecorators(array(
                    'FormElements',
                    array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
                    array('Fieldset', array('class' => 'form-inline control-group range'))
                ));
                $rangeFieldset->setLegend($parameterTemplate->getName());
                $parameterFieldset->addSubForm($rangeFieldset, 'parameter' . $parameterTemplate->getId());
//            } else {
//                $parameterFieldset->addElement('text', 'parameter' . $parameterTemplate->getId(), array(
//                    'label' => $parameterTemplate->getName(),
//                    'decorators' => User_BootstrapForm::$bootstrapElementDecorators,
//                    'attribs' => array('title' => $parameterTemplate->getDescription()),
//                    'required' => true
//                ));
//            }
        }
        $form->addSubForm($parameterFieldset, 'parameters');
        
        return $form;
    }
    
    public function getNoticeSearchResultQuery($values) {
        $templateService = $this->getServiceBroker()->getService('Offer_Service_Template');
        $criteria = array();
        
        $parameterValues = $values['parameters'];
        
        foreach($parameterValues as $name => $value) {
            $match = array();

            if(!is_array($value)) {
                preg_match('/^parameter(\d+)/', $name, $match);
                if(isset($match[1])) {
                    $parameterTemplate = $templateService->getParameterTemplate((int) $match[1]);
                    $criterium = array($parameterTemplate->getId() => $value);
                    $criteria[$match[1]] = $criterium;
                }
            } else {
                foreach($value as $rangeKey => $rangeValue) {
                    preg_match('/^parameter(\d+)(from|to)/', $rangeKey, $match);
                    if(isset($match[1]) && $parameterTemplate = $templateService->getParameterTemplate((int) $match[1])) {
                        $criterium = array($match[2] => $rangeValue);
                        if(is_array($criteria[$match[1]])) {
                            $criterium = array_merge($criteria[$match[1]], $criterium);
                        }
                        $criteria[$match[1]] = $criterium;

                    }
                }
            }

        }

        $query = $this->noticeTable->getNoticeQueryWithCategoryAndNoticeTemplateAndParameters();
        if(strlen($values['term'])) {
            $query->andWhere('(n.title LIKE ? OR n.content LIKE ?)', array('%' . $values['term'] . '%', '%' . $values['term'] . '%'));
        }
        
        $query->andWhere('n.province_id = ?', $values['province_id']);
//        $query->andWhere('n.city_id = ?', $values['city_id']);
        foreach($criteria as $parameterTemplateId => $value) {
            if(is_array($value)) {
                $query->orWhere('(p.parameter_template_id = ? AND (((p.value_to IS NULL AND p.value >= ? AND p.value <= ?) OR (p.value IS NOT NULL AND p.value >= ? AND p.value_to <= ?))))', array($parameterTemplateId, $value['from'], $value['to'], $value['from'], $value['to']));
            }
        }
        $query->orderBy('n.publish_date DESC');
        return $query;
    }
}

