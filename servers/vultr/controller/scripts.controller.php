<?php

use WHMCS\Database\Capsule;

class ScriptsController extends VultrController
{

	public function __construct($params)
	{
		parent::__construct($params);
	}

	public function indexAction()
	{
		if ($this->getVultrAPI())
		{
			return array('vars' => array('scripts' => VultrHelper::getUserScripts($this->clientID, $this->vultrAPI->startupscript_list())));
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}

	public function deleteAction()
	{
		$id = filter_input(INPUT_GET, 'vultrID', FILTER_VALIDATE_INT);
		$allow = Capsule::table('vultr_scripts')->where('SCRIPTID', $id)->where('client_id', $this->clientID)->first();
		if (!empty($allow)) // this may need to be fixed to if (count($allow) > 0) but have not tested changing it yet to count
		{
			if ($this->getVultrAPI())
			{
				Capsule::table('vultr_scripts')->where('SCRIPTID', $id)->delete();
				$this->vultrAPI->startupscript_destroy($id);
				SessionHelper::setFlashMessage('success', LangHelper::T('scripts.delete.success_delete'));
			}
			else
			{
				return array('error' => LangHelper::T('scripts.core.connection_error'));
			}
		}
		else
		{
			SessionHelper::setFlashMessage('danger', LangHelper::T('scripts.delete.error_delete'));
		}
		$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Scripts');
	}

	public function addAction()
	{
		if (isset($_POST['vultrSCRIPTname']))
		{
			$script = filter_input(INPUT_POST, 'vultrSCRIPT');
			switch ($_POST['vultrSCRIPTtype'])
			{
				case 'boot':
					if (substr($script, 0, 9) !== '#!/bin/sh')
					{
						SessionHelper::setFlashMessage('danger', LangHelper::T('scripts.add.boot_script_error'));
						return;
					}
					break;
				case 'pxe':
					if (substr($script, 0, 6) !== '#!ipxe')
					{
						SessionHelper::setFlashMessage('danger', LangHelper::T('scripts.add.pxe_script_error'));
						return;
					}
					break;
				default:
					SessionHelper::setFlashMessage('danger', LangHelper::T('scripts.add.undefined_script_type'));
					return;
					break;
			}
			if ($this->getVultrAPI())
			{
				$response = $this->vultrAPI->startupscript_create(VultrHelper::cleanString(filter_input(INPUT_POST, 'vultrSCRIPTname')), $script, filter_input(INPUT_POST, 'vultrSCRIPTtype'));
				if (is_int($response))
				{
					Capsule::table('vultr_scripts')->insert(array('SCRIPTID' => $response, 'client_id' => $this->clientID, 'type' => filter_input(INPUT_POST, 'vultrSCRIPTtype')));
					SessionHelper::setFlashMessage('success', LangHelper::T('scripts.add.success_add'));
					$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Scripts');
				}
				SessionHelper::setFlashMessage('danger', LangHelper::T('scripts.add.error_add'));
			}
			else
			{
				return array('error' => LangHelper::T('scripts.core.connection_error'));
			}
		}
	}
}
