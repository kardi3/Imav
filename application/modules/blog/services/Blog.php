<?php

/**
 * Blog
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Blog_Service_Blog extends MF_Service_ServiceAbstract {
    
    protected $blogTable;
    
    public function init() {
        $this->blogTable = Doctrine_Core::getTable('Blog_Model_Doctrine_Blog');
        parent::init();
    }
    
    public function getBlogForm(Blog_Model_Doctrine_Blog $blog = null) {
        $form = new Blog_Form_Blog();
        $form->setDefault('publish', 1);
        
        if(null != $blog) {
            $form->populate($blog->toArray());
            if($publishDate = $blog->getPublishDate()) {
                $date = new Zend_Date($blog->getPublishDate(), 'yyyy-MM-dd HH:mm:ss');
                $form->getElement('publish_date')->setValue($date->toString('dd/MM/yyyy HH:mm'));
            }
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('title')->setValue($blog->Translation[$language]->title);
                    $i18nSubform->getElement('content')->setValue($blog->Translation[$language]->content);
                }
            }
        }
        
        return $form;
    }
    
    public function saveEntryFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$blog = $this->blogTable->getProxy($values['id'])) {
            $blog = $this->blogTable->getRecord();
        }

        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        if(strlen($values['publish_date'])) {
            $date = new Zend_Date($values['publish_date'], 'dd/MM/yyyy HH:mm');
            $values['publish_date'] = $date->toString('yyyy-MM-dd HH:mm:00');
        } elseif(!strlen($blog['publish_date'])) {
            $values['publish_date'] = date('Y-m-d H:i:s');
        }
        
        $blog->fromArray($values);

        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['title'])) {
                $blog->Translation[$language]->title = $values['translations'][$language]['title'];
                $blog->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Blog_Model_Doctrine_BlogTranslation', $values['translations'][$language]['title'], $blog->getId());
                $blog->Translation[$language]->content = $values['translations'][$language]['content'];
            }
        }
        
        $blog->save();
        
        return $blog;
    }
    
    public function getBlogEntry($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->blogTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function removeBlogEntry(Blog_Model_Doctrine_Blog $blogEntry) {
        $blogEntry->delete();
    }
    
    public function getBlogEntries($limit, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->blogTable->getPublishEntriesQuery();
        $q = $this->blogTable->getPhotoQuery($q);
        $q = $this->blogTable->getLimitQuery($limit, $q);
        $q->orderBy('a.created_at DESC');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getAllPosts($countOnly = false) {
        if(true == $countOnly) {
            return $this->blogTable->count();
        } else {
            return $this->blogTable->findAll();
        }
    }
    
    public function getEntriesPaginationQuery($language) {
        $q = $this->blogTable->getPublishEntriesQuery();
        $q = $this->blogTable->getPhotoQuery($q);
        $q->andWhere('at.lang = ?', $language);
        $q->addOrderBy('a.publish_date DESC');
        return $q;
    }
    
    public function getFullEntry($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->blogTable->getPublishEntriesQuery();
        $q = $this->blogTable->getPhotoQuery($q);
        if(in_array($field, array('id'))) {
            $q->andWhere('a.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('at.' . $field . ' = ?', array($id));
            $q->andWhere('at.lang = ?', 'pl');
        }
        return $q->fetchOne(array(), $hydrationMode);
    }
    
}

