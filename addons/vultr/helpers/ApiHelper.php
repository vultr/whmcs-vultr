<?php

namespace MGModule\vultr\helpers;

use WHMCS\Database\Capsule as DB;
use MGModule\vultr\helpers\PathHelper;

class ApiHelper
{

	public static function getAPI($token = null)
	{
		self::getAPIFiles();
		if ($token === null)
		{
			$apiObject = new \VultrAPI(self::getAPIToken());
		}
		else
		{
			$apiObject = new \VultrAPI($token);
		}
		return $apiObject;
	}

	private static function getAPIFiles()
	{
		$whmcsPath = PathHelper::getWhmcsPath();
		$apiFile = $whmcsPath . "/modules/servers/vultr/vendor/VultrAPI.php";
		include $apiFile;
	}

	private static function getAPIToken()
	{
		$token = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'apiToken'],
		])->first();

		return $token->value;
	}

}
