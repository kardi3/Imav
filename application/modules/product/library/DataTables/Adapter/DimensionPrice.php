<?php

/**
 * Product_DataTables_Adapter_DimensionPrice
 *
 * @author Michał Kowalik
 */
class Product_DataTables_Adapter_DimensionPrice extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        return $q;
    }
    
}
