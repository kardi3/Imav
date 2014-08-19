<?php

/**
 * Blog
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Blog_DataTables_Adapter_Blog extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('xt.*');
        $q->addSelect('ct.*');
        $q->leftJoin('x.Translation xt');
        return $q;
    }
}

