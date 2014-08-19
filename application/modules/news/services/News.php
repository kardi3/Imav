<?php

/**
 * News_Service_News
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class News_Service_News extends MF_Service_ServiceAbstract{
    
    protected $newsTable;
    
    public function init() {
        $this->newsTable = Doctrine_Core::getTable('News_Model_Doctrine_News');
    }
    
    public function getAllNews($countOnly = false) {
        if(true == $countOnly) {
            return $this->newsTable->count();
        } else {
            return $this->newsTable->findAll();
        }
    }
    
    public function getAllArticles($countOnly = false) {
        if(true == $countOnly) {
            return $this->newsTable->count();
        } else {
            return $this->newsTable->findAll();
        }
    }
    
    public function getNews($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->newsTable->findOneBy($field, $id, $hydrationMode);
    }
  
    
    public function getFullArticle($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->newsTable->getPublishNewsQuery();
        if(in_array($field, array('id'))) {
            $q->andWhere('n.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('nt.' . $field . ' = ?', array($id));
            $q->andWhere('nt.lang = ?', 'pl');
        }
        return $q->fetchOne(array(), $hydrationMode);
    }
    
   
    
    public function getNew($limit, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->newsTable->getPublishNewsQuery();
        $q = $this->newsTable->getPhotoQuery($q);
        $q = $this->newsTable->getLimitQuery($limit, $q);
        $q->orderBy('a.created_at DESC');
        return $q->execute(array(), $hydrationMode);
    }

    public function getNewsPaginationQuery($language) {
        $q = $this->newsTable->getPublishNewsQuery();
       // $q = $this->newsTable->getPhotoQuery($q);
        $q->andWhere('at.lang = ?', $language);
        $q->addOrderBy('a.publish_date DESC');
        return $q;
    }
    
    public function getNewsForm(News_Model_Doctrine_News $news = null) {
         
       
        $form = new News_Form_News();
        $form->setDefault('publish', 1);
        
        if(null != $news) {
            
            $form->populate($news->toArray());
            if($publishDate = $news->getPublishDate()) {
                $date = new Zend_Date($news->getPublishDate(), 'yyyy-MM-dd HH:mm:ss');
                $form->getElement('publish_date')->setValue($date->toString('dd/MM/yyyy HH:mm'));
            }
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('title')->setValue($news->Translation[$language]->title);
                    $i18nSubform->getElement('content')->setValue($news->Translation[$language]->content);
                }
            }
        }
        
        return $form;
    }
    
    public function saveNewsFromArray($values,$last_user_id,$user_id = null) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$news = $this->newsTable->getProxy($values['id'])) {
            $news = $this->newsTable->getRecord();
        }
       
        if($user_id!= null)
            $values['user_id'] = $user_id;
        
        $values['last_user_id'] = $last_user_id;
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        if(strlen($values['publish_date'])) {
            $date = new Zend_Date($values['publish_date'], 'dd/MM/yyyy HH:mm');
            $values['publish_date'] = $date->toString('yyyy-MM-dd HH:mm:00');
        } elseif(!strlen($news['publish_date'])) {
            $values['publish_date'] = date('Y-m-d H:i:s');
        }

        $news->fromArray($values);
 
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['title'])) {
                $news->Translation[$language]->title = $values['translations'][$language]['title'];
               
                $news->Translation[$language]->slug = MF_Text::createUniqueTableSlug('News_Model_Doctrine_NewsTranslation', $values['translations'][$language]['title'], $news->getId());
              
                $news->Translation[$language]->content = $values['translations'][$language]['content'];
            }
        }
        $news->save();
       
       
         
        return $news;
    }
    
    public function removeNews(News_Model_Doctrine_News $news) {
        $news->delete();
    }
     
    public function searchNews($phrase, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getAllNewsQuery();
        $q->addSelect('TRIM(at.title) AS search_title, TRIM(at.content) as search_content, "news" as search_type');
        $q->andWhere('at.title LIKE ? OR at.content LIKE ?', array("%$phrase%", "%$phrase%"));
        return $q->execute(array(), $hydrationMode);
    }
    
      public function getLastNews($limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getNewsQuery();
//        $q->andWhere('n.publish = 1');
//        $q->addWhere('n.publish_date > NOW()');
        $q->orderBy('n.publish_date DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getPopularNews($limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getNewsCommentQuery();
//        $q->andWhere('n.publish = 1');
//        $q->addWhere('n.publish_date > NOW()');
        $q->addSelect('count(c.id) as comment_count');
        $q->addWhere('n.created_at > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $q->orderBy('n.publish_date DESC');
        $q->limit($limit);
        $q->groupBy('n.id');
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getLastCategoryNews($category_id,$limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getNewsQuery();
//        $q->andWhere('n.publish = 1');
//        $q->addWhere('n.publish_date > NOW()');
        $q->addWhere('n.category_id = ?',$category_id);
        $q->orderBy('n.publish_date DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
     
    
}

