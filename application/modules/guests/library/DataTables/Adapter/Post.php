<?php

/**
 * Post
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Guests_DataTables_Adapter_Post extends Default_DataTables_Adapter_AdapterAbstract {
   
       public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        return $q;
    }
}

