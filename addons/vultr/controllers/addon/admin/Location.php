<?php

namespace MGModule\vultr\controllers\addon\admin;

use MGModule\vultr as main;

/**
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Location extends main\mgLibs\process\AbstractController
{

	function indexHTML($input = array(), $vars = array())
	{
		$vars['locationArray'] = $this->getLocationList();
		$vars['locationSettings'] = $this->getLocationSetings();

		return array(
			'tpl' => 'location',
			'vars' => $vars,
			'input' => $input
		);
	}

	public function getLocationList()
	{
		$locationModel = new \MGModule\vultr\models\location\Repository();
		return $locationModel->getLocationList();
	}

	public function getLocationSetings()
	{
		$locationModel = new \MGModule\vultr\models\location\Repository();
		return $locationModel->getLocationSettings();
	}

	public function changeLocationSettingsJSON($input, $vars = [])
	{
		$locationModel = new \MGModule\vultr\models\location\Repository();
		$locationModel->changeLocationSettings($input['locationId']);
		return array
		(
			'success' => 'Location settings has been changed'
		);
	}

}
