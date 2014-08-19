<?php

/**
 * Product_Service_Category
 *
@author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_Service_CategoryTranslation extends MF_Service_ServiceAbstract {
    
    protected $productTranslationTable;
    
    public function init() {
        $this->productTranslationTable = Doctrine_Core::getTable('Product_Model_Doctrine_CategoryTranslation');
        parent::init();
    }
    
    public function getCategoryTranslation($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->productTranslationTable->findOneBy($field, $id, $hydrationMode);
    }
    public function getCategoryByName($id, $field = 'lang', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        return $this->productTranslationTable->findOneBy($field, $id, $hydrationMode);
    }
    public function removeNullCategory()
    {
        if($category = $this->getCategoryByName(''))
        $category->delete();
    }
    
}
?>