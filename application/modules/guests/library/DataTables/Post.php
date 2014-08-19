<?php

/**
 * Post
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Guests_DataTables_Post extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Guests_DataTables_Adapter_Post';
    }
}

