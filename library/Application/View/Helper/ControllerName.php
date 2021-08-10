<?php
class Application_View_Helper_ControllerName extends Zend_View_Helper_Abstract
{
    public function controllerName()
    {
        return Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
}