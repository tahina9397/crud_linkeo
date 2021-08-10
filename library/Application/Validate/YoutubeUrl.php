<?php
class Application_Validate_YoutubeUrl extends Zend_Validate_Abstract
{
    const INVALID_LINK = '';

    protected $_messageTemplates = array(
        self::INVALID_LINK => 'Invalid Link'
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
        $this->_setValue($value);

        $error = Application_Class_Utils::checkUrlVideo($value);
        
        if ($error)
            return true;
 
        $this->_error(self::INVALID_LINK); 
        return false;
    }
}