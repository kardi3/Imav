<?php

/**
 * Guests
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Guests_Service_Guests extends MF_Service_ServiceAbstract {
    
    protected $postTable;
    
    public function init() {
        $this->postTable = Doctrine_Core::getTable('Guests_Model_Doctrine_Post');
    }
    
    public function getPostForm(Guests_Model_Doctrine_Post $post = null) {
        $form = new Guests_Form_Post();
        $form->setDefault('publish', 0);
        
        if(null != $post) {
            $form->populate($post->toArray());
        }
        return $form;
    }
    
    public function getEditPostForm(Guests_Model_Doctrine_Post $post = null) {
        $form = new Guests_Form_EditPost();
        if(null != $post) {
            $form->populate($post->toArray());
        }
        return $form;
    }
    
    public function savePostFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$post = $this->postTable->getProxy($values['id'])) {
            $post = $this->postTable->getRecord();
        }
           
        $post->fromArray($values);
        $post->save();
        
        return $post;
    }
    
    public function getPosts($limit, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->postTable->getPublishPostsQuery();
        $q = $this->postTable->getLimitQuery($limit, $q);
        $q->orderBy('a.created_at DESC');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getPost($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->postTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function removePost(Guests_Model_Doctrine_Post $post) {
        $post->delete();
    }
    
    public function refreshPost($post){
        if ($post->isPublish()):
            $post->setPublish(0);
        else:
            $post->setPublish(1);
        endif;
        $post->save();
    }
    
    public function getAllEntries($countOnly = false) {
        if(true == $countOnly) {
            return $this->postTable->count();
        } else {
            return $this->postTable->findAll();
        }
    }
    
    public function getEntriesPaginationQuery() {
        $q = $this->postTable->getPublishPostsQuery();
        $q->addOrderBy('a.publish DESC');
        return $q;
    }
}

