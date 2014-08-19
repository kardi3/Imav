<?php

/**
 * Offer_Form_Offer
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Form_Offer extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));

        $category = $this->createElement('select', 'category');
        $category->setLabel('Category');
        $category->setDecorators(self::$selectDecorators);
        $category->setAttrib('class', 'span8');
        $category->setRequired(true);
        
        $title = $this->createElement('text', 'title');
        $title->setLabel('Title');
        $title->setDecorators(self::$textDecorators);
        $title->setAttrib('class', 'span8');
        $title->setRequired(true);
        
        $content = $this->createElement('textarea', 'content');
        $content->setLabel('Content');
        $content->setDecorators(array('ViewHelper'));
        $content->setAttrib('rows', 6);
        $content->setRequired(true);
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id,
            $category,
            $title,
            $content,
            $submit
        ));
    }
    
}

