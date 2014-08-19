<?php

/**
 * Censor
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_Service_Censor extends MF_Service_ServiceAbstract {
    
    protected $censorTable;
    
    public function init() {
        $this->censorTable = Doctrine_Core::getTable('Censor_Model_Doctrine_Censor');
    }
    
    public function getCensor($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->censorTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function fetchCensor($type, $language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $serviceBroker = $this->getServiceBroker();
        $translator = $serviceBroker->get('translate');
        
        $censorTypes = Censor_Model_Doctrine_Censor::getAvailableTypes();
        
        if(!$censor = $this->getCensor($type, 'type', $hydrationMode)) {
            $censor = $this->censorTable->getRecord();
            $censor->Translation[$language]->title = $translator->translate($censorTypes[$type], $language);
            $censor->Translation[$language]->slug = MF_Text::createSlug($censor->Translation[$language]->title);
            $censor->setType($type);
            $censor->save();
        }
        return $censor;
    }
    
    public function getI18nCensor($id, $field = 'id', $language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->censorTable->getFullCensorQuery();
        switch($field) {
            case 'slug':
            case 'title':
                $q->andWhere('t.' . $field . ' = ?', $id);
                break;
            default:
                $q->andWhere('p.' . $field . ' = ?', $id);
        }
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getAllCensors() {
        return $this->censorTable->findAll();
    }
    
    public function getCensorSelectOptions($language, $prependEmptyValue = false, $idPrefix = '') {
        $censors = $this->getAllCensors();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = null;
        }
        foreach($censors as $censor) {
            $result[$idPrefix . $censor->getId()] = $censor->get('Translation')->get($language)->title;
        }
        return $result;
    }
    
    public function getCensorForm(Censor_Model_Doctrine_Censor $censor = null) {
        $form = new Censor_Form_Censor();
        if(null !== $censor) {
            $form->populate($censor->toArray());
        }
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            $i18nSubform = $form->translations->getSubForm($language);
            if($i18nSubform) {
                $i18nSubform->getElement('title')->setValue($censor->Translation[$language]->title);
                $i18nSubform->getElement('content')->setValue($censor->Translation[$language]->content);
            }
        }
        return $form;
    }
    
    public function saveCensorFromArray(array $values) {
        $serviceBroker = $this->getServiceBroker();
        $translator = $serviceBroker->get('translate');
        
        $types = Censor_Model_Doctrine_Censor::getAvailableTypes();

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
                
        if($values['type']) {
            if(!$censor = $this->getCensor($values['type'], 'type')) {
                if(!$censor = $this->censorTable->getProxy($values['id'])) {
                    $censor = $this->censorTable->getRecord();
                }
            }
        } else {
            if(!$censor = $this->censorTable->getProxy($values['id'])) {
                $censor = $this->censorTable->getRecord();
            }
        }
        
        $censor->fromArray($values);
        foreach($values['translations'] as $language => $translation) {
           // echo $language;
//            if($values['type']) {
//                $censor->Translation[$language]->title = $translator->translate($types[$values['type']]);
//            } else {
//                $censor->Translation[$language]->title = $translation['title'];
//            }
            $censor->Translation[$language]->title = $translation['title'];
            $censor->Translation[$language]->slug = MF_Text::createSlug($values['translations'][$language]['title']);
            $censor->Translation[$language]->content = $translation['content'];
        }
        $censor->save();
        return $censor;
    }
    
    public function removeCensor(Censor_Model_Doctrine_Censor $censor) {
        $censor->get('Translation')->delete();
        $censor->delete();
    }
    
}

