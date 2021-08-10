<?php
class Application_Validate_PasswordMustContainLowcaseCharacter extends Zend_Validate_Abstract
{
    const INVALID_MSG = '';

    protected $_messageTemplates = array(
        self::INVALID_MSG => "doit contenir au moins un caractère minuscule"
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
         $this->_setValue($value);

        if ( preg_match("#[a-z]+#", $value) ) {
            return true ;
        }

        $this->_error(self::INVALID_MSG); 
        return false;
    }
}