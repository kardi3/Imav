<?php

/**
 * Offer_Model_Doctrine_BaseCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property clob $description
 * @property integer $metatag_id
 * @property Doctrine_Collection $Prices
 * @property Offer_Model_Doctrine_OfferTemplate $OfferTemplate
 * @property Offer_Model_Doctrine_NoticeTemplate $NoticeTemplate
 * @property Doctrine_Collection $Offers
 * @property Doctrine_Collection $Notices
 * 
 * @package    Admi
 * @subpackage Offer
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Offer_Model_Doctrine_BaseCategory extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('offer_category');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('metatag_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Offer_Model_Doctrine_CategoryPrice as Prices', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasOne('Offer_Model_Doctrine_OfferTemplate as OfferTemplate', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasOne('Offer_Model_Doctrine_NoticeTemplate as NoticeTemplate', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('Offer_Model_Doctrine_Offer as Offers', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('Offer_Model_Doctrine_Notice as Notices', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $nestedset0 = new Doctrine_Template_NestedSet(array(
             'hasManyRoots' => false,
             ));
        $this->actAs($nestedset0);
    }
}