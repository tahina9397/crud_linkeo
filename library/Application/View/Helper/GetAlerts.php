<?php

class Application_View_Helper_GetAlerts extends Zend_View_Helper_Abstract
{

	public function GetAlerts()
	{
		return Application__Plugin_Alerts::getMessages();
	}
}