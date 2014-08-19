<?php

/**
 * Offer_Form_Category
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Form_Category extends Admin_Form {
    
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
        $description->setAttrib('class', 'tinymce uniform');
        
        $offerParameters = $this->createElement('select', 'offer_parameters');
        $offerParameters->setLabel('Offer parameters');
        $offerParameters->setDecorators(self::$selectDecorators);
        
        $noticeParameters = $this->createElement('select', 'notice_parameters');
        $noticeParameters->setLabel('Notice parameters');
        $noticeParameters->setDecorators(self::$selectDecorators);
        
        $parentId = $this->createElement('hidden', 'parent_id');
        $parentId->setDecorators(self::$hiddenDecorators);
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
//        $submit->setDescription('Reset');
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id,
            $name,
            $description,
            $offerParameters,
            $noticeParameters,
            $parentId,
            $submit
        ));
    }
    
}

