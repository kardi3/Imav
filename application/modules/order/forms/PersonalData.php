<?php

class Order_Form_PersonalData extends Admin_Form
{
    public function init() {
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $clientType = $this->createElement('radio', 'client_type');
        $clientType->addMultiOption('person','Osoba fizyczna');
        $clientType->addMultiOption('company','Firma');
        $clientType->setDecorators(self::$textDecorators);
        $clientType->setAttrib('class', 'span8');
        $clientType->setAttrib('onclick', 'showNip(this.value);');
        
        $firstName = $this->createElement('text', 'first_name');
        $firstName->setLabel('First name');
        $firstName->setRequired();
        $firstName->addValidators(array(
            array('alnum', false, array('allowWhiteSpace' => true))
        ));
        $firstName->addFilters(array(
            array('alnum', array('allowWhiteSpace' => true))
        ));
        $firstName->setDecorators(self::$textDecorators);
        $firstName->setAttrib('class', 'span8');

        $lastName = $this->createElement('text', 'last_name');
        $lastName->setLabel('Last name');
        $lastName->setRequired();
        $lastName->addValidators(array(
            array('alnum', false, array('allowWhiteSpace' => true))
        ));
        $lastName->addFilters(array(
            array('alnum', array('allowWhiteSpace' => true))
        ));
        $lastName->setDecorators(self::$textDecorators);
        $lastName->setAttrib('class', 'span8');

       
        $email = new Glitch_Form_Element_Text_Email('email');
        $email->setLabel('Email');
        $email->setValidators(array('EmailAddress'));
        $email->setDecorators(self::$textDecorators);
        $email->setRequired();
        $email->setAttrib('class', 'span8');
        
        $street = $this->createElement('text', 'street');
        $street->setLabel('Street');
        $street->setRequired(true);
        $street->setDecorators(self::$textDecorators);
        $street->setAttrib('class', 'span8');
        
        $houseNr = $this->createElement('text', 'houseNr');
        $houseNr->setLabel('House number');
        $houseNr->setRequired(true);
        $houseNr->setDecorators(self::$textDecorators);
        $houseNr->setAttrib('class', 'span8');
        
        $phone = $this->createElement('text', 'phone');
        $phone->setLabel('Phone');
        $phone->setRequired(true);
        $phone->setDecorators(self::$textDecorators);
        $phone->addValidator('int');
        $phone->setAttrib('class', 'span8');
        
        $flatNr = $this->createElement('text', 'flatNr');
        $flatNr->setLabel('Flat number');
        $flatNr->setRequired(false);
        $flatNr->setDecorators(self::$textDecorators);
        $flatNr->setAttrib('class', 'span8');
        
        $address = $this->createElement('text', 'address');
        $address->setLabel('Address');
        $address->setRequired(true);
        $address->setDecorators(self::$textDecorators);
        $address->setAttrib('class', 'span8');
        
        $postalCode = $this->createElement('text', 'postal_code');
        $postalCode->setLabel('Kod pocztowy');
        $postalCode->setDecorators(self::$textDecorators);
        $postalCode->setRequired(true);
        $postalCode->setValidators(array('PostCode'));
        $postalCode->setAttrib('class', 'span8');
        
        $city = $this->createElement('text', 'city');
        $city->setLabel('City');
        $city->setRequired(true);
        $city->setDecorators(self::$textDecorators);
        $city->setAttrib('class', 'span8');
        
        $province = $this->createElement('select', 'province_id');
        $province->setLabel('Province');
        //$province->setRequired(true);
        $province->setDecorators(User_BootstrapForm::$bootstrapElementDecorators);
        
        $nip = $this->createElement('text', 'nip');
        $nip->setLabel('Nip');
        $nip->setDecorators(self::$textDecorators);
        $nip->setAttrib('class', 'span8'); 
        $nip->setAttrib('id','nip');
        $difAddress = $this->createElement('checkbox', 'difAddress');
        $difAddress->setLabel('Adres do wysyłki inny niż dane zamawiającego');
        $difAddress->setDecorators(User_BootstrapForm::$bootstrapElementDecorators);
        $difAddress->setAttrib('onclick','displayDifferentAddress()');
        $difAddress->setAttrib('id','difAddress');
        
        $difstreet = $this->createElement('text', 'difstreet');
        $difstreet->setLabel('Street');
        //$difstreet->setRequired(true);
        $difstreet->removeDecorator('DtDdWrapper');
        $difstreet->setAttrib('class', 'diffield');
        
        $difhouseNr = $this->createElement('text', 'difhouseNr');
        $difhouseNr->setLabel('House number');
        $difhouseNr->removeDecorator('DtDdWrapper');
        $difhouseNr->setAttrib('class', 'diffield');
        
        $difflatNr = $this->createElement('text', 'difflatNr');
        $difflatNr->setLabel('Flat number');
        $difflatNr->removeDecorator('DtDdWrapper');
        $difflatNr->setAttrib('class', 'diffield');
        
        $difaddress = $this->createElement('text', 'difaddress');
        $difaddress->setLabel('Address');
        $difaddress->removeDecorator('DtDdWrapper');
        $difaddress->setAttrib('class', 'diffield');
        
        $difpostalCode = $this->createElement('text', 'difpostal_code');
        $difpostalCode->setLabel('Kod pocztowy');
        $difpostalCode->removeDecorator('DtDdWrapper');
        $difpostalCode->setValidators(array('PostCode'));
        $difpostalCode->setAttrib('class', 'diffield');
        
        $difcity = $this->createElement('text', 'difcity');
        $difcity->setLabel('City');
        $difcity->removeDecorator('DtDdWrapper');
        $difcity->setAttrib('class', 'diffield');    


        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttrib('type', 'submit');
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $clientType,
            $firstName,
            $lastName,
            $street,
            $houseNr,
            $flatNr,
            $postalCode,
            $city,
            $email,
            $phone,
            $nip,
            $difAddress,
            $difstreet,
            $difhouseNr,
            $difflatNr,
            $difpostalCode,
            $difcity,
            //$nip,
            $submit
        ));
    }
}