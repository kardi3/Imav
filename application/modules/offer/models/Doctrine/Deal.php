<?php

/**
 * Offer_Model_Doctrine_Deal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Admi
 * @subpackage Offer
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Offer_Model_Doctrine_Deal extends Offer_Model_Doctrine_BaseDeal
{
    public function setId($id) {
        $this->_set('id', $id);
    }
    
    public function getId() {
        return $this->_get('id');
    }
    
    public function setOfferId($offerId) {
        $this->_set('offer_id', $offerId);
    }
    
    public function getOfferId() {
        return $this->_get('offer_id');
    }
    
    public function setNoticeId($noticeId) {
        $this->_set('notice_id', $noticeId);
    }
    
    public function getNoticeId() {
        return $this->_get('notice_id');
    }
    
    public function setContactRevealed($contactRevealed) {
        $this->_set('contact_revealed', $contactRevealed);
    }
    
    public function isContactRevealed() {
        return $this->_get('contact_revealed');
    }
    
    public function setStatus($status) {
        $this->_set('status', $status);
    }
    
    public function getStatus() {
        return $this->_get('status');
    }
}