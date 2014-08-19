<?php

/**
 * Offer_Form_CategoryPrice
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Form_CategoryPrice extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));

        $categoryId = $this->createElement('hidden', 'category_id');
        $categoryId->setDecorators(array('ViewHelper'));
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id,
            $categoryId,
            $submit
        ));
    }
    
}

