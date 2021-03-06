<?php

/**
 * Banner_Model_Doctrine_BaseAd
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property clob $content
 * @property boolean $publish
 * @property integer $metatag_id
 * @property integer $video_root_id
 * @property timestamp $date_from
 * @property timestamp $date_to
 * @property string $target_href
 * @property boolean $allow_skip
 * @property Doctrine_Collection $Translation
 * 
 * @package    Admi
 * @subpackage Banner
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Banner_Model_Doctrine_BaseAd extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('banner_ad');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('content', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('publish', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             ));
        $this->hasColumn('metatag_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('video_root_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('date_from', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('date_to', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('target_href', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('allow_skip', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Banner_Model_Doctrine_AdTranslation as Translation', array(
             'local' => 'id',
             'foreign' => 'id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'title',
              1 => 'slug',
              2 => 'content',
             ),
             'tableName' => 'banner_ad_translation',
             'className' => 'AdTranslation',
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($i18n0);
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}