<?php
namespace MGModule\vultr\models\whmcs\errors;
use MGModule\vultr as main;

/**
 * Register Error in WHMCS Module Log
 *
 * @SuppressWarnings(PHPMD)
 */
class Register extends main\mgLibs\models\Orm
{
	/**
	 * Register Exception in WHMCS Module Log
	 *
	 * @param Exception $ex
	 */
	static function register($ex)
	{
		$token = 'Unknow Token';

		if (method_exists($ex, 'getToken'))
		{
			$token = $ex->getToken();
		}

		$debug = print_r($ex, true);

		\logModuleCall("MGError", __NAMESPACE__, array('message' => $ex->getMessage(), 'code' => $ex->getCode(), 'token' => $token), $debug, 0, 0);
	}
}
