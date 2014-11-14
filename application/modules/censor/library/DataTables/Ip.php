<?php

/**
 * Censor
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_DataTables_Ip extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Censor_DataTables_Adapter_Ip';
    }
}

