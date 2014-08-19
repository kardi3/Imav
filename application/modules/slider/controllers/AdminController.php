<?php

class Slider_AdminController extends MF_Controller_Action {
    private $animations;
    public function init() {
        $this->_helper->ajaxContext
                ->addActionContext('add-slide', 'json')
                ->initContext();
        $this->animations = array(
            'boxslide' => 'boxslide',
            'boxfade' => 'boxfade',
            'slotzoom-horizontal' => 'slotzoom-horizontal',
            'slotzoom-vertical' => 'slotzoom-vertical',
            'slotslide-horizontal' => 'slotslide-horizontal',
            'slotslide-vertical' => 'slotslide-vertical',
            'slotfade-horizontal' => 'slotfade-horizontal',
            'slotfade-vertical' => 'slotfade-vertical',
            'curtain-1' => 'curtain-1',
            'curtain-2' => 'curtain-2',
            'curtain-3' => 'curtain-3',
            'slideleft' => 'slideleft',
            'slideright' => 'slideright',
            'slideup' => 'slideup',
            'slidedown' => 'slidedown',
            'slidehorizontal' => 'slidehorizontal',
            'slidevertical' => 'slidevertical',
            'fade' => 'fade',
            'random' => 'random'
        );
        parent::init();
    }
    
    public function listSlideAction() {
        $sliderService = $this->_service->getService('Slider_Service_Slider');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
        $photoDimension = $photoDimensionService->getElementDimension('slidersmall');
        $sliderConfig = $this->_service->get('sliders');
        
        foreach($sliderConfig as $id => $name) {
            if(!$slider = $sliderService->getSlider($id)) {
                $sliderService->saveSliderFromArray(array('id' => $id, 'name' => $name));
            }
        }
        
        if(!$slider = $sliderService->getSlider($this->getRequest()->getParam('slider', array_shift(array_keys($sliderConfig))))) {
            throw new Zend_Controller_Action_Exception('Slider not found');
        }
        
        $slideRoot = $sliderService->getSliderSlideRoot($slider);
        $slides = $slideRoot->getNode()->getChildren();
        
        $this->view->assign('sliderConfig', $sliderConfig);
        $this->view->assign('photoDimension', $photoDimension);
        $this->view->assign('slider', $slider);
        $this->view->assign('slides', $slides);
    }
    
    public function listSlideDataAction() {
        $table = Doctrine_Core::getTable('Slider_Model_Doctrine_Slide');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Slider_DataTables_Slide', 
            'columns' => array('x.title'),
            'searchFields' => array('x.title')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result['id'];
            $row[] = $result['title'];
            $options = '<a href="' . $this->view->adminUrl('edit-slide', 'slider', array('id' => $result['id'])) . '" title="' . $this->view->translate('Edit') . '"><span class="icon16 icon-edit"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('delete-slide', 'slider', array('id' => $result['id'])) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    
    // json actions
    
    public function addSlidePhotoAction() {
        $sliderService = $this->_service->getService('Slider_Service_Slider');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
        $photoDimension = $photoDimensionService->getDimension('slidersmall');
        
        if(!$slider = $sliderService->getSlider($this->getRequest()->getParam('slider'))) {
            throw new Zend_Controller_Action_Exception('Slider not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $href = $this->getRequest()->getParam('hrefs');

        if(is_array($href) && count($href)) {
            foreach($href as $h) {
                $path = str_replace("http://" . $options['domain'], "", urldecode($h));
                $filePath = $options['publicDir'] . $path;
                if(file_exists($filePath)) {
                    $pathinfo = pathinfo($filePath);
                    $slug = MF_Text::createSlug($pathinfo['basename']);
                    $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                        ////Default values of slider:
                        $defaultValues = array(
//                            'title' => 'Title',
                            'title_color' => '#FFFFFF',
                            'title_pos_x' => 175,
                            'title_pos_y' => 175,
                            'title_size' => 32,
//                            'description' => 'Description',
                            'description_size' => 15,
                            'description_color' => '#FFFFFF',
                            'description_bg_color' => '#FF0000',
                            'description_pos_x' => 310,
                            'description_pos_y' => 210,
                            'animation' => array_rand($this->animations)
                        );
                        
                        $slideRoot = $sliderService->getSliderSlideRoot($slider);

                        $slide = $sliderService->saveSlideFromArray(array('slider_id' => $slider->getId())+$defaultValues);
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], $photoDimension, false, false);

                        $slide->set('PhotoRoot', $photo);
                        
                        $slide->save();

                        $slide->getNode()->insertAsLastChildOf($slideRoot);
                        $slideRoot->refresh();

                        $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('log')->log($e->getMessage(), 4);
                    }
                }
            }
        } elseif(is_string($href) && strlen($href)) {
            if($slide = $sliderService->getSlide((int) $this->getRequest()->getParam('id'))) {
                $path = str_replace("http://" . $options['domain'], "", urldecode($href));
                $filePath = urldecode($options['publicDir'] . $path);
                if(file_exists($filePath)) {
                    $pathinfo = pathinfo($filePath);
                    $slug = MF_Text::createSlug($pathinfo['basename']);
                    $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                        
                        $root = $slide->get('PhotoRoot');
                        if(!$root || $root->isInProxyState()) {
                            $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'],$photoDimension, false, false);
                        } else {
                            $photo = $photoService->clearPhoto($root);
                            $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], $photoDimension, false);
                        }

                        $slide->set('PhotoRoot', $photo);
                        $slide->save();

                        $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('log')->log($e->getMessage(), 4);
                    }
                }
            }
        }

        
        $slideRoot = $slider->get('SlideRoot');
        $slides = $slideRoot->getNode()->getChildren();
        $list = $this->view->partial('admin/slider-slide-photos.phtml', 'slider', array('slides' => $slides, 'slider' => $slider));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $slider->getId()
        ));
        
    }
    
    public function editSlideAction() {
        $sliderService = $this->_service->getService('Slider_Service_Slider');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
        $photoDimension = $photoDimensionService->getElementDimension('slidersmall');
        
        if(!$slider = $sliderService->getSlider($this->getRequest()->getParam('slider'))) {
            throw new Zend_Controller_Action_Exception('Slider not found');
        }
        
        if(!$slide = $sliderService->getSlide($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Slide not found');
        }
        
        $form = $sliderService->getSlideForm($slide);
        $form->setAction($this->view->adminUrl('edit-slide', 'slider'));
        
        $form->animation->addMultiOptions($this->animations);
        
        $photo = $slide->get('PhotoRoot');
        
        $photosDir = $photoService->photosDir;
        $offsetDir = realpath($photosDir . DIRECTORY_SEPARATOR . $photo->getOffset());
        if(strlen($photo->getFilename()) > 0 && file_exists($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename())) {
            list($width, $height) = getimagesize($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename());
            $this->view->assign('imgDimensions', array('width' => $width, 'height' => $height));
        }
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    $values['title_size'] = intval($values['title_size']);
                    $values['title_pos_x'] = intval($values['title_pos_x']);
                    $values['title_pos_y'] = intval($values['title_pos_y']);
                    $values['description_pos_x'] = intval($values['description_pos_x']);
                    $values['description_pos_y'] = intval($values['description_pos_y']);
                    $values['description_size'] = intval($values['description_size']);
                    
                    $slide = $sliderService->saveSlideFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-slide', 'slider', array('slider' => $slider->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $dimensions = Slider_Model_Doctrine_Slide::getSlidePhotoDimensions();
        
        $this->view->assign('slider', $slider);
        $this->view->assign('slide', $slide);
        $this->view->assign('photo', $photo);
        $this->view->assign('photoDimension', $photoDimension);
        $this->view->assign('dimensions', $dimensions);
        $this->view->assign('form', $form);
    }
    
    public function deleteSliderSlideAction() {
        $sliderService = $this->_service->getService('Slider_Service_Slider');
        
        if($slider = $sliderService->getSlider($this->getRequest()->getParam('slider'))) {
            if($slide = $sliderService->getSlide($this->getRequest()->getParam('id'))) {
                $slide->getNode()->delete();
            }
        }
        
        $list = '';
        
        $slideRoot = $slider->get('SlideRoot');
        $slides = $slideRoot->getNode()->getChildren();
        $list = $this->view->partial('admin/slider-slide-photos.phtml', 'slider', array('slides' => $slides, 'slider' => $slider));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $slider->getId()
        ));
    }
    
    public function moveSliderSlideAction() {
        $sliderService = $this->_service->getService('Slider_Service_Slider');
        
        if($slider = $sliderService->getSlider($this->getRequest()->getParam('slider'))) {
            if($slide = $sliderService->getSlide($this->getRequest()->getParam('id'))) {
                $sliderService->moveSliderSlide($slide, $this->getRequest()->getParam('dir'));
            }
        }
        
        $list = '';
        
        $slideRoot = $slider->get('SlideRoot');
        $slides = $slideRoot->getNode()->getChildren();
        $list = $this->view->partial('admin/slider-slide-photos.phtml', 'slider', array('slides' => $slides, 'slider' => $slider));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $slider->getId()
        ));
    }
  
}

