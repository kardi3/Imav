<?php

/**
 * Blog_Model_Doctrine_BlogTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Blog_Model_Doctrine_BlogTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Blog_Model_Doctrine_BlogTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Blog_Model_Doctrine_Blog');
    }
    
    public function getPublishEntriesQuery() {
        $q = $this->createQuery('a')
                ->addSelect('a.*')
                ->addSelect('at.*')
                ->addSelect('m.*')
                ->leftJoin('a.Translation at')
                ->leftJoin('a.Metatags m')
                ->andWhere('(a.publish = ? AND (a.publish_date <= ? OR a.publish_date IS NULL))', array(1, date('Y-m-d H:i:s')))
                ;
        return $q;
    }

    public function getPhotoQuery(Doctrine_Query $q = null) {
        if(null == $q) {
            $q = $this->createQuery('a');
            $q->addSelect('a.*');
        }
        $q->addSelect('pr.*');
        $q->addSelect('p.*');
        $q->leftJoin('a.PhotoRoot pr');
        $q->leftJoin('a.Photos p');
        return $q;
    }
    
    public function getLimitQuery($limit, Doctrine_Query $q = null) {
        if(null == $q) {
            $q = $this->createQuery('a');
            $q->addSelect('a.*');
        }
        $q->limit($limit);
        return $q;
    }
}