<?php

/**
 * Product_Model_Doctrine_Product
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Admi
 * @subpackage Product
 * @author     Andrzej Wilczyński <and.wilczynski@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Product_Model_Doctrine_Product extends Product_Model_Doctrine_BaseProduct
{
    public static $productPhotoDimensions = array(
        '126x126' => 'Photo in admin panel',                  // admin
        '610x292' => 'Big photo(610x292)',
        '67x45' => 'Miniature photo(67x45)',
        '256x122' => 'Small photo(256x122)',
        '130x130' => 'Photo in gallery(130x130)',
        '400x' => 'Backup photo(400x)',
    );

    public static $productMainPhotoDimensions = array(
        '126x126' => 'Photo in admin panel',                  // admin
        '610x292' => 'Big photo(610x292)',
        '67x45' => 'Miniature photo(67x45)',
        '256x122' => 'Small photo(256x122)',
        '130x130' => 'Photo in gallery(130x130)',
        '400x' => 'Backup photo(400x)',
    );
    
    public function getId() {
        return $this->_get('id');
    }
    
    public function getPrice() {
        return $this->_get('price');
    }
    
    public function getCode() {
        return $this->_get('code');
    }
    
    public function getAvailability() {
        return $this->_get('availability');
    }
    public function setAvailability($value) {
        return $this->_set('availability',$value);
    }
    public function getPurchasedNumber() {
        return $this->_get('purchased_number');
    }
    public function setPurchasedNumber($value) {
        return $this->_set('purchased_number',$value);
    }
    
    public static function getProductPhotoDimensions() {
        return self::$productPhotoDimensions;
    } 
    
    public static function getProductMainPhotoDimensions() {
        return self::$productMainPhotoDimensions;
    } 
    
    public function isStatus() {
        return $this->_get('status');
    }
    
    public function setStatus($status = true) {
        $this->_set('status', $status);
    }
    
    public function setPhotoRoot($id) {
        $this->_set('photo_root_id', $id);
    }
    
    public function getNew() {
        return $this->_get('new');
    }
    
    public function setNew($new = true) {
        $this->_set('new', $new);
    }
    public function setNewsletterSend($value = true) {
        $this->_set('newsletter_send', $value);
    }
    
    public function getPromoted() {
        return $this->_get('promoted');
    }
    
    public function setPromoted($promoted = true) {
        $this->_set('promoted', $promoted);
    }
    
    public function getPromotion() {
        return $this->_get('promotion');
    }
    
    public function setPromotion($promotion = true) {
        $this->_set('promotion', $promotion);
    }
    
     public function getActive() {
        return $this->_get('active');
    }
    
    public function setActive($value = true) {
        $this->_set('active', $value);
    }
    
     public function getSold() {
        return $this->_get('sold');
    }
    
    public function setSold($value = true) {
        $this->_set('sold', $value);
    }
    
     public function getFacebook() {
        return $this->_get('facebook');
    }
    
    public function setFacebook($value = true) {
        $this->_set('facebook', $value);
    }
    
    public function getSlider() {
        return $this->_get('slider');
    }
    
    public function setSlider($slider = true) {
        $this->_set('slider', $slider);
    }
    
    public function getMetatagId() {
        return $this->_get('metatag_id');    
    }
    
    public function setMetatagId($value) {
        return $this->_set('metatag_id',$value);    
    }
    
    public function setDiscountId($discountId) {
        $this->_set('discount_id', $discountId);
    }
    
    public function setUp() {
        $this->hasOne('Media_Model_Doctrine_Photo as PhotoRoot', array(
            'local' => 'photo_root_id',
            'foreign' => 'id'
        ));
        
        $this->hasOne('Media_Model_Doctrine_VideoUrl as VideoRoot', array(
            'local' => 'video_root_id',
            'foreign' => 'id'
        ));
        
        $this->hasMany('Media_Model_Doctrine_Photo as Photos', array(
            'local' => 'photo_root_id',
            'foreign' => 'root_id'
        ));
        
        $this->hasOne('Default_Model_Doctrine_Metatag as Metatags', array(
            'local' => 'metatag_id',
            'foregin' => 'id'
        ));
        
        parent::setUp();
    }
    
     
}