<?php

namespace MGModule\vultr\models\addonConfiguration;

use WHMCS\Database\Capsule as DB;

/**
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{

	public function getModelClass()
	{
		return __NAMESPACE__ . '\addonConfiguration';
	}

	public function createAddonFields()
	{
		$this->createNameServers();
		$this->createLocation();
		$this->createIsoSetting();
		$this->createSnapSetting();
		$this->createTables();
	}

	private function createNameServers()
	{
		$nameServers = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'nameServers'],
		])->first();

		if (empty($nameServers))
		{
			$ns = [
				'ns1' => 'ns1.vultr.com',
				'ns2' => 'ns2.vultr.com',
			];
			DB::table('tbladdonmodules')->insert([
				'module' => 'vultr',
				'setting' => 'nameServers',
				'value' => serialize($ns),
			]);
		}
		return;
	}

	private function createLocation()
	{
		$nameServers = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'locationSettings'],
		])->first();

		if (empty($nameServers))
		{
			DB::table('tbladdonmodules')->insert([
				'module' => 'vultr',
				'setting' => 'locationSettings',
				'value' => '',
			]);
		}
		return;
	}

	private function createIsoSetting()
	{
		$isoSetting = DB::table("tbladdonmodules")->select("tbladdonmodules.value")
			->where("tbladdonmodules.module", "=", "vultr")->where("tbladdonmodules.setting", "=", "isoSettings")->first();

		if (empty($isoSetting))
		{
			DB::table('tbladdonmodules')->insert([
				'module' => 'vultr',
				'setting' => 'isoSettings',
				'value' => '',
			]);
		}
		return;
	}

	private function createSnapSetting()
	{
		$snapSettings = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'snapshotsSettings'],
		])->first();

		if (empty($snapSettings))
		{
			DB::table('tbladdonmodules')->insert([
				'module' => 'vultr',
				'setting' => 'snapshotsSettings',
				'value' => '',
			]);
		}
		return;
	}

	public function createTables()
	{
		if (!DB::schema()->hasTable('vultr_sshkeys'))
		{
			DB::schema()->create(
				'vultr_sshkeys', function ($table){
				$table->integer('client_id');
				$table->string('SSHKEYID');
			}
			);
		}
		if (!DB::schema()->hasTable('vultr_snapshots'))
		{
			DB::schema()->create(
				'vultr_snapshots', function ($table){
				$table->increments('id');
				$table->integer('client_id');
				$table->integer('service_id');
				$table->string('SNAPSHOTID');
				$table->integer('SUBID');
			}
			);
		}
		if (!DB::schema()->hasTable('vultr_scripts'))
		{
			DB::schema()->create(
				'vultr_scripts', function ($table){
				$table->integer('client_id');
				$table->integer('SCRIPTID');
				$table->string('type');
			}
			);
		}
		if (!DB::schema()->hasTable('vultr_dns'))
		{
			DB::schema()->create(
				'vultr_dns', function ($table){
				$table->integer('client_id');
				$table->integer('service_id');
				$table->string('domain');
			}
			);
		}
		if (!DB::schema()->hasTable('vultr_revdns'))
		{
			DB::schema()->create(
				'vultr_revdns', function ($table){
				$table->integer('client_id');
				$table->integer('service_id');
				$table->text('updated');
				$table->text('reverse');
			}
			);
		}
	}

	public function delteAddonfields()
	{
		$this->deleteNameServers();
		$this->deleteLocation();
		$this->deleteIsoSetting();
		$this->deleteSnapSettings();
		$this->removeTables();
	}

	private function deleteNameServers()
	{
		$nameServers = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'nameServers'],
		])->first();

		if (!empty($nameServers))
		{
			DB::table('tbladdonmodules')->where([
				['module', '=', 'vultr'],
				['setting', '=', 'nameServers'],
			])->delete();
		}
		return;
	}

	private function deleteLocation()
	{
		$nameServers = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'locationSettings'],
		])->first();

		if (!empty($nameServers))
		{
			DB::table('tbladdonmodules')->where([
				['module', '=', 'vultr'],
				['setting', '=', 'locationSettings'],
			])->delete();
		}
		return;
	}

	private function deleteIsoSetting()
	{
		$isoSettings = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'isoSettings'],
		])->first();

		if (!empty($isoSettings))
		{
			DB::table('tbladdonmodules')->where([
				['module', '=', 'vultr'],
				['setting', '=', 'isoSettings'],
			])->delete();
		}
		return;
	}

	private function deleteSnapSettings()
	{
		$snapSettings = DB::table('tbladdonmodules')->select('value')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'snapshotsSettings'],
		])->first();

		if (!empty($snapSettings))
		{
			DB::table('tbladdonmodules')->where([
				['module', '=', 'vultr'],
				['setting', '=', 'snapshotsSettings'],
			])->delete();
		}
		return;
	}

	public function removeTables()
	{
		if (DB::schema()->hasTable('vultr_sshkeys'))
		{
			DB::schema()->drop('vultr_sshkeys');
		}
		if (DB::schema()->hasTable('vultr_snapshots'))
		{
			DB::schema()->drop('vultr_snapshots');
		}
		if (DB::schema()->hasTable('vultr_scripts'))
		{
			DB::schema()->drop('vultr_scripts');
		}
		if (DB::schema()->hasTable('vultr_dns'))
		{
			DB::schema()->drop('vultr_dns');
		}
		if (DB::schema()->hasTable('vultr_revdns'))
		{
			DB::schema()->drop('vultr_revdns');
		}
	}

}
