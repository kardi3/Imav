<?php

/**
 * Product_DataTables_Adapter_Producer
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_DataTables_Adapter_Producer extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Translation t');
        return $q;
    }
}

