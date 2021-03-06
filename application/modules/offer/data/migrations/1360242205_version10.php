<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version10 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('offer_category', 'offer_category_metatag_id_default_metatag_id');
        $this->dropForeignKey('offer_notice', 'offer_notice_user_id_user_user_id');
        $this->dropForeignKey('offer_offer', 'offer_offer_user_id_user_user_id');
    }

    public function down()
    {
        $this->createForeignKey('offer_category', 'offer_category_metatag_id_default_metatag_id', array(
             'name' => 'offer_category_metatag_id_default_metatag_id',
             'local' => 'metatag_id',
             'foreign' => 'id',
             'foreignTable' => 'default_metatag',
             ));
        $this->createForeignKey('offer_notice', 'offer_notice_user_id_user_user_id', array(
             'name' => 'offer_notice_user_id_user_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'user_user',
             ));
        $this->createForeignKey('offer_offer', 'offer_offer_user_id_user_user_id', array(
             'name' => 'offer_offer_user_id_user_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'user_user',
             ));
    }
}