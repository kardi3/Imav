<?php

/**
 * Gallery
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Gallery_DataTables_Adapter_Gallery extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->addSelect('x.*');
        $q->addSelect('t.*');
        $q->addSelect('c.*');
        $q->leftJoin('x.Translation t');
        $q->leftJoin('x.Category c');
        if($this->request->getParam('lang')) {
            $q->andWhere('t.lang = ?', $this->request->getParam('lang'));
        }
        return $q;
    }
}
