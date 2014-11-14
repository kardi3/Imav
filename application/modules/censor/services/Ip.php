<?php

/**
 * Censor
 *
 * @author Tomasz Kardas <kardi31@o2.pl>
 */
class Censor_Service_Ip extends MF_Service_ServiceAbstract {
    
    protected $ipTable;
    
    public function init() {
        $this->ipTable = Doctrine_Core::getTable('Censor_Model_Doctrine_Ip');
    }
    
    public function getIp($id, $field = 'ip', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->ipTable->findOneBy($field, $id, $hydrationMode);
    }
    
   
    
    public function getAllIps($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {

        return $this->ipTable->findAll($hydrationMode);
    }
    
    public function getIpForm(Censor_Model_Doctrine_Ip $ip = null) {
        $form = new Censor_Form_Ip();
        if(null !== $ip) {
            $form->populate($ip->toArray());
        }
        
        return $form;
    }
    
    public function saveIpFromArray(array $values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$ip = $this->getIp($values['ip'])) {
            $ip = $this->ipTable->getRecord();
        }
       
        $ip->fromArray($values);
        $ip->save();
        return $ip;
    }
    
    public function removeIp(Censor_Model_Doctrine_Ip $ip) {
        $ip->delete();
    }    
}

