<?php

namespace MGModule\vultr\mgLibs\process;

use MGModule\vultr as main;

/**
 * Description of abstractController
 *
 * @SuppressWarnings(PHPMD)
 */
abstract class AbstractController
{
	public $mgToken = null;
	private $registredValidationErros = array();

	function __construct($input = array())
	{
		if (isset($input['mg-token']))
		{
			$this->mgToken = $input['mg-token'];
		}
	}

	/**
	 * Generate Token For Form
	 *
	 * @return string
	 */
	function genToken()
	{
		return md5(time());
	}

	/**
	 * Validate Token With previous checked
	 *
	 * @param string $token
	 * @return boolean
	 */
	function checkToken($token = null)
	{
		if ($token === null)
		{
			$token = $this->mgToken;
		}

		if ($_SESSION['mg-token'] === $token)
		{
			return false;
		}

		$_SESSION['mg-token'] = $token;

		return true;
	}

	function dataTablesParseRow($template, $data)
	{
		$row = main\mgLibs\Smarty::I()->view($template, $data);

		$output = array();

		if (preg_match_all('/\<td\>(?P<col>.*?)\<\/td\>/s', $row, $result))
		{
			foreach ($result['col'] as $col)
			{
				$output[] = $col;
			}
		}

		return $output;
	}

	function registerErrors($errors)
	{
		$this->registredValidationErros = $errors;
	}

	function getFieldError($field, $langspace = 'validationErrors')
	{
		if (!isset($this->registredValidationErros[$field]))
		{
			return false;
		}

		$message = array();
		foreach ($this->registredValidationErros[$field] as $type)
		{
			$message[] = main\mgLibs\Lang::absoluteT($langspace, $type);
		}

		return implode(',', $message);
	}

	public function isActive()
	{
		return true;
	}
}