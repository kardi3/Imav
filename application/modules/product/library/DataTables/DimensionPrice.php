<?php

/**
 * Product_DataTables_DimensionPrice
 *
 * @author Michał Kowalik
 */
class Product_DataTables_DimensionPrice extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Product_DataTables_Adapter_DimensionPrice';
    }
}

