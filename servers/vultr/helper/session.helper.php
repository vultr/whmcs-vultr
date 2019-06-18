<?php

class SessionHelper
{

	public static function setFlashMessage($type, $message)
	{
		$_SESSION['VULTR']['FLASH'][] = array('type' => $type, 'message' => $message);
	}

	public static function getFlashMessages()
	{
		if (isset($_SESSION['VULTR']['FLASH']))
		{
			$flash = $_SESSION['VULTR']['FLASH'];
			unset($_SESSION['VULTR']['FLASH']);
			return $flash;
		}
		else
		{
			return array();
		}
	}


}
