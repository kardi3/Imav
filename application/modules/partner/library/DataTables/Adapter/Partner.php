<?php

/**
 * Partner_DataTables_Adapter_PartnerSerwis10
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Partner_DataTables_Adapter_Partner extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('p');
        $q->select('p.*');
        $q->addSelect('pt.*');
        $q->leftJoin('p.Translation pt');
        return $q;
    }
}

