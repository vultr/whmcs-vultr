<?php

use WHMCS\Database\Capsule;

class SnapshotsController extends VultrController
{

	public function __construct($params)
	{
		parent::__construct($params);
		if (!isset($this->params['customfields']['subid']) || empty($this->params['customfields']['subid']))
		{
			SessionHelper::setFlashMessage('danger', LangHelper::T('core.client.create_vm_first'));
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
		}
		if (!isset($this->params['configoptions']['snapshots']) || $this->params['configoptions']['snapshots'] <= 0)
		{
			SessionHelper::setFlashMessage('danger', LangHelper::T('snapshots.other.not_available'));
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
		}
	}

	public function indexAction()
	{
		if ($this->getVultrAPI())
		{
			$snapshots = VultrHelper::getUserServiceSnapshots($this->vultrAPI->snapshot_list(), $this->clientID, $this->serviceID);
			return array(
				'vars' => array(
					'available' => $this->params['configoptions']['snapshots'],
					'use' => count($snapshots),
					'snapshots' => $snapshots
				)
			);
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}

	public function addAction()
	{
		if (isset($_POST['vultrAddAction']))
		{
			$available = $this->params['configoptions']['snapshots'];
			if ($this->getVultrAPI())
			{
				$use = count(VultrHelper::getUserServiceSnapshots($this->vultrAPI->snapshot_list(), $this->clientID, $this->serviceID));
				if ($use >= $available)
				{
					SessionHelper::setFlashMessage('danger', LangHelper::T('snapshots.add.snapshot_limit'));
					$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Snapshots');
				}
				$response = $this->vultrAPI->snapshot_create($this->params['customfields']['subid'], VultrHelper::cleanString(filter_input(INPUT_POST, 'vultrSNAPSHOTdesc')));
				if (isset($response['SNAPSHOTID']) && $this->vultrAPI->response_code == '200')
				{
					Capsule::table('vultr_snapshots')->insert(array('SNAPSHOTID' => $response['SNAPSHOTID'], 'client_id' => $this->clientID, 'service_id' => $this->serviceID, 'SUBID' => $this->params['customfields']['subid']));
					SessionHelper::setFlashMessage('success', LangHelper::T('snapshots.add.created'));
					$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Snapshots');
				}
				SessionHelper::setFlashMessage('danger', LangHelper::T('snapshots.add.delete_error') . '. ' . trim($response));
			}
			else
			{
				return array('error' => LangHelper::T('scripts.core.connection_error'));
			}
		}
	}

	public function deleteAction()
	{
		if ($this->getVultrAPI())
		{
			$id = filter_input(INPUT_GET, 'vultrID');
			$allow = Capsule::table('vultr_snapshots')->where('SNAPSHOTID', $id)->where('client_id', $this->clientID)->where('service_id', $this->serviceID)->first();
			if (!empty($allow))
			{
				Capsule::table('vultr_snapshots')->where('SNAPSHOTID', $id)->delete();
				$this->vultrAPI->snapshot_destroy($id);
				SessionHelper::setFlashMessage('success', LangHelper::T('snapshots.delete.success'));
			}
			else
			{
				SessionHelper::setFlashMessage('danger', LangHelper::T('snapshots.delete.error'));
			}
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Snapshots');
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}

	public function restoreAction()
	{
		if ($this->getVultrAPI())
		{
			$id = filter_input(INPUT_GET, 'vultrID');
			$allow = Capsule::table('vultr_snapshots')->where('SNAPSHOTID', $id)->where('client_id', $this->clientID)->where('service_id', $this->serviceID)->first();
			if (!empty($allow))
			{
				$this->vultrAPI->restore_snapshot($this->params['customfields']['subid'], $id);
				SessionHelper::setFlashMessage('success', LangHelper::T('snapshots.restore.success'));
			}
			else
			{
				SessionHelper::setFlashMessage('danger', LangHelper::T('snapshots.restore.error'));
			}
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Snapshots');
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}
}
