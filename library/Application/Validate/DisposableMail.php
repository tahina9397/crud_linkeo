<?php
use EmailChecker\EmailChecker;

class Application_Validate_DisposableMail extends Zend_Validate_Abstract
{
    const INVALID_LINK = '';

    protected $_messageTemplates = array(
        // self::INVALID_LINK => "vous utilisez une adresse mail temporaire ou l'utilisation de ce domaine n'est pas autorisé"
        self::INVALID_LINK => "vous utilisez une adresse mail temporaire"
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
        $this->_setValue($value);

        $checker = new EmailChecker();
        $error = $checker->isValid($value);
        
        if ($error)
            return true;
    
        $this->_error(self::INVALID_LINK); 
        return false;
    }
}