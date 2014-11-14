<?php

/**
 * Product_Service_Product
 *
@author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_Service_Product extends MF_Service_ServiceAbstract {
    
    protected $productTable;
    
    public function init() {
        $this->productTable = Doctrine_Core::getTable('Product_Model_Doctrine_Product');
        parent::init();
    }
    
     public function getLastProduct($limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->productTable->getProductQuery();
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getRelatedProduct($productId, $relateProductId) {    
        $q = $this->productRelatedTable->getRelatedProductQuery();
        $q->andWhere('rp.product_id = ?', $productId);
        $q->andWhere('rp.relate_product_id = ?', $relateProductId);
        return $q->fetchOne(array(), Doctrine_Core::HYDRATE_RECORD);
    }
    
    public function getLastCategoryProduct($category_id,$limit = null, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->productTable->getProductQuery();
        $q->addWhere('p.category_id = ?',$category_id);
        $q->orderBy('p.created_at DESC');
        if($limit!=null)
            $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
  
    
    public function getTargetProductSelectOptionsToRelate($productId, $prependEmptyValue = false, $language = null) {
        $q = $this->productTable->getProductQuery();
        $q->andWhere('pro.id != ?', $productId);
        $items = $q->execute(array(), Doctrine_Core::HYDRATE_RECORD);
//        $result = array();
        
        if($prependEmptyValue) {
            $result[''] = ' ';
        }
        
        foreach($items as $item) {
            if($item['dimensions'] && $item['DimensionPrices']->toArray()){
                foreach($item['DimensionPrices'] as $dimensionPrice){
                    $result['d'.$dimensionPrice['id']] = $item->Translation[$language]->name." (".$dimensionPrice['Dimension']['width']." cm x ".$dimensionPrice['Dimension']['height']." cm)";
                }
            }else{
                $result[$item->getId()] = $item->Translation[$language]->name;
            }
        }
        
        return $result;
    }
    
    public function getProduct($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {    
        return $this->productTable->findOneBy($field, $id, $hydrationMode);
    }
    
    
    public function getFullProduct($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->productTable->getProductQuery();
        
//        $q->andWhere('pro.' . $field . ' = ?', $id);
        $q->andWhere('pt.' .$field.' = ?', $id);
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getCategoryProducts($category_id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->productTable->getProductQuery();
        $q->addWhere('cat.id = ?',$category_id);
        $q->addWhere('pro.active = 1');
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getShortProduct($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->productTable->getProductQuery();
        
        $q->andWhere('pro.' . $field . ' = ?', $id);

        return $q->fetchOne(array(), $hydrationMode);
    }
    public function getProductCategory()
    {
        $q = $this->productTable->getProductQuery();
        
      //  $q->andWhere('pro.' . $field . ' = ?', $id);
        $q->andWhere('tr.' .$field.' = ?', $id);
        return $q->fetchOne(array(), $hydrationMode);
    }
    public function getProductForm(Product_Model_Doctrine_Product $product = null) {
        $form = new Product_Form_Product();
        if(null != $product) {
            
            $productArray = $product->toArray();
            
            $form->populate($productArray);
                 
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('name')->setValue($product->Translation[$language]->name);
                    $i18nSubform->getElement('description')->setValue($product->Translation[$language]->description);
                }
            }
            
        }
        return $form;
    }
    
    public function saveProductFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }

        if(!$product = $this->productTable->getProxy($values['id'])) {
            $product = $this->productTable->getRecord();
        }
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');

        $product->fromArray($values);
        
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['name'])) {
                $product->Translation[$language]->name = $values['translations'][$language]['name'];
                $product->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Product_Model_Doctrine_ProductTranslation', $values['translations'][$language]['name'], $product->getId());
                $product->Translation[$language]->description = $values['translations'][$language]['description'];
            }
        }
                
        $product->unlink('Categories');
        foreach($values['category_id'] as $category):
            $product->link('Categories',$category);
        endforeach;
        
        $product->save();
        
        return $product;
    }   
    
    public function refreshStatusProduct($product){
        if ($product->isStatus()):
            $product->setStatus(0);
        else:
            $product->setStatus(1);
        endif;
        $product->save();
    }
    
    public function refreshPromotionProduct($product){
        if ($product->isPromoted()):
            $product->setPromoted(0);
        else:
            $product->setPromoted(1);
        endif;
        $product->save();
    }
    
    public function removeProduct(Product_Model_Doctrine_Product $product) {
        $product->unlink('Category');
        $product->get('Translation')->delete();
        $product->save();
        $product->delete();
    }
    
    public function getAllProducts($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->productTable->getProductQuery();
        return $q->execute(array(), $hydrationMode);
    }
  
    public function getTargetProductSelectOptions($prependEmptyValue = false, $language = null) {
        $items = $this->getAllProducts();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = ' ';
        }

        foreach($items as $item) {
            if($item['DimensionPrices']->toArray()){
                foreach($item['DimensionPrices'] as $dimensionPrice){
                    $w = $dimensionPrice['Dimension']['width'];
                    $h = $dimensionPrice['Dimension']['height'];
                    $result['d'.$dimensionPrice->getId()] = $item->Translation[$language]->name.' ('.$w.'cm x '.$h.'cm)';
                }
            }else{
                $result[$item->getId()] = $item->Translation[$language]->name;
            }
        }
        
        return $result;
    }
    
    
    public function getAllProductsForCount($countOnly = false) {
        if(true == $countOnly) {
            return $this->productTable->count();
        } else {
            return $this->productTable->findAll();
        }
    }
    
    public function getProductForCategory($categoryId) {
        $q = $this->productTable->getProductQuery();
        $q->andWhere('cat.id = ?', $categoryId);
        $q->addOrderBy('rand()');
        return $q;
    }
    
    
    
    
     
    public function getPreSortedProductPaginationQuery($productIds) {
        $q = $this->productTable->getProductQuery();
        $q->where('pro.id IN ?', array($productIds));
        if(is_array($productIds)):
            $q->addOrderBy('FIELD(pro.id, '.implode(', ', $productIds).')');
        endif; 
        return $q;  
    }
    
    public function getPreSortedProducerProductPaginationQuery($productIds) {
        $q = $this->productTable->getProductQuery();
        $q->where('pro.id IN ?', array($productIds));
        if(is_array($productIds)):
            $q->addOrderBy('FIELD(pro.id, '.implode(', ', $productIds).')');
        endif; 
        return $q;  
    }
    
    
    
    public function getPromotionProducts($language='pl'){
        $q = $this->productTable->getProductQuery();
        $q->andWhere('tr.lang = ?', $language);
        $q->addWhere('pro.active = 1');
        $q->andWhere('pro.promotion = 1');
        $products = $q->execute(array(), Doctrine_Core::HYDRATE_RECORD);
        return $products; 
    }
}
?>