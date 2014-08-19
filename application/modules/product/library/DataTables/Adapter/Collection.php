<?php

/**
 * Product_DataTables_Adapter_Collection
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_DataTables_Adapter_Collection extends Default_DataTables_Adapter_AdapterAbstract {
    
    protected function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Translation t');
        $q->addOrderBy('x.lft ASC');
        
        if($id = $this->request->getParam('id')) {
            if($parent = $this->table->findOneBy('id', $id)) {
                $q->andWhere('x.lft > ? AND x.rgt < ? AND x.level = ?', array($parent['lft'], $parent['rgt'], $parent['level']+1));
            }
        }
        return $q;
    }
    
}

