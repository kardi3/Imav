<?php

/**
 * Product_Service_Category
 *
@author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_Service_ProductCategory extends MF_Service_ServiceAbstract {
    
    protected $productCategoryTable;
    
    public function init() {
        $this->productCategoryTable = Doctrine_Core::getTable('Product_Model_Doctrine_ProductCategory');
        parent::init();
    }
    
    public function getProductCategory($id, $field = 'product_id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->productCategoryTable->findOneBy($field, $id, $hydrationMode);
    }
    
}
?>