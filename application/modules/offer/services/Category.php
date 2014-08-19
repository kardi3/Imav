<?php

/**
 * Category
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Service_Category extends MF_Service_ServiceAbstract {
    
    protected $categoryTable;
    protected $categoryPriceTable;
    
    public function init() {
        $this->categoryTable = Doctrine_Core::getTable('Offer_Model_Doctrine_Category');
        $this->categoryPriceTable = Doctrine_Core::getTable('Offer_Model_Doctrine_CategoryPrice');
        parent::init();
    }
    
    public function fetchCategoryPrice($category, $period) {
        if($category instanceof Offer_Model_Doctrine_Category) {
            $category = $category->getId();
        }
        
        if(!$categoryPrice = $this->categoryPriceTable->findOneByCategoryIdAndPeriod($category, $period)) {
            $categoryPrice = $this->categoryPriceTable->getRecord();
            $categoryPrice->setCategoryId($category);
            $categoryPrice->setPeriod($period);
            $categoryPrice->save();
        }
        
        return $categoryPrice;
    }
    
    public function getCategory($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->categoryTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getAllCategories($count = null) {
        if(null != $count) {
            return $this->categoryTable->count();
        } else {
            return $this->categoryTable->findAll();
        }
    }
    
  
    
    public function getCategoryPriceTree() {
        $categoryTree = $this->categoryTable->getTree();
        $query = $categoryTree->getBaseQuery();
        $query->addSelect('cp.*');
        $query->leftJoin('c.Prices cp');
        $categoryTree->fetchTree(array('root_id' => $this->getCategoryRoot()->getId()), Doctrine_Core::HYDRATE_RECORD_HIERARCHY);
        return $categoryTree;
    }
    
    public function getCategoryTree() {
        return $this->categoryTable->getTree();
    }
    
    public function getCategoryRoot() {
        return $this->getCategoryTree()->fetchRoot();
    }
    
    public function createCategoryRoot($name) {
        $category = $this->categoryTable->getRecord();
        $category->setName($name);
        $category->save();
        
        $tree = $this->getCategoryTree();
        $tree->createRoot($category);
        
        return $category;
    }
    
    public function getCategorySelectOptions($category = null, $result = array()) {
        if(null == $category) {
            $category = $this->getCategoryRoot();
        }
        
        foreach($category->getNode()->getChildren() as $child) {
            if($child->getNode()->getChildren()) {
                $result[$child->getName()] = $this->getCategorySelectOptions($child);
            } else {
                $result[$child->getId()] = $child->getName();
            }
        }
        
        return $result;
    }
    
    public function getCategoryPriceForm($prices) {
        $form = new Offer_Form_CategoryPrice();
        
        $availablePeriods = Offer_Model_Doctrine_CategoryPrice::getAvailablePeriods();
        
        $priceSubform = new Zend_Form_SubForm();
        $priceSubform->setDecorators(array('FormElements'));
            
        foreach($availablePeriods as $period => $label) {
            $priceElement = $priceSubform->createElement('text', (string) $period);
            $priceElement->setLabel($label);
            $priceElement->setDecorators(Admin_Form::$textDecorators);
            $priceElement->setAttrib('class', 'span2 text');
            foreach($prices as $price) {
                if($price->getPeriod() == (int) $period) {
                    $priceElement->setValue($price->getPrice());
                }
            }
            $priceSubform->addElement($priceElement);
        }
        $form->addSubForm($priceSubform, 'prices');
        return $form;
    }
    
    public function getCategoryForm(Offer_Model_Doctrine_Category $category = null) {
        $form = new Offer_Form_Category();
        if(null != $category) {
            $form->populate($category->toArray());
        }
        return $form;
    }
    
    public function saveCategoryFromArray(array $values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$category = $this->categoryTable->getProxy($values['id'])) {
            $category = $this->categoryTable->getRecord();
        }

        $values['slug'] = MF_Text::createUniqueTableSlug('Offer_Model_Doctrine_Category', $values['name'], $values['id']);
        $category->fromArray($values);
        $category->save();
        
        if(isset($values['parent_id'])) {
            $parent = $this->getCategory((int) $values['parent_id']);
            $category->getNode()->insertAsLastChildOf($parent);
        }
        
        return $category;
    }
    
    public function moveCategory($category, $dest, $mode) {
        switch($mode) {
            case 'before':
                if($dest->getNode()->isRoot()) {
                    throw new Exception('Cannot move category on root level');
                }
                $category->getNode()->moveAsPrevSiblingOf($dest);
                break;
            case 'after':
                if($dest->getNode()->isRoot()) {
                    throw new Exception('Cannot move category on root level');
                }
                $category->getNode()->moveAsNextSiblingOf($dest);
                break;
            case 'over':
                $category->getNode()->moveAsLastChildOf($dest);
                break;
        }
    }
    
    public function removeCategory($category) {
        if($descendants = $category->getNode()->getDescendants()) {
            $descendants->delete();
        }
        return $category->getNode()->delete();
    }
    
    public function saveCategoryPrices(Offer_Model_Doctrine_Category $category, $prices) {
        foreach($prices as $period => $price) {
            $categoryPrice = $this->fetchCategoryPrice($category, $period);
            $categoryPrice->setPrice($price);
            $categoryPrice->save();
        }
    }
}

