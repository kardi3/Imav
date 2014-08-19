<?php

/**
 * Offer_Form_ParameterTemplate
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Form_ParameterTemplate extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Name');
        $name->setDecorators(self::$textDecorators);
        $name->setAttrib('class', 'span8');
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description');
        $description->setDecorators(self::$textareaDecorators);
        $description->setAttrib('class', 'span8');
        $description->setAttrib('rows', 3);
        
        $unit = $this->createElement('select', 'unit');
        $unit->setLabel('Unit');
        $unit->setDecorators(self::$selectDecorators);

        $range = $this->createElement('checkbox', 'range');
        $range->setLabel('Range');
        $range->setDecorators(self::$checkgroupDecorators);
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id, 
            $name,
            $description,
            $unit,
            $range,
            $submit
        ));
    }
}

