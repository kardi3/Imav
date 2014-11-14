<?php

/**
 * Gallery
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Gallery_Service_Gallery extends MF_Service_ServiceAbstract {
    
    protected $galleryTable;
    
    public function init() {
        $this->galleryTable = Doctrine_Core::getTable('Gallery_Model_Doctrine_Gallery');
    }
    
    public function getGallery($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->galleryTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function fetchGallery($type, $language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $serviceBroker = $this->getServiceBroker();
        $translator = $serviceBroker->get('translate');
        
        $galleryTypes = Gallery_Model_Doctrine_Gallery::getAvailableTypes();
        
        if(!$gallery = $this->getGallery($type, 'type', $hydrationMode)) {
            $gallery = $this->galleryTable->getRecord();
            $gallery->Translation[$language]->title = $translator->translate($galleryTypes[$type], $language);
            $gallery->Translation[$language]->slug = MF_Text::createSlug($gallery->Translation[$language]->title);
            $gallery->setType($type);
            $gallery->save();
        }
        return $gallery;
    }
    
    public function getI18nGallery($id, $field = 'id', $language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->galleryTable->getFullGalleryQuery();
        switch($field) {
            case 'slug':
            case 'title':
                $q->andWhere('gt.' . $field . ' = ?', $id);
                break;
            default:
                $q->andWhere('g.' . $field . ' = ?', $id);
        }
        $q->andWhere('(gt.lang = ? AND (mt.lang = ? OR mt.lang IS NULL))', array($language, $language));
        return $q->fetchOne(array(), $hydrationMode);
    }
    
     public function getLatestGalleries($limit = 3,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->galleryTable->getFullGalleryQuery();
        $q->addOrderBy('g.created_at DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getMainPageGalleries($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->galleryTable->getFullGalleryQuery();
        $q->addWhere('g.main_page = 1');
        $q->addOrderBy('g.created_at DESC');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getCategoryGalleries($category_id,$limit = 3,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->galleryTable->getShortGalleryQuery();
        $q->addWhere('g.category_id = ?',$category_id);
        $q->addOrderBy('g.created_at DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getLastCategoryOtherGalleries($gallery, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->galleryTable->getShortGalleryQuery();
        $q->addWhere('g.category_id = ?',$gallery['category_id']);
        $q->addWhere('g.id != ?',$gallery['id']);
        $q->orderBy('g.created_at DESC');
        $q->limit(8);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getGalleryPaginationQuery($language) {
        $q = $this->galleryTable->getShortGalleryQuery();
        $q->addOrderBy('g.created_at DESC');
        return $q;
    }
    
    public function getAllGallerys() {
        return $this->galleryTable->findAll();
    }
    
    public function getGallerySelectOptions($language, $prependEmptyValue = false, $idPrefix = '') {
        $gallerys = $this->getAllGallerys();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = null;
        }
        foreach($gallerys as $gallery) {
            $result[$idPrefix . $gallery->getId()] = $gallery->get('Translation')->get($language)->title;
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
    
     public function saveGalleryFromNews(News_Model_Doctrine_News $news) {
        $gallery = $this->galleryTable->getRecord();
        $gallery['photo_root_id'] = $news['photo_root_id'];
        $gallery['category_id'] = $news['category_id'];
        
        foreach($news['Translation'] as $language => $translation) {
            $gallery->Translation[$language]->title = $translation['title'];
            $gallery->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Gallery_Model_Doctrine_GalleryTranslation', $news['Translation'][$language]['title'], $gallery->getId());
            $gallery->Translation[$language]->content = $translation['content'];
        }
        
        $gallery->save();
        return $gallery;
    }
    
    public function saveGalleryFromAttraction(District_Model_Doctrine_Attraction $attraction) {
        $gallery = $this->galleryTable->getRecord();
        $gallery['photo_root_id'] = $attraction['photo_root_id'];
        $gallery['category_id'] = 10;
        
        foreach($attraction['Translation'] as $language => $translation) {
            $gallery->Translation[$language]->title = $translation['title'];
            $gallery->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Gallery_Model_Doctrine_GalleryTranslation', $attraction['Translation'][$language]['title'], $gallery->getId());
            $gallery->Translation[$language]->content = $translation['content'];
        }
        
        $gallery->save();
        return $gallery;
    }
    
    public function saveGalleryFromArray(array $values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }    
        
        if(!$gallery = $this->galleryTable->getProxy($values['id'])) {
            $gallery = $this->galleryTable->getRecord();
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

