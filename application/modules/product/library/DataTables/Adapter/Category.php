<?php

/**
 * Product_DataTables_Adapter_Category
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_DataTables_Adapter_Category extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('c');
        $q->leftJoin('c.Translation ct');
       
        return $q;
    }
    
}

