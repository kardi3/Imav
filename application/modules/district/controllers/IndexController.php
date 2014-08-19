<?php

/**
 * News_IndexController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class District_IndexController extends MF_Controller_Action {
 
    
    public function calendarAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $table = Doctrine_Core::getTable('District_Model_Doctrine_Event');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'District_DataTables_Event', 
            'columns' => array('x.id','xt.title', 'x.created_at','x.updated_at','x.publish_date'),
            'searchFields' => array('x.id','xt.title','x.created_at','x.updated_at','x.publish_date')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row['date'] = $result['publish_date'];
            $row['type'] = 'meeting';
            $row['title'] = $result['Translation'][$this->language]['title'];;
            $row['description'] = $result['Translation'][$this->language]['content'];;
           
           
            $rows[] = $row;
        }
        
        $this->view->assign('data',json_encode($rows));
        
        
        $this->_helper->viewRenderer->setResponseSegment('calendar');

    }
    
    public function articlesAction() {
    
    
    }
    public function specialTopicAction(){
        $eventService = $this->_service->getService('District_Service_Event');
        
        $nextEvent = $eventService->getNextEvent();
        $this->view->assign('nextEvent',$nextEvent);
        
        
        $this->_helper->viewRenderer->setResponseSegment('specialTopic');
    }
    
     public function randomPersonAction(){
        $peopleService = $this->_service->getService('District_Service_People');
        
        $person = $peopleService->getRandomPerson();
        $this->view->assign('person',$person);
        
        
        $this->_helper->viewRenderer->setResponseSegment('randomPerson');
    }
    
    public function showPersonAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        
        if(!$person = $peopleService->getFullPerson($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Person not found', 404);
        }
        
        
        $metatagService->setViewMetatags($person->get('Metatags'), $this->view);
       
        $this->view->assign('person', $person);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
    public function peopleListAction(){
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('article');
        
         $peopleService = $this->_service->getService('District_Service_People');
        
        
        if(!$people = $peopleService->getAllPeople($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Person not found', 404);
        }
        
        $this->view->assign('people', $people);
        
    }
}

