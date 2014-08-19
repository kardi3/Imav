<?php

/**
 * Offer_DataTables_ParameterTemplpate
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_ParameterTemplate extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Offer_DataTables_Adapter_ParameterTemplate';
    }
}

