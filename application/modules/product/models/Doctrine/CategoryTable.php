<?php

/**
 * Product_Model_Doctrine_CategoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Product_Model_Doctrine_CategoryTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Product_Model_Doctrine_CategoryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Product_Model_Doctrine_Category');
    }
    
    
    public function getCategoryQuery() {
        $q = $this->createQuery('cat');
        $q->addSelect('cat.*');
        $q->addSelect('tr.*');
        $q->leftJoin('cat.Translation tr');
        return $q;
    }
    
    public function getMainCategoriesQuery() {
        $q = $this->createQuery('cat');
        $q->addSelect('cat.*');
        $q->addSelect('ct.*');
        $q->leftJoin('cat.Translation ct');
        $q->andWhere('cat.level = ?', 1);
        return $q;
    }
}