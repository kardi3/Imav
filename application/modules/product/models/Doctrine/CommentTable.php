<?php

/**
 * Product_Model_Doctrine_CommentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Product_Model_Doctrine_CommentTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Product_Model_Doctrine_CommentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Product_Model_Doctrine_Comment');
    }
    
    public function getCommentQuery() {
        $q = $this->createQuery('co');
        $q->addSelect('co.*');
        return $q;
    }
}