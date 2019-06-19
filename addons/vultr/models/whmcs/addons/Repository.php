<?php
namespace MGModule\vultr\models\whmcs\addons;
use MGModule\vultr as main;

/**
 * Description of Repository
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Addon';
	}

	/**
	 * @return Addon[]
	 */
	public function get()
	{
		return parent::get();
	}
}

