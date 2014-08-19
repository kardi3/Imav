<?php

/**
 * Offer_DataTables_Adapter_Category
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_DataTables_Adapter_Category extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->addOrderBy('x.lft ASC');
        
        if($id = $this->request->getParam('id')) {
            if($parent = $this->table->findOneBy('id', $id)) {
                $q->andWhere('x.lft > ? AND x.rgt < ?', array($parent['lft'], $parent['rgt']));
            }
        }
        
        return $q;
    }
    
}

