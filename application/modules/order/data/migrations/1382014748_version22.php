<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version22 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('order_item');
        $this->addColumn('order_discount_code', 'test', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->createTable('order_item', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'name' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'product_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'price' => 
             array(
              'type' => 'integer',
              'length' => '5',
             ),
             'discount_amount' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'number' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'deleted_at' => 
             array(
              'notnull' => '',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'MyISAM',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->removeColumn('order_discount_code', 'test');
    }
}