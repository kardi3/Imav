<?php

/**
 * Offer_Form_NoticeSearch
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Form_NoticeSearch extends User_BootstrapForm {
    
    public function init() {
        $term = $this->createElement('text', 'term');
        $term->setLabel('Term');
        $term->setDecorators(self::$bootstrapElementDecorators);
        
        $provinceId = $this->createElement('hidden', 'province_id');
        $provinceId->setDecorators(array('ViewHelper'));
        
        $cityId = $this->createElement('hidden', 'city_id');
        $cityId->setDecorators(array('ViewHelper'));
        
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Search');
        $submit->setDecorators(self::$bootstrapSubmitDecorators);
        
        $this->setElements(array(
            $term,
            $provinceId,
            $cityId,
            $submit
        ));
    }
}

