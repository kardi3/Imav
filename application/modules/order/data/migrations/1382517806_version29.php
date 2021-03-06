<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version29 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('order_order', 'order_order_user_id_user_user_id');
    }

    public function down()
    {
        $this->createForeignKey('order_order', 'order_order_user_id_user_user_id', array(
             'name' => 'order_order_user_id_user_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'user_user',
             ));
    }
}