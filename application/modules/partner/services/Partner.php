<?php

/**
 * Partner_Service_Partner
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Partner_Service_Partner extends MF_Service_ServiceAbstract {
    
    protected $partnerTable;
    
    public function init() {
        $this->partnerTable = Doctrine_Core::getTable('Partner_Model_Doctrine_Partner');
    }
      
    public function getPartner($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->partnerTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllPartners(){
       return $this->partnerTable->findAll();
   }
   public function getAllActivePartners(){
       $q = $this->partnerTable->createQuery('p');
       $q->addWhere('p.status = 1');
       return $q->execute(array(),Doctrine_Core::HYDRATE_RECORD);
   }
   
    public function getPartnerForm(Partner_Model_Doctrine_Partner $partner = null) {
        $form = new Partner_Form_Partner();
        
        if(null != $partner) {
            $form->populate($partner->toArray());
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('name')->setValue($partner->Translation[$language]->name);
                    $i18nSubform->getElement('description')->setValue($partner->Translation[$language]->description);
                }
            }
        }   
        return $form;
    }
    
    public function savePartnerFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$partner = $this->partnerTable->getProxy($values['id'])) {
            $partner = $this->partnerTable->getRecord();
        }
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        if(strpos($values['website'], 'http://') !== 0) {
          $values['website'] = 'http://' . $values['website'];
        }
        
        $partner->fromArray($values);
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['name'])) {
                $partner->Translation[$language]->name = $values['translations'][$language]['name'];
                $partner->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Partner_Model_Doctrine_PartnerTranslation', $values['translations'][$language]['name'], $partner->getId());
                $partner->Translation[$language]->description = $values['translations'][$language]['description'];
            }
        }
        
        $partner->save();
        
        return $partner;
    }
    
    public function removePartner(Partner_Model_Doctrine_Partner $partner) {
        $partner->delete();
    }
    
    public function refreshStatusPartner($partner){
        if ($partner->isStatus()):
            $partner->setStatus(0);
        else:
            $partner->setStatus(1);
        endif;
        $partner->save();
    }
}

