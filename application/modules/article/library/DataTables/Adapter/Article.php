<?php

/**
 * Article_DataTables_Adapter_Article
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Article_DataTables_Adapter_Article extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('u.*');
        $q->addSelect('c.*');
        $q->leftJoin('x.User u');
        $q->leftJoin('x.Category c');
        return $q;
    }
}

