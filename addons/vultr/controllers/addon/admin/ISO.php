<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MGModule\vultr\controllers\addon\admin;

/**
 * Description of ISO
 */
class ISO
{

	function indexHTML($input = array(), $vars = array())
	{

		$vars['isoList'] = $this->getISOList();


		$vars['isoSettings'] = $this->getIsoSettings();
		return array(
			'tpl' => 'iso',
			'vars' => $vars,
		);
	}

	public function getISOList()
	{
		$isoModel = new \MGModule\vultr\models\iso\Repository();
		return $isoModel->getIsoList();
	}

	public function getIsoSettings()
	{
		$isoModel = new \MGModule\vultr\models\iso\Repository();
		return $isoModel->getISOSettings();
	}

	public function changeIsoSettingsJSON($input)
	{
		$isoModel = new \MGModule\vultr\models\iso\Repository();
		$isoModel->changeISOSettings($input['isoId']);
	}

}
