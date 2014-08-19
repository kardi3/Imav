<?php

/**
 * Slider_Service_Slider
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Slider_Service_Slider extends MF_Service_ServiceAbstract {
    
    protected $sliderTable;
    protected $slideTable;
    
    public function init() {
        $this->sliderTable = Doctrine_Core::getTable('Slider_Model_Doctrine_Slider');
        $this->slideTable = Doctrine_Core::getTable('Slider_Model_Doctrine_Slide');
    }
    
    public function getSlider($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->sliderTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getSlide($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->slideTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getAll($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->sliderTable->getFullSliderQuery();
        $q->orderBy('sl.lft');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getSlideTree() {
        return $this->slideTable->getTree();
    }
    
    public function getSliderSlideRoot($slider) {
        $slideRoot = $slider->get('SlideRoot');
        if($slideRoot->isInProxyState()) {
            $slide = $this->saveSlideFromArray(array());
            $slideRoot = $this->getSlideTree()->createRoot($slide);
            $slider->set('SlideRoot', $slideRoot);
            $slider->save();
        }
        return $slideRoot;
    }
    
    public function getSlideForm(Slider_Model_Doctrine_Slide $slide = null) {
        $form = new Slider_Form_Slide();
        if(null != $slide) {
            $form->populate($slide->toArray());
        }
        return $form;
    }
    
    public function saveSliderFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$slider = $this->sliderTable->getProxy($values['id'])) {
            $slider = $this->sliderTable->getRecord();
        }
        
        $slider->fromArray($values);
        $slider->save();

        return $slider;
    }
    
    public function saveSlideFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$slide = $this->slideTable->getProxy($values['id'])) {
            $slide = $this->slideTable->getRecord();
        }
        
        $slide->fromArray($values);
        $slide->save();

        return $slide;
    }
    
    public function moveSliderSlide($slide, $direction = 'down') {
        if($direction == 'up') {
            $prevSibling = $slide->getNode()->getPrevSibling();
            if($prevSibling) {
                $slide->getNode()->moveAsPrevSiblingOf($prevSibling);
            }
        } elseif($direction == 'down') {
            $nextSibling = $slide->getNode()->getNextSibling();
            if($nextSibling) {
                $slide->getNode()->moveAsNextSiblingOf($nextSibling);
            }
        }
    }
}

