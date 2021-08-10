<?php
class Application_Validate_PhoneNumber extends Zend_Validate_Abstract
{
    const INVALID_LINK = '';

    protected $_messageTemplates = array(
        self::INVALID_LINK => "Numéro invalide"
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
        $this->_setValue($value);

        $Member = new Application_Model_Member("member");
        $id_member = $Member->getId() ;

        $member = Application_Model_Global::pselectRow(TABLE_PREFIX.'membres','id_country',"id=:id_member",array(":id_member" => $id_member));
        $get = Application_Model_Global::pselectRow(TABLE_PREFIX.'phone_codes','id_pays',"id=:id_country",array(":id_country" => $member["id_country"]));

        $country = new Application_Class_Country();
        $isValidPhone = $country->isValidPhone($value,strtoupper($get["id_pays"]));
        
        if ($isValidPhone["bool"])
            return true;
    
        $this->_error(self::INVALID_LINK); 
        return false;
    }
}