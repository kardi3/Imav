<?php

/**
 * Attachment_DataTables_Adapter_AttachmentSerwis5
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Attachment_DataTables_Adapter_AttachmentSerwis5 extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('a');
        $q->select('a.*');
        return $q;
    }
    
}

