<?php

class Application_View_Helper_GetTimeElapsedString extends Zend_View_Helper_Abstract
{

	public function GetTimeElapsedString($resource)
	{
		return Application__Plugin_Common::getTimeElapsedString(strtotime($resource));
	}
}