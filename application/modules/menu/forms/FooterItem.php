<?php

class Menu_Form_FooterItem extends Admin_Form
{
    public function init() {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $menuId = $this->createElement('hidden', 'menu_id');
        $menuId->setDecorators(array('ViewHelper'));
        
        $parentId = $this->createElement('hidden', 'parent_id');
        $parentId->setDecorators(array('ViewHelper'));
        
        $customUrl = $this->createElement('text', 'custom_url');
        $customUrl->setLabel('Custom URL');
        $customUrl->setDecorators(self::$textDecorators);
        
        $translations = new Zend_Form_SubForm();

        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));

            $title = $translationForm->createElement('text', 'title');
            $title->setBelongsTo($language);
            $title->setLabel('Title');
            $title->setDecorators(self::$textDecorators);
            $title->addValidators(array(
                array('regex', false, array('pattern' => '/[a-zA-Z0-9\&\/\.\,\-]+/'))
            ));
            $title->setAttrib('class', 'span8');
            
            $titleAttr = $translationForm->createElement('text', 'title_attr');
            $titleAttr->setBelongsTo($language);
            $titleAttr->setLabel('Title attribute');
            $titleAttr->setDecorators(self::$textDecorators);
            $titleAttr->addValidators(array(
                array('regex', false, array('pattern' => '/[a-zA-Z0-9\&\/\.\,\-]+/'))
            ));
            $titleAttr->setAttrib('class', 'span8');

            $translationForm->setElements(array(
                $title,
                $titleAttr
            ));

            $translations->addSubForm($translationForm, $language);
        }

        $this->addSubForm($translations, 'translations');

        $uniqueId = $this->createElement('text', 'unique_id');
        $uniqueId->setLabel('Unique ID');
        $uniqueId->setDecorators(self::$textDecorators);
        $uniqueId->setAttrib('class', 'span8');
        
        $cssClass = $this->createElement('text', 'css_class');
        $cssClass->setLabel('CSS Class');
        $cssClass->setDecorators(self::$textDecorators);
        $cssClass->setAttrib('class', 'span8');
        
        $target = $this->createElement('select', 'target');
        $target->setLabel('Target');
        $target->setDecorators(self::$selectDecorators);
        $target->setAttrib('class', 'span8');

        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id,
            $menuId,
            $customUrl,
            $uniqueId,
            $cssClass,
            $parentId,
            $target,
            $submit
        ));
    }
    
}

