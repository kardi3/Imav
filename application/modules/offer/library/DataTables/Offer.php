<?php

/**
 * Offer_DataTables_Offer
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Offer extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Offer_DataTables_Adapter_Offer';
    }
}

