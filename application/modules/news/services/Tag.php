<?php

/**
 * News_Service_News
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class News_Service_Tag extends MF_Service_ServiceAbstract{
    
    protected $tagTable;
    
    public function init() {
        $this->tagTable = Doctrine_Core::getTable('News_Model_Doctrine_Tag');
    }
    
    public function getAllCategories($countOnly = false) {
        if(true == $countOnly) {
            return $this->tagTable->count();
        } else {
            return $this->tagTable->findAll();
        }
    }
    
    public function getTag($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->tagTable->findOneBy($field, $id, $hydrationMode);
    }
   
    
    public function getTagForm(News_Model_Doctrine_Tag $tag = null) {
         
       
        $form = new News_Form_Tag();
        if($tag!=null)
            $form->populate($tag->toArray());
        
        return $form;
    }
    
    public function saveTagFromArray($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$tag = $this->tagTable->getProxy($values['id'])) {
            $tag = $this->tagTable->getRecord();
        }
       
        $tag->slug = MF_Text::createUniqueTableSlug('News_Model_Doctrine_Tag', $values['title'], $tag->getId());
              
        
        $tag->fromArray($values);
 
        $tag->save();
       
        return $tag;
    }
    
    public function removeTag(News_Model_Doctrine_Tag $tag) {
        $tag->delete();
    }
    
    public function prependTagOptions() {
       
       $options = array('' => '');
       $categories = $this->getAllCategories();
       
       foreach($categories as $tag):
           $options[$tag['id']] = $tag['title'];
       endforeach;
       
       return $options;
    }
     
   
}

