<?php

/**
 * Guests_Form_Post
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Guests_Form_Post extends Admin_Form {
    
    public function init() {
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $publish = $this->createElement('hidden', 'publish');
        $publish->setDecorators(array('ViewHelper'));
        
        $name = $this->createElement('text', 'name');
        $name->setRequired(true);
        $name->setDecorators(array('ViewHelper', 'Errors'));
        
        $city = $this->createElement('text', 'city');
        $city->setRequired(true);
        $city->setDecorators(array('ViewHelper', 'Errors'));
        
        $message = $this->createElement('textarea', 'message');
        $message->setRequired(true);
        $message->addValidators(array(
            array('StringLength', true, array('min' => 50))
        ));
        $message->setDecorators(array('ViewHelper', 'Errors'));
        $message->setAttrib('rows', 10);
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('DODAJ');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('type' => 'submit'));

        $this->setElements(array(
            $id,
            $publish,
            $name,
            $city,
            $message,
            $submit
        ));
    }
}

