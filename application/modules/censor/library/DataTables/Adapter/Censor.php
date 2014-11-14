<?php

/**
 * Censor
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_DataTables_Adapter_Censor extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->addSelect('x.*');
        $q->addSelect('t.*');
        $q->leftJoin('x.Translation t');
        return $q;
    }
}
