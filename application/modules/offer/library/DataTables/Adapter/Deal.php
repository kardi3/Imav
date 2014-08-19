<?php

/**
 * Offer_DataTables_Adapter_Deal
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Adapter_Deal extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->addSelect('x.*');
        $q->addSelect('n.*');
        $q->leftJoin('x.Notice n');
        $q->leftJoin('n.Category c');
        
        if($this->request->getParam('notice-id')) {
            $q->andWhere('x.notice_id = ?', (int) $this->request->getParam('notice-id'));
        }
        
        return $q;
    }
    
}

