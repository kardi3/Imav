<?php

/**
 * Guests_Form_EditPost
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Guests_Form_EditPost extends Admin_Form {
    
    public function init() {
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $publish = $this->createElement('checkbox', 'publish');
        $publish->setLabel('Publish');
        $publish->setDecorators(self::$checkgroupDecorators);
        $publish->setAttrib('class', 'span8');
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Name of author');
        $name->setRequired(true);
        $name->setDecorators(self::$textDecorators);
        $name->setAttrib('class', 'span8');
        
        $city = $this->createElement('text', 'city');
        $city->setLabel('City');
        $city->setRequired(true);
        $city->setDecorators(self::$textDecorators);
        $city->setAttrib('class', 'span8');
        
        $message = $this->createElement('textarea', 'message');
        $message->setLabel('Content of message');
        $message->setRequired(true);
        $message->setDecorators(self::$tinymceDecorators);
        $message->setAttrib('class', 'span8 tinymce');
            
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttrib('type', 'submit');
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

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

