<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version3 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('offer_parameter');
        $this->addColumn('offer_offer', 'drift', 'boolean', '25', array(
             'default' => '0',
             ));
    }

    public function down()
    {
        $this->createTable('offer_parameter', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'parameter_template_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'value' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'value_to' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'required' => 
             array(
              'type' => 'boolean',
              'default' => '1',
              'length' => '25',
             ),
             'root_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'lft' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'rgt' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'level' => 
             array(
              'type' => 'integer',
              'length' => '2',
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
        $this->removeColumn('offer_offer', 'drift');
    }
}