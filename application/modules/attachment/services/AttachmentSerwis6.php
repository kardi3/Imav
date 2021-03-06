<?php

/**
 * Attachment_Service_AttachmentSerwis6
 *
@author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Attachment_Service_AttachmentSerwis6 extends MF_Service_ServiceAbstract {
    
    protected $attachmentTable;
    
    public $attachmentsDir;
    
    public function init() {
        $bootstrap = $this->getServiceBroker()->get('FrontController')->getParam('bootstrap');
        if(null == $this->attachmentsDir = $bootstrap->getOption('attachmentsDir')) {
            throw new Zend_Controller_Action_Exception('Attachments directory configuration missing');
        }
        $this->attachmentTable = Doctrine_Core::getTable('Attachment_Model_Doctrine_AttachmentSerwis6');
        parent::init();
    } 
    
    public function getAttachment($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->attachmentTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getFullAttachment($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) { 
        $q = $this->attachmentTable->getAttachmentQuery();
        $q->andWhere('at.' . $field . ' = ?', $id);
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getAttachmentForm(Attachment_Model_Doctrine_AttachmentSerwis6 $attachment = null) {
        $form = new Attachment_Form_Attachment();
        if(null != $attachment) { 
            $form->populate($attachment->toArray());
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('title')->setValue($attachment->Translation[$language]->title);
                    $i18nSubform->getElement('description')->setValue($attachment->Translation[$language]->description);
                }
            }
        }
        return $form;
    }
    
    public function saveAttachmentFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$attachment = $this->getAttachment((int) $values['id'])) {
            $attachment = $this->attachmentTable->getRecord();
        }
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $attachment->fromArray($values);
        
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['title'])) {
                $attachment->Translation[$language]->title = $values['translations'][$language]['title'];
                $attachment->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Attachment_Model_Doctrine_AttachmentSerwis6Translation', $values['translations'][$language]['title'], $attachment->getId());
                $attachment->Translation[$language]->description = $values['translations'][$language]['description'];
            }
        }

        $attachment->save();
        
        return $attachment;
    }
    
    public function createUniquefileName($fileName, $directory = null) {
        if(null == $directory) {
            $directory = $this->attachmentsDir;
        }
        if(is_dir($directory)) {
            $filePath = realpath($directory . DIRECTORY_SEPARATOR . $fileName);
            if(file_exists($filePath)) {
                $pathinfo = pathinfo($filePath);
                $name = $pathinfo['filename'];
                $ext = (isset($pathinfo['extension'])) ? $pathinfo['extension'] : '';
                $suffix = 1;
                $uniqueName = $fileName;
                do {
                    $uniqueName = $name . '-' . $suffix . '.' . $ext;
                    $suffix++;                    
                } while(file_exists($directory . DIRECTORY_SEPARATOR . $uniqueName));
                  
                return $uniqueName;
            }
            return $fileName;
        }
    }
    
    public function getExtension($fileName, $directory = null) {
        if(null == $directory) {
            $directory = $this->attachmentsDir;
        }
        if(is_dir($directory)) {
            $filePath = realpath($directory . DIRECTORY_SEPARATOR . $fileName);
            if(file_exists($filePath)) {
                $pathinfo = pathinfo($filePath);
                $extension = $pathinfo['extension'];
            }
        return $extension;
        }
     }
 
    public function createAttachmentFromUpload($uploadFileIndex, $name, $title = null, $languageAdmin) {
        $pathinfo = pathinfo($name);
        $extension = $pathinfo['extension'];
        $name = MF_Text::createSlug($name);
        $filename = $this->createUniquefileName($name);
        $title = null == $title ? pathinfo($name, PATHINFO_FILENAME) : $title;

        if(@move_uploaded_file($_FILES[$uploadFileIndex]['tmp_name'], $this->attachmentsDir . DIRECTORY_SEPARATOR . $filename)) {
//            if($this->createAttachmentFile($filename, $filename)) {
                $attachment = $this->attachmentTable->getRecord();
                $attachment->setFilename($filename);
                $attachment->Translation[$languageAdmin]->title = $title;
                $attachment->Translation[$languageAdmin]->slug = MF_Text::createUniqueTableSlug('Attachment_Model_Doctrine_AttachmentSerwis6Translation', $title, $attachment->getId());
                $attachment->setExtension($extension);
                $attachment->save();
                return $attachment;
//            }
        }
    }
    
    public function removeAttachmentFile($fileName) {
        if(file_exists($this->attachmentsDir . DIRECTORY_SEPARATOR . $fileName)) {
            @unlink($this->attachmentsDir . DIRECTORY_SEPARATOR . $fileName);
        }
        return true;
    }
    
    public function removeAttachment($attachment) {
        if(is_integer($attachment)) {
            $attachment = $this->getAttachment($attachment);
        }
        $this->removeAttachmentFile($attachment->getFilename());
        $attachment->get('Translation')->delete();
        $attachment->delete();
    }
    
    public function getAllAttachments($language, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->attachmentTable->getAttachmentQuery();
        $q->andWhere('at.lang = ?', $language);
        return $q->execute(array(), $hydrationMode);
    }
}
?>