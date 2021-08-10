<?php
class Application_Validate_Url extends Zend_Validate_Abstract
{
    const INVALID_LINK = '';

    protected $_messageTemplates = array(
        self::INVALID_LINK => "URL invalide"
    );

    public function __construct()
    {
    }

    public function isValid($value, $context=null)
    {
        $this->_setValue($value);

        $url = filter_var(trim("http://".$value), FILTER_SANITIZE_URL);

        $headers = get_headers($url, 1) ;

        if($headers && strpos( $headers[1], '200'))
            return true ;
    
        $this->_error(self::INVALID_LINK); 
        return false;
    }
}