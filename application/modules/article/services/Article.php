<?php

/**
 * Article_Service_Article
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Article_Service_Article extends MF_Service_ServiceAbstract {
    
    protected $articleTable;
    
    public function init() {
        $this->articleTable = Doctrine_Core::getTable('Article_Model_Doctrine_Article');
        parent::init();
    }
    
    public function getRecentArticles($limit, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->articleTable->getArticleQuery();
        $q->addOrderBy('a.created_at DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getNewArticles($date, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->articleTable->getArticleQuery();
        $q->andWhere('a.created_at > ?', $date);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getArticle($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->articleTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getFullArticle($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->articleTable->getArticleQuery();
        $q->andWhere('a.' . $field . ' = ?', $id);
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getArticlePaginationQuery() {
        $q = $this->articleTable->getArticleQuery();
        $q->addOrderBy('a.created_at DESC');
        return $q;
    }
    
    public function getUserArticlesQuery($userId) {
        $q = $this->articleTable->getArticleQuery();
        $q->andWhere('a.user_id = ?', $userId);
        $q->addOrderBy('created_at DESC');
        return $q;
    }
    
    public function getArticleForm(Article_Model_Doctrine_Article $article = null) {
        $form = new Article_Form_Article();
        if(null != $article) {
            $form->populate($article->toArray());
        }
        return $form;
    }
    
    public function saveArticleFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$article = $this->getArticle((int) $values['id'])) {
            $article = $this->articleTable->getRecord();
        }
        
        $article->fromArray($values);
        $article->save();
        
        return $article;
    }
    
    public function removeArticle($article) {
        $article->delete();
    }
}

