<?php
class Application_Validate_PasswordMustContainUppercaseCharacter extends Zend_Validate_Abstract
{
    const INVALID_MSG = '';

    protected $_messageTemplates = array(
        self::INVALID_MSG => "doit contenir au moins un caractère majuscule"
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
         $this->_setValue($value);

        if ( preg_match("#[A-Z]+#", $value) ) {
            return true ;
        }

        $this->_error(self::INVALID_MSG); 
        return false;
    }
}