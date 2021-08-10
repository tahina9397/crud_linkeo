<?php
 
/**
 * Override Zend_Validate_EmailAddress so that only one error message shows when there is a problem
 */
class Application_Validate_EmailAddress extends Zend_Validate_EmailAddress
{

  /**
   * Returns true if and only if $value is a valid email address
   * according to RFC2822
   * @param string $value
   * @return boolean
   */
  public function isValid($value)
  {
    $response = parent::isValid(trim($value));
    if (!$response){
      $this->_messages = array(self::INVALID => $this->getTranslator()->translate("adresse invalide"));
    }
    return $response;
  }
}