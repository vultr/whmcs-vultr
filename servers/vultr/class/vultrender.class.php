<?php

class Vultrender
{

	protected $template = 'default';
	protected $moduleError = false;
	protected $moduleErrorMessage = '';
	private $params = array();
	private $controlerName = 'Main';
	private $actionName = 'index';
	private $controlerFullName = 'MainController';
	private $actionFullName = 'indexAction';

	function __construct($params)
	{
		$this->params = $params;
	}

	public function render($mode)
	{
		switch ($mode)
		{
			case 'ClientArea':
				$this->renderCA();
				break;
			default:
				$this->setModuleErrorMessage(LangHelper::T('core.client.action_not_found'));
				break;
		}
		return self::renderTemplate();
	}

	private function renderCA()
	{
		if (isset($_GET['cloudController']))
		{
			$this->controlerName = filter_input(INPUT_GET, 'cloudController');
			$this->controlerFullName = filter_input(INPUT_GET, 'cloudController') . 'Controller';
		}
		if (isset($_GET['cloudAction']))
		{
			$this->actionName = filter_input(INPUT_GET, 'cloudAction');
			$this->actionFullName = filter_input(INPUT_GET, 'cloudAction') . 'Action';
		}
		if (class_exists($this->controlerFullName))
		{
			$controller = new $this->controlerFullName($this->params);
			if (method_exists($controller, $this->actionFullName))
			{
				$this->setTemplate('controller' . DS . strtolower($this->controlerName) . DS . strtolower($this->actionName));
				$this->setVars('controller', $this->controlerName);
				$this->setVars('action', $this->actionName);
				$this->setVars('postData', $_POST);
				$this->render = $controller->{$this->actionFullName}();
			}
			else
			{
				$this->setModuleErrorMessage(LangHelper::T('core.client.action_not_found'));
			}
		}
		else
		{
			$this->setModuleErrorMessage(LangHelper::T('core.client.controller_not_found'));
		}
	}

	private function setTemplate($template)
	{
		$this->template = $template;
	}

	public function setVars($name, $value)
	{
		$this->smartyVars[$name] = $value;
	}

	public function setModuleErrorMessage($message)
	{
		$this->setTemplate('element' . DS . 'moduleError');
		$this->moduleError = true;
		$this->moduleErrorMessage = $message;
	}

	private function renderTemplate()
	{
		if (isset($this->render['templatefile']))
		{
			$this->setTemplate($this->render['templatefile']);
		}
		if (isset($this->render['error']))
		{
			$this->setModuleErrorMessage($this->render['error']);
		}
		if (isset($this->render['vars']))
		{
			foreach ($this->render['vars'] as $key => $value)
			{
				$this->setVars($key, $value);
			}
		}
		if (file_exists(VULTRDIR . 'template' . DS . $this->template . '.tpl'))
		{
			$this->setVars('_LANG', LangHelper::T());
			$this->setVars('module', $this->params);
		}
		else
		{
			$this->setModuleErrorMessage(LangHelper::T('core.action.template_not_found'));
		}
		if ($this->moduleError)
		{
			$this->setVars('moduleError', $this->moduleErrorMessage);
		}
		$this->setVars('flashMessages', SessionHelper::getFlashMessages());
		return array(
			'templatefile' => 'template' . DS . $this->template,
			'vars' => $this->smartyVars
		);
	}

	public function checkApiConnection($vultrAPI)
	{
		$accountInfo = $vultrAPI->account_info();
		if (is_array($accountInfo))
		{
			return TRUE;
		}
		else
		{
			self::setModuleErrorMessage(LangHelper::T('core.client.api_connection_error'));
			return FALSE;
		}
	}
}
