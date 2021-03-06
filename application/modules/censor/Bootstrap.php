<?php

/**
 * Bootstrap
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_Bootstrap extends Zend_Application_Module_Bootstrap {
    
    protected function _initModel() {
        Doctrine_Core::loadModels(APPLICATION_PATH . '/modules/censor/models/Doctrine', Doctrine_Core::MODEL_LOADING_CONSERVATIVE, $this->getModuleName() . '_Model_Doctrine_');
    }
	
    protected function _initModuleAutoloader() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/censor',
            'namespace' => '',
            'resourceTypes' => array(
                'library' => array(
                    'path' => 'library/',
                    'namespace' => 'Censor'
                )
            )
        ));
    }
    
}

