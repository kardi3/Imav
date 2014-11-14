<?php

/**
 * Censor
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_Service_Censor extends MF_Service_ServiceAbstract {
    
    protected $censorTable;
    protected $censorTranslationTable;
    
    public function init() {
        $this->censorTable = Doctrine_Core::getTable('Censor_Model_Doctrine_Censor');
        $this->censorTranslationTable = Doctrine_Core::getTable('Censor_Model_Doctrine_CensorTranslation');
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
    
    public function getAllCensors($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->censorTranslationTable->getShortCensorQuery();
        
        return $q->execute(array(), $hydrationMode);
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
            }
        }
        return $form;
    }
    
    public function saveCensorFromArray(array $values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
         
        if(!$censor = $this->censorTable->getProxy($values['id'])) {
            $censor = $this->censorTable->getRecord();
        }
       
        
        $censor->fromArray($values);
        foreach($values['translations'] as $language => $translation) {
            $censor->Translation[$language]->title = $translation['title'];
            $censor->Translation[$language]->slug = MF_Text::createSlug($values['translations'][$language]['title']);
        }
        $censor->save();
        return $censor;
    }
    
    public function removeCensor(Censor_Model_Doctrine_Censor $censor) {
        $censor->get('Translation')->delete();
        $censor->delete();
    }
    public function checkCensor($text) {
        $words = $this->getAllCensors(Doctrine_Core::HYDRATE_SINGLE_SCALAR);
        foreach($words as $word):
            if (strpos($text,$word) !== false) {
                return false;
            }
        endforeach;
        return true;
    }
    
}

