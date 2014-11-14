<?php

/**
 * Category
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Gallery_Service_Category extends MF_Service_ServiceAbstract {
    
    protected $categoryTable;
    
    public function init() {
        $this->categoryTable = Doctrine_Core::getTable('Gallery_Model_Doctrine_Category');
    }
    
    public function getCategory($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->categoryTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function fetchGallery($type, $language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $serviceBroker = $this->getServiceBroker();
        $translator = $serviceBroker->get('translate');
        
        $galleryTypes = Gallery_Model_Doctrine_Gallery::getAvailableTypes();
        
        if(!$gallery = $this->getGallery($type, 'type', $hydrationMode)) {
            $gallery = $this->categoryTable->getRecord();
            $gallery->Translation[$language]->title = $translator->translate($galleryTypes[$type], $language);
            $gallery->Translation[$language]->slug = MF_Text::createSlug($gallery->Translation[$language]->title);
            $gallery->setType($type);
            $gallery->save();
        }
        return $gallery;
    }
    
    public function getI18nCategory($id, $field = 'id', $language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->categoryTable->createQuery('c');
        $q->andWhere('c.' . $field . ' = ?', $id);
        return $q->fetchOne(array(), $hydrationMode);
    }
    
   
    
    public function getAllCategories() {
        return $this->categoryTable->findAll();
    }
    
    public function getCategorySelectOptions($language, $prependEmptyValue = false, $idPrefix = '') {
        $categories = $this->getAllCategories();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = null;
        }
        foreach($categories as $category) {
            $result[$idPrefix . $category->getId()] = $category->title;
        }
        return $result;
    }
    
    public function getGalleryForm(Gallery_Model_Doctrine_Gallery $gallery = null) {
        $form = new Gallery_Form_Gallery();
        if(null !== $gallery) {
            $form->populate($gallery->toArray());
        }
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            $i18nSubform = $form->translations->getSubForm($language);
            if($i18nSubform) {
                $i18nSubform->getElement('title')->setValue($gallery->Translation[$language]->title);
                $i18nSubform->getElement('content')->setValue($gallery->Translation[$language]->content);
            }
        }
        return $form;
    }
    
    public function saveGalleryFromArray(array $values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }    
        
        if(!$gallery = $this->categoryTable->getProxy($values['id'])) {
            $gallery = $this->categoryTable->getRecord();
        }
        
        $gallery->fromArray($values);
        foreach($values['translations'] as $language => $translation) {
            $gallery->Translation[$language]->title = $translation['title'];
            $gallery->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Gallery_Model_Doctrine_GalleryTranslation', $values['translations'][$language]['title'], $gallery->getId());
            $gallery->Translation[$language]->content = $translation['content'];
        }
        
        $gallery->save();
        return $gallery;
    }
    
    public function removeGallery(Gallery_Model_Doctrine_Gallery $gallery) {
        $gallery->get('Translation')->delete();
        $gallery->delete();
    }
    
}

