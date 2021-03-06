<?php

/**
 * Newsletter_Model_Doctrine_ProductSubscriber
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Admi
 * @subpackage Newsletter
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Newsletter_Model_Doctrine_ProductSubscriber extends Newsletter_Model_Doctrine_BaseProductSubscriber
{
    public function setSent($value = true){
        $this->_set('sent',$value);
    }
    
    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Product_Model_Doctrine_Product as Product', array(
             'local' => 'product_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}