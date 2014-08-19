<?php

/**
 * Offer_Form_Notice
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Form_Notice extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));

        $province = $this->createElement('select', 'province');
        $province->setLabel('Province');
        $province->setDecorators(self::$selectDecorators);
        $province->setRequired(true);
        
        $city = $this->createElement('select', 'city');
        $city->setLabel('City');
        $city->setDecorators(self::$selectDecorators);
        $city->setRequired(true);
        
        $category = $this->createElement('select', 'category');
        $category->setLabel('Category');
        $category->setDecorators(self::$selectDecorators);
        $category->setRequired(true);
        
        $title = $this->createElement('text', 'title');
        $title->setLabel('Title');
        $title->setDecorators(self::$textDecorators);
        $title->setRequired(true);
        
        $content = $this->createElement('textarea', 'content');
        $content->setLabel('Content');
        $content->setDecorators(array('ViewHelper'));
        $content->setAttrib('class', 'tinymce uniform');
        $content->setAttrib('rows', 6);
        $content->setRequired(true);
        
        $publish = $this->createElement('checkbox', 'publish');
        $publish->setLabel('Publish');
        $publish->setDecorators(self::$checkboxDecorators);
        
        $publishDate = $this->createElement('text', 'publish_date');
        $publishDate->setLabel('Publish date');
        $publishDate->setDecorators(self::$textDecorators);
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id,
            $province,
            $city,
            $category,
            $title,
            $content,
            $publish,
            $publishDate,
            $submit
        ));
    }
    
}

