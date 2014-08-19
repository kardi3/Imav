<?php

/**
 * Article
 *
 * @author Andrzej Wilczyński <michalfolga@gmail.com>
 */
class Article_DataTables_Adapter_Category extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('xt.*');
        $q->addSelect('COUNT(a.id) as count');
        $q->leftJoin('x.Translation xt');
        $q->leftJoin('x.Articles a');
        $q->where('xt.lang = ?', $this->request->getParam('lang'));
        $q->groupBy('x.id');
        return $q;
    }
}

