<?php

/**
 * Product_Service_Collection
 *
@author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Product_Service_Collection extends MF_Service_ServiceAbstract {
    
    protected $collectionTable;
    
    public function init() {
        $this->collectionTable = Doctrine_Core::getTable('Product_Model_Doctrine_Collection');
        parent::init();
    }
    
    public function getCollection($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->collectionTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getFullCollection($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->collectionTable->getCollectionQuery();
        $q->andWhere('tr.' . $field . ' = ?', $id);
        return $q->fetchOne(array(), $hydrationMode);
    }
      public function getPromotedCollections($hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->collectionTable->getCollectionQuery();
        $q->andWhere('col.promoted = 1');
        return $q->execute(array(), $hydrationMode);
    }
     public function getCollections($hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->collectionTable->getCollectionQuery();
        return $q->execute(array(), $hydrationMode);
    }
    public function getCollectionForm(Product_Model_Doctrine_Collection $collection = null) {
        $form = new Product_Form_Collection();
        if(null != $collection) {
            $form->populate($collection->toArray());
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('name')->setValue($collection->Translation[$language]->name);
                    $i18nSubform->getElement('description')->setValue($collection->Translation[$language]->description);
                }
            }
        }
        return $form;
    }
    
    
    public function getCollectionRoot() {
        return $this->getCollectionTree()->fetchRoot();
    }
    
    public function getCollectionTree() {
        return $this->collectionTable->getTree();
    }
    
    public function createCollectionRoot($languagesDefined) {
        $collection = $this->collectionTable->getRecord();
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            $collection->Translation[$language]->name = $languagesDefined[$language];
        }
        $collection->save();
        
        $tree = $this->getCollectionTree();
        $tree->createRoot($collection);
        
        return $collection;
    }     
   
    public function saveCollectionFromArray(array $values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$collection = $this->collectionTable->getProxy($values['id'])) {
            $collection = $this->collectionTable->getRecord();
        }
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');

        $collection->fromArray($values);
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['name'])) {
                $collection->Translation[$language]->name = $values['translations'][$language]['name'];
                $collection->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Product_Model_Doctrine_CollectionTranslation', $values['translations'][$language]['name'], $collection->getId());
                $collection->Translation[$language]->description = $values['translations'][$language]['description'];
            }
        }
        
        $collection->save();
        
        if(isset($values['parent_id'])) {
            $parent = $this->getCollection((int) $values['parent_id']);
            $collection->getNode()->insertAsLastChildOf($parent);
        }
        
        return $collection;
    }
    
    public function moveCollection($collection, $dest, $mode) {
        switch($mode) {
            case 'before':
                if($dest->getNode()->isRoot()) {
                    throw new Exception('Cannot move collection on root level');
                }
                $collection->getNode()->moveAsPrevSiblingOf($dest);
                break;
            case 'after':
                if($dest->getNode()->isRoot()) {
                    throw new Exception('Cannot move collection on root level');
                }
                $collection->getNode()->moveAsNextSiblingOf($dest);
                break;
            case 'over':
                $collection->getNode()->moveAsLastChildOf($dest);
                break;
        }
    }
    
    public function removeCollection($collection) {
        if($descendants = $collection->getNode()->getDescendants()) {
            foreach($descendants as $desc):
                $desc->unlink('Products');
                $desc->save();
                $desc->delete();
            endforeach;
            
        }
        $collection->unlink('Products');
        $collection->get('Translation')->delete();
        $collection->save();
        $collection->getNode()->delete();
    }
    
    public function refreshStatusCollection($collection){
        if ($collection->isStatus()):
            $collection->setStatus(0);
        else:
            $collection->setStatus(1);
        endif;
        $collection->save();
    }
    
    public function getAllCollections($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->collectionTable->getCollectionQuery();
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getTargetCollectionSelectOptions($prependEmptyValue = false, $language = null) {
        $items = $this->getAllCollections();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = ' ';
        }
        foreach($items as $item) {
      
                $result[$item->getId()] = $item->Translation[$language]->name;
        
        }
        return $result;
    } 
    
     public function getAllCategoriesForCount($count = null) {
        if(null != $count) {
            return $this->collectionTable->count();
        } else {
            return $this->collectionTable->findAll();
        }
    }
    
    public function getMainCategories($limit, $language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->collectionTable->getMainCategoriesQuery();
        $q->limit($limit);
        $q->andWhere('ct.lang = ?', $language);
        return $q->execute(array(), $hydrationMode);
    }
    
//    public function getTargetCollectionSelectOptions($prependEmptyValue = false) {
////        if(null == $collection) {
////            $collection = $this->getCollectionRoot();
////        }
////        
////        foreach($collection->getNode()->getChildren() as $child) {
////            if($child->getNode()->getChildren()) {
////                $result[$child->getName()] = $this->getTargetCollectionSelectOptions($child);
////            } else {
////                $result[$child->getId()] = $child->getName();
////            }
////        }
////        return $result;
//        $items = $this->getAllCategories();
//        $result = array();
//        if($prependEmptyValue) {
//            $result[''] = ' ';
//        }
//        foreach($items as $item) {
////            $name = "";
////            $descendants = $item->getNode()->getDescendants(null, true);
////            foreach($descendants as $desc):
////                $name .= $desc->name."->";
////            endforeach;
////            if ($item->level > 0):
////                $result[$item->getId()] = $name;
////            endif;
//             if ($item->level > 0):
//            $result[$item->getId()] = str_repeat('|----', $item->level) . $item->name;
//         endif;
//             
//        }
//        return $result;
//    }  
    
}
?>