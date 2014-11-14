<?php

/**
 * Censor_Form_Ip
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_Form_Ip extends Admin_Form {
    
    public function init() {
        
        $ip = $this->createElement('text', 'ip');
        $ip->setLabel('Ip');
        $ip->setDecorators(self::$textDecorators);
        $ip->setAttrib('class', 'span8');

        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $ip,
            $submit
        ));
		
    }
    
}

