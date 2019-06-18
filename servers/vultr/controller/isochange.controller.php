<?php
class ISOChangeController extends VultrController
{

	public function __construct($params)
	{
		parent::__construct($params);
		if (!isset($this->params['customfields']['subid']) || empty($this->params['customfields']['subid']))
		{
			SessionHelper::setFlashMessage('danger', LangHelper::T('core.client.create_vm_first'));
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
		}
	}

	public function indexAction()
	{

		if ($this->getVultrAPI())
		{
			$servers = $this->vultrAPI->server_list();
			if (isset($servers[$this->params['customfields']['subid']]))
			{
				$return = array('info' => $servers[$this->params['customfields']['subid']]);

				$mountedIsoId = $this->vultrAPI->iso_status($this->params['customfields']['subid'])["ISOID"];

				$availableIsosList = VultrHelper::getAvailableIsos($this->vultrAPI->iso_list());
				$mountedIsoName = VultrHelper::getMountedIsoFileName($this->vultrAPI, $this->params['customfields']['subid']);

				$return['isos'] = $availableIsosList;
				$return['mountedIsoId'] = $mountedIsoId;
				$return['mountedIsoName'] = $mountedIsoName;

				if (isset($_POST['vultrISOID']))
				{
					$code = $this->vultrAPI->attach_iso($this->params['customfields']['subid'], filter_input(INPUT_POST, 'vultrISOID'));
					if ($code == '200')
					{
						SessionHelper::setFlashMessage('success', LangHelper::T('isochange.index.success'));
						$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
					}
					else
					{
						SessionHelper::setFlashMessage('warning', $code);
					}
				}

				return array('vars' => $return);
			}
			else
			{
				SessionHelper::setFlashMessage('info', LangHelper::T('oschange.index.vm_not_found'));
			}
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}
}
