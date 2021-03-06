<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('order_consignment_type', 'type');
        $this->removeColumn('order_payment_type', 'type');
        $this->addColumn('order_consignment_type', 'name', 'string', '255', array(
             ));
        $this->addColumn('order_payment_type', 'name', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->addColumn('order_consignment_type', 'type', 'string', '255', array(
             ));
        $this->addColumn('order_payment_type', 'type', 'string', '255', array(
             ));
        $this->removeColumn('order_consignment_type', 'name');
        $this->removeColumn('order_payment_type', 'name');
    }
}