<?php

/**
 * Product_DataTables_Dimension
 *
 * @author Michał Kowalik
 */
class Product_DataTables_Dimension extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Product_DataTables_Adapter_Dimension';
    }
}

