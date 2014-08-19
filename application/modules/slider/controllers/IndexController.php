<?php

class Slider_IndexController extends MF_Controller_Action
{
    
    
     public function indexAction() {
        $sliderService = $this->_service->getService('Slider_Service_Slider');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
        $photoDimension = $photoDimensionService->getElementDimension('slidersmall');
        $photoDimensionWidth = $photoDimensionService->getElementDimensionWidth('slidersmall');
        
        $sliders = $sliderService->getAll();
        
        $this->view->assign('slider',$sliders);
        $this->view->assign('photoDimension',$photoDimension);
        $this->view->assign('photoDimensionWidth',$photoDimensionWidth);
        
        $this->_helper->viewRenderer->setResponseSegment('slider');
        
    }
    
     public function mainAction() {
        $productService = $this->_service->getService('Product_Service_Product');
        $photoDimensionService = $this->_service->getService('Default_Service_PhotoDimension');
        
        $photoDimension = $photoDimensionService->getElementDimension('slider');
        
        $products = $productService->getSliderProducts();
        $this->view->assign('photoDimension',$photoDimension);
        $this->view->assign('products',$products);
        $this->_helper->viewRenderer->setResponseSegment('slider');
        
    }
    
    
   
}
