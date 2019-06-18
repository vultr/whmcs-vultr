<?php

class ConsoleController extends VultrController
{

	public function __construct($params)
	{
		parent::__construct($params);
		$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
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
				if ($servers[$this->params['customfields']['subid']]['status'] == 'active')
				{
					return array(
						'vars' => array(
							'server' => $servers[$this->params['customfields']['subid']]
						)
					);
				}
				else
				{
					$status = $servers[$this->params['customfields']['subid']]['status'];
					if ($status == 'pending')
					{
						$status = 'installing';
					}
					SessionHelper::setFlashMessage('info', LangHelper::T('main.index.vm_status_is') . $status);
					SessionHelper::setFlashMessage('info', LangHelper::T('main.create.reload_info'));
				}
			}
			else
			{
				SessionHelper::setFlashMessage('info', LangHelper::T('main.index.vm_not_found'));
			}
		}
		else
		{
			SessionHelper::setFlashMessage('success', LangHelper::T('main.index.connection_error'));
		}
	}
}
