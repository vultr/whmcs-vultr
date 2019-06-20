<?php

namespace MGModule\vultr\models\dns;

use WHMCS\Database\Capsule as DB;

class Repository extends \MGModule\vultr\mgLibs\models\Repository
{

	public function getModelClass()
	{
		return __NAMESPACE__ . '\dns';
	}

	public function getNameServers()
	{
		$nameServers = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'nameServers'],
		])->first();

		if (!empty($nameServers))
		{
			return unserialize($nameServers->value);
		}
		return;
	}

	public function updateNameServers($params = [])
	{
		return DB::table('tbladdonmodules')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'nameServers'],
		])->update([
			'value' => serialize($params),
		]);
	}

}
