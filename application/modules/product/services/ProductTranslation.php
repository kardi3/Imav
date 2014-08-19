<?php

/**
 * Product_Service_Category
 *
@author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_Service_ProductTranslation extends MF_Service_ServiceAbstract {
    
    protected $productTranslationTable;
    
    public function init() {
        $this->productTranslationTable = Doctrine_Core::getTable('Product_Model_Doctrine_ProductTranslation');
        parent::init();
    }
    
    public function getProductTranslation($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->productTranslationTable->findOneBy($field, $id, $hydrationMode);
    }
    
}
?>