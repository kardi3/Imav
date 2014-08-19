<?php

/**
 * Newsletter_DataTables_Adapter_Subscriber
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Newsletter_DataTables_Adapter_Subscriber extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('c.*');
        $q->leftJoin('x.Categories c');
        return $q;
    }
}

