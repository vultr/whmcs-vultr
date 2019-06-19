<?php

class GraphsController extends VultrController
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
			$incoming = '[';
			$outgoing = '[';
			$bandwitch = $this->vultrAPI->bandwidth($this->params['customfields']['subid']);
			if (empty($bandwitch['incoming_bytes']))
			{
				SessionHelper::setFlashMessage('info', LangHelper::T('graphs.index.empty_data'));
				return array('vars' => array('emptyData' => true));
			}
			foreach ($bandwitch['incoming_bytes'] as $byte)
			{
				$incoming .= '{date:\'' . $byte[0] . '\',incoming:' . $byte[1] . '},';
			}
			foreach ($bandwitch['outgoing_bytes'] as $byte)
			{
				$outgoing .= '{date:\'' . $byte[0] . '\',outgoing:' . $byte[1] . '},';
			}
			return array('vars' => array('incoming' => $incoming . ']', 'outgoing' => $outgoing . ']'));
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}
}
