<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class SSHKeysController extends VultrController
{

	public function __construct($params)
	{
		parent::__construct($params);
	}

	public function indexAction()
	{
		if ($this->getVultrAPI())
		{
			$allowKeys = Capsule::table('vultr_sshkeys')->where('client_id', $this->clientID)->get();
			if (count($allowKeys) < 1)
			{
				return array();
			}
			else
			{
				$allows = array();
				foreach ($allowKeys as $key => $value)
				{
					$allows[] = $value->SSHKEYID;
				}
				$keys = $this->vultrAPI->sshkeys_list();
				foreach ($keys as $key => $value)
				{
					if (!in_array($value['SSHKEYID'], $allows))
					{
						unset($keys[$key]);
					}
				}
				return array('vars' => array('keys' => $keys));
			}
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}

	public function deleteAction()
	{
		$id = filter_input(INPUT_GET, 'vultrID');
		$allow = Capsule::table('vultr_sshkeys')->where('SSHKEYID', $id)->where('client_id', $this->clientID)->first();
		if (!empty($allow))
		{
			if ($this->getVultrAPI())
			{
				Capsule::table('vultr_sshkeys')->where('SSHKEYID', $id)->delete();
				$this->vultrAPI->sshkey_destroy($id);
				SessionHelper::setFlashMessage('success', LangHelper::T('sshkeys.delete.delete_success'));
			}
			else
			{
				return array('error' => LangHelper::T('scripts.core.connection_error'));
			}
		}
		else
		{
			SessionHelper::setFlashMessage('danger', LangHelper::T('sshkeys.delete.delete_error'));
		}
		$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=SSHKeys');
	}

	public function addAction()
	{
		if (isset($_POST['vultrSSHKEYname']))
		{
			if ($this->getVultrAPI())
			{
				$response = $this->vultrAPI->sshkey_create(VultrHelper::cleanString(filter_input(INPUT_POST, 'vultrSSHKEYname')), filter_input(INPUT_POST, 'vultrSSHKEY'));
				if (is_array($response))
				{
					Capsule::table('vultr_sshkeys')->insert(array('SSHKEYID' => $response['SSHKEYID'], 'client_id' => $this->clientID));
					SessionHelper::setFlashMessage('success', LangHelper::T('sshkeys.add.add_success'));
					$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=SSHKeys');
				}
				SessionHelper::setFlashMessage('danger', LangHelper::T('sshkeys.add.add_error') . ' ' . $response);
			}
			else
			{
				return array('error' => LangHelper::T('scripts.core.connection_error'));
			}
		}
	}
}
