<?php

class Application_View_Helper_GetRandomNum extends Zend_View_Helper_Abstract
{

	public function GetRandomNum()
	{
		return Application__Plugin_Common::getRandomNum();
	}
}