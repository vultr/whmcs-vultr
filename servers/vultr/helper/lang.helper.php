<?php

class LangHelper
{

	private static $instance;
	public $context = array();
	private $dir;
	private $langs = array();
	private $currentLang;

	public static function T($key = null, $var = false)
	{
		$lang = self::getInstance(VULTRDIR . 'lang')->langs;
		if ($key == null)
		{
			return $lang;
		}
		$keyPath = explode('.', $key);
		foreach ($keyPath as $key)
		{
			if (isset($lang[$key]))
			{
				$lang = str_replace('%var%', $var, $lang[$key]);
			}
			else
			{
				return '';
			}
		}
		return $lang;
	}

	public static function getInstance($dir = null, $lang = null)
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
			self::$instance->dir = $dir;
			self::$instance->loadLang('english');
			if (!$lang)
			{
				$lang = self::getLang();
			}

			if ($lang && $lang != 'english')
			{
				self::$instance->loadLang($lang);
			}
		}
		return self::$instance;
	}

	public static function loadLang($lang)
	{
		$file = self::getInstance()->dir . DS . $lang . '.php';
		if (file_exists($file))
		{
			include $file;
			self::getInstance()->langs = array_merge(self::getInstance()->langs, $_LANG);
			self::getInstance()->currentLang = $lang;
		}
	}

	public static function getLang()
	{
		$language = '';
		if (isset($_SESSION['Language']))
		{
			$language = strtolower($_SESSION['Language']);
		}
		elseif (isset($_SESSION['uid']))
		{
			$q = PDOWrapper::query("SELECT language FROM tblclients WHERE id = :uid", array('uid'=>$_SESSION['uid']));
			$row = PDOWrapper::fetch_assoc($q);
			if ($row['language'])
			{
				$language = $row['language'];
			}
		}

		if (!$language)
		{
			$q = PDOWrapper::query("SELECT value FROM tblconfiguration WHERE setting = 'Language' LIMIT 1");
			$row = PDOWrapper::fetch_assoc($q);
			$language = $row['value'];
		}

		if (!$language)
		{
			$language = 'english';
		}

		return strtolower($language);
	}
}
