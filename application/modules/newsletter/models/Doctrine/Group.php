<?php

/**
 * Newsletter_Model_Doctrine_Group
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Admi
 * @subpackage Newsletter
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Newsletter_Model_Doctrine_Group extends Newsletter_Model_Doctrine_BaseGroup
{
    public function getId(){
        return $this->_get('id');
    }
    
    public function getVisible(){
        return $this->_get('visible');
    }
    
    public function setVisible($value){
        return $this->_set('visible',$value);
    }
}