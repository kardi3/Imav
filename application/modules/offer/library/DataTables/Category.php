<?php

/**
 * Offer_DataTables_Category
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Category extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Offer_DataTables_Adapter_Category';
    }
}

