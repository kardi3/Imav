<?php

/**
 * Slider_DataTables_Adapter_Slide
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Slider_DataTables_Adapter_Slide extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->addSelect('x.*');
        if($this->request->getParam('slider')) {
            $q->andWhere('x.slider_id = ?', $this->request->getParam('slider'));
        }
        return $q;
    }
}
