<?php

/**
 * Article_DataTables_Article
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Article_DataTables_Article extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Article_DataTables_Adapter_Article';
    }
}

