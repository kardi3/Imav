<?php

/**
 * Product_DataTables_Adapter_Product
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_DataTables_Adapter_Product extends Default_DataTables_Adapter_AdapterAbstract {
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Translation t');
        $q->leftJoin('x.Producer p');
        $q->leftJoin('x.Categories cat');
        $q->leftJoin('cat.Translation ct');
        $q->leftJoin('p.Translation pt');
        $q->leftJoin('x.PhotoRoot pr');
        
        return $q;
    }
}

