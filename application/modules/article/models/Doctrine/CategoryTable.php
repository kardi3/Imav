<?php

/**
 * Article_Model_Doctrine_CategoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Article_Model_Doctrine_CategoryTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Article_Model_Doctrine_CategoryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Article_Model_Doctrine_Category');
    }
}