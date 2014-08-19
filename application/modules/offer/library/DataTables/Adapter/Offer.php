<?php

/**
 * Offer_DataTables_Adapter_Offer
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Adapter_Offer extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        
        return $q;
    }
    
}

