<?php

namespace MGModule\vultr\models\location;

use MGModule\vultr\helpers\ApiHelper;
use WHMCS\Database\Capsule as DB;

class Repository extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\location';
	}

	public function getLocationList()
	{
		$api = ApiHelper::getAPI();
		return $api->regions_list();
	}

	public function changeLocationSettings($input)
	{
		$settingArray = $this->getLocationSettings();

		if (array_key_exists((int)$input, $settingArray))
		{
			unset($settingArray[$input]);
		}
		else
		{
			$settingArray[$input] = "disable";
		}

		$this->saveLocationSettings($settingArray);
	}

	public function getLocationSettings()
	{
		$locationSettings = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'locationSettings'],
		])->first();
		return unserialize($locationSettings->value);
	}

	private function saveLocationSettings($lcoationArray = [])
	{
		DB::table('tbladdonmodules')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'locationSettings'],
		])->update([
			'value' => serialize($lcoationArray),
		]);
	}

}
