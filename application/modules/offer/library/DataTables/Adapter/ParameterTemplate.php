<?php

/**
 * Offer_DataTables_Adapter_ParameterTemplpate
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Adapter_ParameterTemplate extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->orderBy('x.name ASC');
        
        return $q;
    }
}

