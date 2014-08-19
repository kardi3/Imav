<?php

/**
 * Blog
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Blog_DataTables_Blog extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Blog_DataTables_Adapter_Blog';
    }
}

