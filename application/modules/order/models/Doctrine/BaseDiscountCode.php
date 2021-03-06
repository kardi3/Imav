<?php

/**
 * Order_Model_Doctrine_BaseDiscountCode
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $code
 * @property decimal $discount
 * @property boolean $active
 * 
 * @package    Admi
 * @subpackage Order
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Order_Model_Doctrine_BaseDiscountCode extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('order_discount_code');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('code', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('discount', 'decimal', 4, array(
             'type' => 'decimal',
             'length' => '4',
             'scale' => '2',
             ));
        $this->hasColumn('active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}