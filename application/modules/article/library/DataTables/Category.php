<?php

/**
 * Article_DataTables_Category
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Article_DataTables_Category extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Article_DataTables_Adapter_Category';
    }
}

