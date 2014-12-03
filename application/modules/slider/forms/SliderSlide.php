<?php

/**
 * Slider_Form_SliderSlide
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Slider_Form_SliderSlide extends Admin_Form {
    
    public function init() {
          $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
       
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $transition = $this->createElement('select', 'transition');
        $transition->setLabel('Transition');
        $transition->setAttrib('class', 'span8');
        $transition->setDecorators(self::$selectDecorators);
        $transition->setDescription('The appearance transition of this slide');
        
        $slotAmount= $this->createElement('text', 'slot_amount');
        $slotAmount->setLabel('Slot amount');
        $slotAmount->setAttrib('class', 'span8');
        $slotAmount->setDecorators(self::$textDecorators);
        $slotAmount->setDescription('The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy');
        
        $targetType = $this->createElement('radio', 'target_type');
        $targetType->setLabel('Cel linku');
        $targetType->setAttrib('class', 'span8');
      //  $targetType->setDecorators(self::$radioDecorators);
        $targetType->addMultiOption('','Brak linku');
        $targetType->addMultiOption('custom_target','Własny cel');
        $targetType->addMultiOption('news_target','News');
        $targetType->addMultiOption('stream_target','Stream');
        $targetType->setValue('');
        
        
        $targetHref = $this->createElement('text', 'target_href');
        $targetHref->setLabel('Wpisz url');
        $targetHref->setAttrib('class', 'span8');
        $targetHref->setDecorators(self::$textDecorators);
        
        $transitionDuration = $this->createElement('text', 'transition_duration');
        $transitionDuration->setLabel('Transition duration');
        $transitionDuration->setAttrib('class', 'span8');
        $transitionDuration->setDecorators(self::$textDecorators);
        $transitionDuration->setDescription('The duration of the transition (Default 300, min: 100, max: 2000)');
        
        $delay = $this->createElement('text', 'delay');
        $delay->setLabel('Delay');
        $delay->setAttrib('class', 'span8');
        $delay->setDecorators(self::$textDecorators);
        $delay->setDescription('A new Dealy value for the Slide. If no delay defined per slide, the dealy defined via Options will be used');
        
        
        $newsSlug = $this->createElement('select', 'news_id');
        $newsSlug->setLabel('Wybierz news');
        $newsSlug->setDecorators(self::$selectDecorators);
        
        $streamId = $this->createElement('select', 'stream_id');
        $streamId->setLabel('Wybierz stream');
        $streamId->setDecorators(self::$selectDecorators);
        
        $languages = $i18nService->getLanguageList();

        $translations = new Zend_Form_SubForm();

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
            $title->setAttrib('class', 'span8');
            
            $content = $translationForm->createElement('textarea', 'content');
            $content->setBelongsTo($language);
            $content->setLabel('Content');
            $content->setDecorators(self::$tinymceDecorators);
            $content->setAttrib('class', 'span8 tinymce');
            
            $translationForm->setElements(array(
                $title,
                $content
            ));

            $translations->addSubForm($translationForm, $language);
        }
        
        $this->addSubForm($translations, 'translations');
        
        $enableLink = $this->createElement('checkbox', 'enable_link');
        $enableLink->setLabel('Enable link');
        $enableLink->setDecorators(self::$textDecorators);
        $enableLink->setAttrib('class', 'span8');

        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id, 
            $transition,
            $slotAmount,
            $newsSlug,
            $targetType,
            $streamId,
            $targetHref,
            $transitionDuration,
            $delay,
            $enableLink,
            $submit
        ));
    }
}

