<?php

/**
 * Blog_Model_Doctrine_BaseBlogTranslation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $lang
 * @property string $slug
 * @property string $title
 * @property clob $content
 * @property Blog_Model_Doctrine_Blog $Blog
 * 
 * @package    Admi
 * @subpackage Blog
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Blog_Model_Doctrine_BaseBlogTranslation extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('blog_blog_translation');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('lang', 'string', 64, array(
             'primary' => true,
             'type' => 'string',
             'length' => '64',
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('content', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Blog_Model_Doctrine_Blog as Blog', array(
             'local' => 'id',
             'foreign' => 'id'));
    }
}