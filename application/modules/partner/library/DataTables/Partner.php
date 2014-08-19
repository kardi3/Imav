<?php

/**
 * Partner_DataTables_PartnerSerwis10
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Partner_DataTables_Partner extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Partner_DataTables_Adapter_Partner';
    }
}

