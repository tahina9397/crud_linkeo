<?php
class Application_Validate_PasswordMustContainNumber extends Zend_Validate_Abstract
{
    const INVALID_MSG = '';

    protected $_messageTemplates = array(
        self::INVALID_MSG => "doit contenir au moins 1 chiffre"
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
         $this->_setValue($value);

        if ( preg_match("#[0-9]+#", $value) ) {
            return true ;
        }

        $this->_error(self::INVALID_MSG); 
        return false;
    }
}