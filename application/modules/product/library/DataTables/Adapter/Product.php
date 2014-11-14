<?php

/**
 * Product_DataTables_Adapter_Product
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_DataTables_Adapter_Product extends Default_DataTables_Adapter_AdapterAbstract {
    protected function getBaseQuery() {
        $q = $this->table->createQuery('p');
        $q->leftJoin('p.Translation pt');
        $q->leftJoin('p.Category c');
        $q->leftJoin('c.Translation ct');
        
        return $q;
    }
}

