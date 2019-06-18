<?php

namespace MGModule\vultr\controllers\addon\admin;

//use MGModule\vultr\helpers\PathHelper;

use MGModule\vultr as main;

/**
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Dns extends main\mgLibs\process\AbstractController
{

	function indexHTML($input = array(), $vars = array())
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($input['changeNS']))
		{
			$this->saveChanges($input, $vars);
			$vars['success'] = main\mgLibs\Lang::T('messages', 'NameServersChange');
		}
		$vars['nameServer'] = $this->getNameServers();
		return array(
			'tpl' => 'dns',
			'vars' => $vars,
			'input' => $input
		);
	}

	public function saveChanges($input = [], $vars = [])
	{
		$arrayToSave = [
			'ns1' => $input['ns1'],
			'ns2' => $input['ns2'],
		];
		$nameServerModel = new \MGModule\vultr\models\dns\Repository();
		$nsChange = $nameServerModel->updateNameServers($arrayToSave);

		if ($nsChange)
		{
			return [
				'success' => main\mgLibs\Lang::T('messages', '')
			];
		}
		return [
			'error' => main\mgLibs\Lang::T('messages', '')
		];
	}

	public function getNameServers()
	{
		$nameServerModel = new \MGModule\vultr\models\dns\Repository();

		return $nameServerModel->getNameServers();
	}

}
