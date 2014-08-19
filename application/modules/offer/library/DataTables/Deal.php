<?php

/**
 * Offer_DataTables_Deal
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Deal extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Offer_DataTables_Adapter_Deal';
    }
}

