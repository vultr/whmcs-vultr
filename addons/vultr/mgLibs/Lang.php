<?php

namespace MGModule\vultr\mgLibs;

/**
 * Simple class to translating languages
 *
 * @SuppressWarnings(PHPMD)
 */
class Lang
{

	/**
	 *
	 * @var \MGModule\vultr\Lang
	 */
	private static $instance;
	public $context = array();
	private $dir;
	/**
	 *
	 * @var Array
	 */
	private $langs = array();
	private $currentLang;
	private $fillLangFile = true;
	private $staggedContext = array();
	private $missingLangs = array();

	private function __construct()
	{

	}

	public static function getMissingLangs()
	{
		return self::$instance->missingLangs;
	}

	/**
	 * Get Avaiable Translations
	 *
	 * @return type
	 */
	public static function getAvaiable()
	{
		$langArray = array();
		$handle = opendir(self::$instance->dir);

		while (false !== ($entry = readdir($handle)))
		{
			list($lang, $ext) = explode('.', $entry);
			if ($lang && isset($ext) && strtolower($ext) == 'php')
			{
				$langArray[] = $lang;
			}
		}

		return $langArray;
	}

	/**
	 * Set Lang Context
	 *
	 * Given parameters are lang levels
	 */
	public static function setContext()
	{
		self::getInstance()->context = array();
		foreach (func_get_args() as $name)
		{
			self::getInstance()->context[] = $name;
		}
	}

	/**
	 * Get Single-ton Instance
	 *
	 * @param type $dir
	 * @param type $lang
	 * @return \MGModule\vultr\Lang
	 */
	public static function getInstance($dir = null, $lang = null)
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
			self::$instance->dir = $dir;
			self::$instance->loadLang('english');

			self::$instance->fillLangFile = process\MainInstance::I()->isDebug();

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

	/**
	 * Load Lang File
	 *
	 * @param string $lang Lang Name
	 */
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

	/**
	 * Get Current Lang Name
	 *
	 * @return string
	 */
	public static function getLang()
	{
		//TODO
		$language = '';
		if (isset($_SESSION['Language'])) // GET LANG FROM SESSION
		{
			$language = strtolower($_SESSION['Language']);
		}
		elseif (isset($_SESSION['uid']))
		{
			$row = MySQL\Query::query("SELECT language FROM tblclients WHERE id = :uid", array('uid'=>$_SESSION['uid']))->fetch();
			if ($row['language'])
			{
				$language = $row['language'];
			}
		}

		if (!$language)
		{
			$row = MySQL\Query::query("SELECT value FROM tblconfiguration WHERE setting = 'Language' LIMIT 1")->fetch();
			$language = $row['value'];
		}

		if (!$language)
		{
			$language = 'english';
		}


		return strtolower($language);
	}

	/**
	 * Add levels at stack upwards
	 *
	 * Given parameters are lang levels
	 */
	public static function addToContext()
	{
		foreach (func_get_args() as $name)
		{
			self::getInstance()->context[] = $name;
		}
	}

	/**
	 * Stag Current levels stack
	 *
	 * @param string $stagName
	 */
	public static function stagCurrentContext($stagName)
	{
		self::getInstance()->staggedContext[$stagName] = self::getInstance()->context;
	}

	/**
	 * Restore Lang levels from stag
	 *
	 * @param string $stagName
	 */
	public static function unstagContext($stagName)
	{
		if (isset(self::getInstance()->staggedContext[$stagName]))
		{
			self::getInstance()->context = self::getInstance()->staggedContext[$stagName];
			unset(self::getInstance()->staggedContext[$stagName]);
		}
	}

	/**
	 * Get Translated Lang
	 *
	 * @return string
	 */
	public static function T()
	{
		$lang = self::getInstance()->langs;

		$history = array();

		foreach (self::getInstance()->context as $name)
		{
			if (isset($lang[$name]))
			{
				$lang = $lang[$name];
			}
			$history[] = $name;
		}

		$returnLangArray = false;

		foreach (func_get_args() as $find)
		{
			$history[] = $find;
			if (isset($lang[$find]))
			{
				if (is_array($lang[$find]))
				{
					$lang = $lang[$find];
				}
				else
				{
					return htmlentities($lang[$find]);
				}
			}
			else
			{

				if (self::getInstance()->fillLangFile)
				{
					$returnLangArray = true;
				}
				else
				{
					return htmlentities($find);
				}
			}
		}

		if ($returnLangArray)
		{

			self::getInstance()->missingLangs['$' . "_LANG['" . implode("']['", $history) . "']"] = ucfirst(end($history));
			return '$' . "_LANG['" . implode("']['", $history) . "']";
		}

		if (is_array($lang) && self::getInstance()->fillLangFile)
		{
			self::getInstance()->missingLangs['$' . "_LANG['" . implode("']['", $history) . "']"] = implode(" ",
				array_slice($history,
					-3,
					3,
					true));
			return '$' . "_LANG['" . implode("']['", $history) . "']";
		}

		return htmlentities($find);
	}

	/**
	 * Get Translated Absolute Lang
	 *
	 * @return string
	 */
	public static function absoluteT()
	{
		$lang = self::getInstance()->langs;

		$returnLangArray = false;

		foreach (func_get_args() as $find)
		{
			$history[] = $find;
			if (isset($lang[$find]))
			{
				if (is_array($lang[$find]))
				{
					$lang = $lang[$find];
				}
				else
				{
					return htmlentities($lang[$find]);
				}
			}
			else
			{

				if (self::getInstance()->fillLangFile)
				{
					$returnLangArray = true;
				}
				else
				{
					return htmlentities($find);
				}
			}
		}

		if ($returnLangArray)
		{
			self::getInstance()->missingLangs['$' . "_LANG['" . implode("']['", $history) . "']"] = implode(" ",
				array_slice($history,
					-3,
					3,
					true));
			return '$' . "_LANG['" . implode("']['", $history) . "']";
		}

		return htmlentities($lang);
	}

	private function __clone()
	{

	}
}
