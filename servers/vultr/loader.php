<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

defined('VULTRDIR') or define('VULTRDIR', __DIR__ . DS);
if (!function_exists('vultrClassLoader'))
{
	function vultrClassLoader($classname)
	{
		$extensions = array('.php', '.class.php', '.helper.php', '.controller.php', '.vendor.php');
		if (class_exists($classname, false))
		{
			return;
		}
		$fileClass = __DIR__ . DS . 'vendor' . DS . $classname . '.php';

		if (file_exists($fileClass) && is_readable($fileClass) && !class_exists($classname, false))
		{
			require_once($fileClass);
			return true;
		}
		$class = explode('.', strtolower(strval(strtolower(preg_replace('/([a-z])([A-Z])/', '$1.$2', $classname)))));
		$file = __DIR__;

		if (isset($class[1]))
		{
			$file .= DS . $class[1] . DS . $class[0];
		}
		else
		{
			$file .= DS . 'class' . DS . $class[0];
		}
		foreach ($extensions as $ext)
		{
			$fileClass = $file . $ext;
			if (file_exists($fileClass) && is_readable($fileClass) && !class_exists($classname, false))
			{
				require_once($fileClass);
				return true;
			}
		}
		return false;
	}

	spl_autoload_register('vultrClassLoader');

	function vultrDump($x, $die = false)
	{
		echo '###################################';
		echo '<pre>';
		var_dump($x);
		echo '</pre>';
		echo '###################################';
		if ($die)
		{
			die();
		}
	}
}
