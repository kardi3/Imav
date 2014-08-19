<?php

/**
 * Offer_Form_DealMessage
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Form_DealMessage extends Zend_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $subject = $this->createElement('text', 'subject');
        $subject->setLabel('Subject');

        $content = $this->createElement('textarea', 'content');
        $content->setLabel('Content');
        
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Send');
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id,
            $subject,
            $content,
            $submit
        ));
    }
}

