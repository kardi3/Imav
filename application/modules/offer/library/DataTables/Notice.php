<?php

/**
 * Offer_DataTables_Notice
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Notice extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Offer_DataTables_Adapter_Notice';
    }
}

