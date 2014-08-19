<?php

/**
 * Product_Service_Dimension
 *
@author Michał Kowalik
 */
class Product_Service_DimensionPrice extends MF_Service_ServiceAbstract {
    
    protected $dimensionPriceTable;
    
    public function init() {
        $this->dimensionPriceTable = Doctrine_Core::getTable('Product_Model_Doctrine_DimensionPrice');
        parent::init();
    }
    public function getDimensionPrice($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        return $this->dimensionPriceTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getFullDimension($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->dimensionTable->getDimensionQuery();
        $q->andWhere('tr.' . $field . ' = ?', $id);
        return $q->fetchOne(array(), $hydrationMode);
    }
    public function getDimensionPriceProdDim($product,$dimension) { 
        $q = $this->dimensionPriceTable->getDimensionPriceQuery();
        $q->andWhere('p.product_id = ?', $product);
        $q->andWhere('p.dimension_id = ?', $dimension);
        return $q->fetchOne(array(), Doctrine_Core::HYDRATE_RECORD);
    }
    
    public function getDimensionForm() {
        return new Product_Form_Dimension();
        
    }
    
     public function getPopularProducts($language) {    
        $q = $this->dimensionPriceTable->getDimensionPriceQuery();
        //$q->where('tr.lang = ?', $language);
       // $q->andWhere('p.promoted = 1');
        $q->orderBy('p.most_frequently_purchased DESC');
        $q->limit(3);
        
        return $q->execute(array(), Doctrine_Core::HYDRATE_RECORD);
    }
    public function getDimensionRoot() {
        return $this->getDimensionTree()->fetchRoot();
    }
    
    public function getDimensionTree() {
        return $this->dimensionTable->getTree();
    }
    public function getDimensionPromotions($limit, $language){
        $q = $this->dimensionPriceTable->getDimensionPriceQuery();
       // $q->andWhere('pt.lang = ?', $language);
        $q->andWhere('promotion = 1');
        
        //$q->andWhere('dp.promotion IS NOT NULL');
        
        $products = $q->execute(array(), Doctrine_Core::HYDRATE_RECORD);
        $results = array();
        
       
//        foreach ($products as $product){
//            foreach($product as $key => $res):
//                echo $key."   ".$res." <br />";
//        endforeach;}
//            echo "<br /><br />";
//            if($product['dimensions']){
//                foreach ($product as $dp){
//                    $results[] = array('type' => 'dimension', 'product' => $product, 'dimensionPrice' => $dp);
//                    if(count($results) >= $limit) break;    /// jeśli limit rekordów przekroczony.
//                }
//            }else{
//                $results[] = array('type' => 'product', 'product' => $product);
//                if(count($results) >= $limit) break;    /// jeśli limit rekordów przekroczony.
//            }
//        }
//        
        return $products;
        //return $results;
        
    }
    public function saveDimensionFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$dimension = $this->getDimension((int) $values['id'])) {
            $dimension = $this->dimensionTable->getRecord();
        }
        
        $dimension->fromArray($values);
        
        $dimension->save();
        
        return $dimension;
    }
    
    public function saveDimensionPriceFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$dimensionPrice = $this->getDimensionPrice((int) $values['id'])) {
            $dimensionPrice = $this->dimensionPriceTable->getRecord();
        }
        
        $dimensionPrice->fromArray($values);
        
        $dimensionPrice->save();
        
        return $dimensionPrice;
    }
    
    public function removeDimension(Product_Model_Doctrine_Dimension $dimension) {
        $dimension->unlink('DimensionPrices');
        $dimension->save();
        $dimension->delete();
    }
    public function removeDimensionPrice(Product_Model_Doctrine_DimensionPrice $dimensionPrice) {
        $dimensionPrice->delete();
    }
    
    public function getAllDimensions($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->dimensionTable->getDimensionQuery();
        return $q->execute(array(), $hydrationMode);
    }
    public function getAllDimensionsInArray() {
        $q = $this->dimensionTable->getDimensionQuery();
        $allDimensions = $q->execute(array(), Doctrine_Core::HYDRATE_RECORD);
        $dimensions = array();
        foreach ($allDimensions as $dimension){
            $dimensions[$dimension->id] = $dimension->width." cm x ".$dimension->height." cm";
        }
        return $dimensions;
    }
    
    function getDimensionByWidthAndHeight($width, $height, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->dimensionTable->getDimensionQuery();
        $q->andWhere('p.width = ?', $width);
        $q->andWhere('p.height = ?', $height);
        
        return $q->fetchOne(array(), $hydrationMode = Doctrine_Core::HYDRATE_RECORD);
    }
    
    public function getDimensionPriceByProductAndDimension($productId, $dimensionId, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->dimensionPriceTable->getDimensionPriceQuery();
        $q->andWhere('p.product_id = ?', $productId);
        $q->andWhere('p.dimension_id = ?', $dimensionId);
        
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    
    public function refreshPromotionDimension($dimension){
        if ($dimension->isPromoted()):
            $dimension->setPromoted(0);
        else:
            $dimension->setPromoted(1);
        endif;
        $dimension->save();
    }
    
    
    public function getSelectedDiscountSelectOptions($discountId, $language = null, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->dimensionPriceTable->getDimensionPriceQuery();
        $q->andWhere('p.discount_id = ?', $discountId);
        $items = $q->execute(array(), $hydrationMode);
        $result = array();
        foreach($items as $item) {
            $result[$item->getId()] = ""; 
        }
        return $result;
    }
    
    public function unSelectDiscountDimensionPrices($selectedDimensionPrices, $newSelectedDimensionPrices){
        foreach($selectedDimensionPrices as $key => $selectedDimensionPrice):
            $flag = false;
            foreach($newSelectedDimensionPrices as $newSelectedDimensionPrice):
                if ($key == $newSelectedDimensionPrice):
                    $flag = true;
                endif;
            endforeach;
            if ($flag == false):
                $dimensionPrice = $this->getDimensionPrice($key);
                $dimensionPrice->setDiscountId(NULL);
                $dimensionPrice->save();
            endif;
        endforeach;
    }
    
    public function saveAssignedDiscountsFromArray($values, $discountId){
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        $selectedDimensionPrices = $this->getSelectedDiscountSelectOptions($discountId);
        $this->unSelectDiscountDimensionPrices($selectedDimensionPrices, $values);
        foreach($values as $value):
            $dimensionPrice = $this->getDimensionPrice($value);
            $dimensionPrice->setDiscountId($discountId);
            $dimensionPrice->save();
        endforeach;
    }
    
    public function getDimensionsForProduct(Product_Model_Doctrine_Product $product, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->dimensionPriceTable->getDimensionQuery();
        $q->andWhere('p.product_id = ?', $product->id);
        
        $dimensions = array();
        
        foreach ($q->execute(array(), $hydrationMode) as $dimension){
            $dimensions[] = array(
                
            );
        }
    }
    
    
}
?>