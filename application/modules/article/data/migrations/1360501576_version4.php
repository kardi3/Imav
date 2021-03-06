<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version4 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('article_article', 'article_article_user_id_user_user_id');
        $this->dropForeignKey('article_article', 'article_article_category_id_offer_category_id');
        $this->dropForeignKey('article_article', 'article_article_metatag_id_default_metatag_id');
        $this->dropForeignKey('article_article', 'article_article_photo_root_id_media_photo_id');
        $this->addIndex('article_article', 'article_article_sluggable', array(
             'fields' => 
             array(
              0 => 'slug',
             ),
             'type' => 'unique',
             ));
    }

    public function down()
    {
        $this->createForeignKey('article_article', 'article_article_user_id_user_user_id', array(
             'name' => 'article_article_user_id_user_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'user_user',
             ));
        $this->createForeignKey('article_article', 'article_article_category_id_offer_category_id', array(
             'name' => 'article_article_category_id_offer_category_id',
             'local' => 'category_id',
             'foreign' => 'id',
             'foreignTable' => 'offer_category',
             ));
        $this->createForeignKey('article_article', 'article_article_metatag_id_default_metatag_id', array(
             'name' => 'article_article_metatag_id_default_metatag_id',
             'local' => 'metatag_id',
             'foreign' => 'id',
             'foreignTable' => 'default_metatag',
             ));
        $this->createForeignKey('article_article', 'article_article_photo_root_id_media_photo_id', array(
             'name' => 'article_article_photo_root_id_media_photo_id',
             'local' => 'photo_root_id',
             'foreign' => 'id',
             'foreignTable' => 'media_photo',
             ));
        $this->removeIndex('article_article', 'article_article_sluggable', array(
             'fields' => 
             array(
              0 => 'slug',
             ),
             'type' => 'unique',
             ));
    }
}