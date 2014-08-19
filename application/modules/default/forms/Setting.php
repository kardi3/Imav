<?php

/**
 * Setting
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Default_Form_Setting extends Admin_Form {
    
    public function init() {
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttrib('type', 'submit');
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $submit
        ));
    }
}

