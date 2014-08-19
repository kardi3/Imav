<?php

/**
 * Offer_Service_Deal
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Offer_Service_Deal extends MF_Service_ServiceAbstract {
    
    public static $initialMessageTitleFormat = "Użytkownik %s odpowiedział na Twoje ogłoszenie";
    public static $initialMessageContentFormat = "Oferta użytkownika %s: \n%s \n%s \n%s";
    
    public static $dealAgentEmailSubjectSendFormat = "Odpowiedziałeś na ogłoszenie \"%s\"";
    public static $dealAgentEmailSubjectRecieveFormat = "Otrzymałeś odpowiedź na swoją ofertę \"%s\"";
    public static $dealAgentEmailBodySendFormat = "%s";
    public static $dealAgentEmailBodyRecieveFormat = "%s";
    
    public static $dealClientEmailSubjectSendFormat = "Odpowiedziałeś na ofertę \"%s\"";
    public static $dealClientEmailSubjectRecieveFormat = "Otrzymałeś odpowiedź na swoje ogłoszenie \"%s\"";
    public static $dealClientEmailBodySendFormat = "%s";
    public static $dealClientEmailBodyRecieveFormat = "%s";
    
    public static $dealClientEmailSubjectFormat = "Otrzymałeś odpowiedź na Twoje ogłoszenie %s";
    public static $dealAgentEmailContentForm = "Odpowiedziałeś na ogłoszenie użytkownika %s \n%s";
    public static $dealClientEmailContentForm = "Odpowiedziałeś na ogłoszenie użytkownika %s \n%s";
    
    public static $cardMessageFormat = "Użytkownik %s wysłał Ci swoją wizytówkę \n%s";
    
    protected $dealTable;
    protected $dealMessageTable;
    
    public function init() {
        $this->dealTable = Doctrine_Core::getTable('Offer_Model_Doctrine_Deal');
        $this->dealMessageTable = Doctrine_Core::getTable('Offer_Model_Doctrine_DealMessage');
        parent::init();
    }
    
    public function dealExists($offer, $notice) {
        $query = $this->dealTable->getQueryWithOfferAndNoticeByOfferIdAndNoticeId($offer->getId(), $notice->getId());
        $query->andWhere('d.status > ?', MF_Code::STATUS_REJECTED);
        return $query->count();
    }
    
    public function getDeal($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $query = $this->dealTable->getQueryWithMessages();
        $query->andWhere('d.' . $field .' = ?', $id);
        $query->addOrderBy('d.created_at DESC');
        return $query->fetchOne(array(), $hydrationMode);
    }
    
    public function findDeal(Offer_Model_Doctrine_Offer $offer, Offer_Model_Doctrine_Notice $notice, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $query = $this->dealTable->getQueryWithOfferAndNoticeByOfferIdAndNoticeId($offer->getId(), $notice->getId());
        return $query->fetchOne(array(), $hydrationMode);
    }
    
    public function getOfferDeal($offerId, $dealId, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $query = $this->dealTable->getQueryWithMessagesByOfferIdAndDealId($offerId, $dealId);
        return $query->fetchOne(array(), $hydrationMode);
    }
    
    public function getNoticeDeal($noticeId, $dealId, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $query = $this->dealTable->getQueryWithMessagesByNoticeIdAndDealId($noticeId, $dealId);
        return $query->fetchOne(array(), $hydrationMode);
    }
    
    public function getLastNoticeDeal($noticeId, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $query = $this->dealTable->getQueryWithMessages($noticeId);
        $query->andWhere('d.notice_id = ?', $noticeId);
        $query->addOrderBy('d.created_at DESC');
        $query->limit(1);
        return $query->fetchOne(array(), $hydrationMode);
    }
    
    public function getDealMessage($dealMessageId, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $query = $this->dealMessageTable->getDealMessageQuery();
        $query->andWhere('dm.id = ?', $dealMessageId);
        return $query->fetchOne(array(), $hydrationMode);
    }
    
    public function updateDealMessageStatus(Offer_Model_Doctrine_DealMessage $dealMessage, $status) {
        $dealMessage->setStatus($status);
        $dealMessage->save();
        return $dealMessage;
    }
    
    public function getDealMessageForm(Offer_Model_Doctrine_DealMessage $message = null) {
        $form = new Offer_Form_DealMessage();
        if(null != $message) {
            $form->populate($message->toArray());
        }
        return $form;
    }
    
    public function getDealPaginationQuery($offerId = null, $noticeId = null) {
        $q = $this->dealTable->getQueryWithMessages();
        if(null != $offerId) {
            $q->andWhere('d.offer_id = ?', $offerId);
        }
        if(null != $noticeId) {
            $q->andWhere('d.notice_id = ?', $noticeId);
        }
        $q->orderBy('d.created_at DESC');
        $q->andWhere('d.status > ?', MF_Code::STATUS_REJECTED);
        return $q;
    }
    
    public function getDealMessagePaginationQuery($dealId) {
        $q = $this->dealMessageTable->getDealMessageQuery();
        $q->andWhere('dm.deal_id = ?', $dealId);
        $q->orderBy('dm.created_at DESC');
        return $q;
    }
    
    public function createDeal(Offer_Model_Doctrine_Offer $offer, Offer_Model_Doctrine_Notice $notice) {
        if(!$deal = $this->findDeal($offer, $notice)) {
            $deal = $this->dealTable->getRecord();
            $deal->set('Offer', $offer);
            $deal->set('Notice', $notice);
            $deal->setStatus(MF_Code::STATUS_NEW);
            $deal->save();
        }
        return $deal;
    }
    
    public function createMessage(Offer_Model_Doctrine_Deal $deal, $recipient, $title, $content) {
        $message = $this->dealMessageTable->getRecord();
        $message->set('Deal', $deal);
        $message->setRecipient($recipient);
        $message->setTitle($title);
        $message->setContent($content);
        $message->setStatus(MF_Code::STATUS_NEW);
        $message->save();
        return $message;
    }
    
    public function createMessageTitle($offerOrNotice) {
        return sprintf(self::$initialMessageTitleFormat, $offerOrNotice->get('User')->getFirstName() . ' ' . $offerOrNotice->get('User')->getLastName());
    }
    
    public function createMessageContent($offerOrNotice) {
        $parameters = array();
        foreach($offerOrNotice['Parameters'] as $parameter) {
            if(strlen($parameter->getValueTo())) {
                $parameters[] = $parameter['ParameterTemplate']['name'] . ': ' . $parameter['value'] . ' - ' . $parameter['value_to'];
            } else {
                $parameters[] = $parameter['ParameterTemplate']['name'] . ': ' . $parameter['value'];
            }
        }
        $parameterString = implode(', ', $parameters);
        
        return sprintf(self::$initialMessageContentFormat, $offerOrNotice['User']['first_name'] . ' ' . $offerOrNotice['User']['last_name'], $offerOrNotice['title'], $parameterString, $offerOrNotice['content']);
    }
    
    public function sendDealMessageAgentEmail(Offer_Model_Doctrine_Deal $deal, $message) {
        $serviceBroker = $this->getServiceBroker();
        $view = $serviceBroker->get('view');
        $mail = new Zend_Mail('UTF-8');
        $offer = $deal->get('Offer');
        $notice = $deal->get('Notice');
        $subject = $message->getRecipient() == Offer_Model_Doctrine_DealMessage::RECIPIENT_CLIENT ? sprintf(self::$dealAgentEmailSubjectSendFormat, $notice->getTitle()) : sprintf(self::$dealAgentEmailSubjectRecieveFormat, $offer->getTitle());
        if($message instanceof Offer_Model_Doctrine_DealMessage) {
            $body = $message->getRecipient() == Offer_Model_Doctrine_DealMessage::RECIPIENT_CLIENT ? sprintf(self::$dealAgentEmailBodySendFormat, $message->getContent()) : sprintf(self::$dealAgentEmailBodyRecieveFormat, $message->getContent());
        } elseif(is_string($message)) {
            $body = $message;
        }
        $body = nl2br($body);
        $mail->setSubject($subject);
        $mail->setBodyHtml($body);
        $mail->addTo($offer->get('User')->getEmail(), $offer->get('User')->getFirstName() . ' ' . $offer->get('User')->getLastName());
        $mail->send();
    }
    
    public function sendDealMessageClientEmail(Offer_Model_Doctrine_Deal $deal, $message) {
        $serviceBroker = $this->getServiceBroker();
        $view = $serviceBroker->get('view');
        $mail = new Zend_Mail('UTF-8');
        $offer = $deal->get('Offer');
        $notice = $deal->get('Notice');
        $subject = $message->getRecipient() == Offer_Model_Doctrine_DealMessage::RECIPIENT_AGENT ? sprintf(self::$dealClientEmailSubjectSendFormat, $offer->getTitle()) : sprintf(self::$dealClientEmailSubjectRecieveFormat, $notice->getTitle());
        if($message instanceof Offer_Model_Doctrine_DealMessage) {
            $body = $message->getRecipient() == Offer_Model_Doctrine_DealMessage::RECIPIENT_AGENT ? sprintf(self::$dealClientEmailBodySendFormat, $message->getContent()) : sprintf(self::$dealClientEmailBodyRecieveFormat, $message->getContent());
        } elseif(is_string($message)) {
            $body = $message;
        }
        $body = nl2br($body);
        $mail->setSubject($subject);
        $mail->setBodyHtml($body);
        $mail->addTo($notice->get('User')->getEmail(), $notice->get('User')->getFirstName() . ' ' . $notice->get('User')->getLastName());
        $mail->send();
    }
    
    public function sendStatusUpdateNotification(Offer_Model_Doctrine_Deal $deal, $status) {
        switch($status) {
            case MF_Code::STATUS_OBSERVED:
                $recipient = Offer_Model_Doctrine_DealMessage::RECIPIENT_AGENT;
                $title = sprintf(self::$dealAgentEmailSubjectRecieveFormat, $deal->get('Offer')->getTitle());
                $content = $this->createCardContent($deal->get('Notice')->get('User'));
                $message = $this->createMessage($deal, $recipient, $title, $content);
                $this->sendDealMessageAgentEmail($deal, $message);
                break;
        }
    }
    
    public function sendCard(Offer_Model_Doctrine_Deal $deal, $recipient) {
        switch($recipient) {
            case Offer_Model_Doctrine_DealMessage::RECIPIENT_AGENT:
                $title = sprintf(self::$dealAgentEmailSubjectRecieveFormat, $deal->get('Offer')->getTitle());
                $content = sprintf(self::$cardMessageFormat, $deal->get('Offer')->get('User')->getFirstName() . ' ' . $deal->get('Offer')->get('User')->getLastName(), $this->createCardContent($deal->get('Notice')->get('User')));
                $message = $this->createMessage($deal, $recipient, $title, $content);
                $this->sendDealMessageAgentEmail($deal, $message);
                break;
            case Offer_Model_Doctrine_DealMessage::RECIPIENT_CLIENT:
                $title = sprintf(self::$dealClientEmailSubjectSendFormat, $deal->get('Notice')->getTitle());
                $content = $this->createCardContent($deal->get('Offer')->get('User'));
                $message = $this->createMessage($deal, $recipient, $title, $content);
                $this->sendDealMessageClientEmail($deal, $message);
                break;
        }
    }
    
    public function createCardContent(User_Model_Doctrine_User $user) {
        $view = $this->getServiceBroker()->get('view');
        $content = $view->partial('card.phtml', 'offer', array('user' => $user));
        return $content;
    }
}

