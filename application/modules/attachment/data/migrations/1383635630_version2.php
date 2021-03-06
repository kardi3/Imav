<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('attachment_serwis1_attachment', 'attachment_serwis1_attachment_photo_root_id_media_photo_id');
        $this->dropForeignKey('attachment_serwis5_attachment', 'attachment_serwis5_attachment_photo_root_id_media_photo_id');
        $this->dropForeignKey('attachment_serwis6_attachment', 'attachment_serwis6_attachment_photo_root_id_media_photo_id');
        $this->dropForeignKey('attachment_serwis7_attachment', 'attachment_serwis7_attachment_photo_root_id_media_photo_id');
        $this->createForeignKey('attachment_serwis8_attachment_translation', 'aiai_13', array(
             'name' => 'aiai_13',
             'local' => 'id',
             'foreign' => 'id',
             'foreignTable' => 'attachment_serwis8_attachment',
             ));
        $this->createForeignKey('attachment_serwis8_attachment_translation', 'aiai_14', array(
             'name' => 'aiai_14',
             'local' => 'id',
             'foreign' => 'id',
             'foreignTable' => 'attachment_serwis8_attachment',
             'onUpdate' => 'CASCADE',
             'onDelete' => 'CASCADE',
             ));
        $this->addIndex('attachment_serwis8_attachment_translation', 'attachment_serwis8_attachment_translation_id', array(
             'fields' => 
             array(
              0 => 'id',
             ),
             ));
    }

    public function down()
    {
        $this->createForeignKey('attachment_serwis1_attachment', 'attachment_serwis1_attachment_photo_root_id_media_photo_id', array(
             'name' => 'attachment_serwis1_attachment_photo_root_id_media_photo_id',
             'local' => 'photo_root_id',
             'foreign' => 'id',
             'foreignTable' => 'media_photo',
             ));
        $this->createForeignKey('attachment_serwis5_attachment', 'attachment_serwis5_attachment_photo_root_id_media_photo_id', array(
             'name' => 'attachment_serwis5_attachment_photo_root_id_media_photo_id',
             'local' => 'photo_root_id',
             'foreign' => 'id',
             'foreignTable' => 'media_photo',
             ));
        $this->createForeignKey('attachment_serwis6_attachment', 'attachment_serwis6_attachment_photo_root_id_media_photo_id', array(
             'name' => 'attachment_serwis6_attachment_photo_root_id_media_photo_id',
             'local' => 'photo_root_id',
             'foreign' => 'id',
             'foreignTable' => 'media_photo',
             ));
        $this->createForeignKey('attachment_serwis7_attachment', 'attachment_serwis7_attachment_photo_root_id_media_photo_id', array(
             'name' => 'attachment_serwis7_attachment_photo_root_id_media_photo_id',
             'local' => 'photo_root_id',
             'foreign' => 'id',
             'foreignTable' => 'media_photo',
             ));
        $this->dropForeignKey('attachment_serwis8_attachment_translation', 'aiai_13');
        $this->dropForeignKey('attachment_serwis8_attachment_translation', 'aiai_14');
        $this->removeIndex('attachment_serwis8_attachment_translation', 'attachment_serwis8_attachment_translation_id', array(
             'fields' => 
             array(
              0 => 'id',
             ),
             ));
    }
}