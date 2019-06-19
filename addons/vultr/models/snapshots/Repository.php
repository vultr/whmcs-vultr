<?php

namespace MGModule\vultr\models\snapshots;

use MGModule\vultr\helpers\ApiHelper;
use WHMCS\Database\Capsule as DB;

/**
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{

	public function getModelClass()
	{
		return __NAMESPACE__ . '\snapshots';
	}

	public function getSnapshotsList()
	{
		$api = ApiHelper::getAPI();
		$snapshotList = $api->snapshot_list();
		foreach ($this->getUsersSnapshots() as $value)
		{
			if (array_key_exists($value->snapshotid, $snapshotList))
			{
				$snapshotList[$value->snapshotid]['client'] = [
					'clientid' => $value->clientid,
					'clientname' => $value->firstname . " " . $value->lastname,
				];
			}
		}
		return $snapshotList;
	}

	public function getUsersSnapshots()
	{
		return DB::table('vultr_snapshots as snapshots')
			->select('client.id as clientid', 'client.firstname as firstname', 'client.lastname as lastname', 'snapshots.SNAPSHOTID as snapshotid', 'snapshots.SUBID as subid')
			->join('tblclients as client', 'snapshots.client_id', '=', 'client.id')->get();
	}

	public function changeSnapshotsSettings($id)
	{

		$settingArray = $this->getAllowSnapshots();

		if (array_key_exists($id, $settingArray))
		{
			unset($settingArray[$id]);
		}
		else
		{
			$settingArray[$id] = "enable";
		}

		$this->saveSnapshotsSettings($settingArray);
	}

	public function getAllowSnapshots()
	{
		$snapshotsSettings = DB::table('tbladdonmodules')
			->select('value')
			->where([
				['module', '=', 'vultr'],
				['setting', '=', 'snapshotsSettings'],
			])->first();
		return unserialize($snapshotsSettings->value);
	}

	private function saveSnapshotsSettings($settingArray = [])
	{
		DB::table('tbladdonmodules')->where([
			['module', '=', 'vultr'],
			['setting', '=', 'snapshotsSettings'],
		])->update([
			'value' => serialize($settingArray),
		]);
	}

}
