<?php

/**
 * Offer_DataTables_Adapter_Notice
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Adapter_Notice extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->addSelect('x.*');
        $q->addSelect('c.*');
        $q->addSelect('d.*, COUNT(DISTINCT d.id) as deal_count');
        $q->addSelect('dm.*, COUNT(DISTINCT dm.id) as deal_message_count');
        $q->leftJoin('x.Category c');
        $q->leftJoin('x.Deals d');
        $q->leftJoin('d.Messages dm');
        
        if($this->request->getParam('user-id')) {
            $q->andWhere('x.user_id = ?', (int) $this->request->getParam('user-id'));
        }
        
        return $q;
    }
    
}

