<?php

/**
 * Order_DataTables_Adapter_OrderStatus
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Order_DataTables_Adapter_DiscountCode extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('dc');
        $q->select('dc.*');
        return $q;
    }
}

