<?php

namespace MGModule\vultr\mgLibs\process;

use MGModule\vultr as main;

/**
 * Description of mainController
 *
 * @SuppressWarnings(PHPMD)
 */
class MainInstance
{
	/**
	 *
	 * @var abstractMainDriver
	 */
	static private $_instanceName;

	public static function setInstanceName($instance)
	{
		self::$_instanceName = $instance;
	}

	public static function __callStatic($name, $arguments)
	{
		return call_user_func(array(self::$_instanceName, $name), $arguments);
	}

	/**
	 *
	 * @return main\mgLibs\process\AbstractMainDriver
	 * @throws exceptions\System
	 */
	static function I()
	{
		if (empty(self::$_instanceName))
		{
			throw new main\mgLibs\exceptions\System('Instance is not set');
		}
		return call_user_func(array(self::$_instanceName, 'I'));
	}
}
