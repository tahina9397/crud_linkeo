<?php
class Application_Validate_PasswordStrength extends Zend_Validate_Abstract
{
    const INVALID_MSG = '';
    const LENGTH = 'length';
    const UPPER  = 'upper';
    const LOWER  = 'lower';
    const DIGIT  = 'digit';

    protected $_messageTemplates = array(
        self::LENGTH => "au moins 08 caractères" ,
        self::UPPER  => "doit contenir au moins un caractère majuscule",
        self::LOWER  => "doit contenir au moins un caractère minuscule",
        self::DIGIT  => "doit contenir au moins un chiffre"
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
        $this->_setValue($value);

        $isValid = true;

        if (strlen($value) < 8) {
            $this->_error(self::LENGTH);
            $isValid = false;
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $this->_error(self::UPPER);
            $isValid = false;
        }

        if (!preg_match('/[a-z]/', $value)) {
            $this->_error(self::LOWER);
            $isValid = false;
        }

        if (!preg_match('/\d/', $value)) {
            $this->_error(self::DIGIT);
            $isValid = false;
        }

        return $isValid;
    }
}