<?php
namespace MGModule\vultr\models\whmcs\admins;
use MGModule\vultr as main;


/**
 * Description of Repository
 */
class Admins extends main\mgLibs\models\Repository
{

	public function getModelClass()
	{
		return __NAMESPACE__ . '\Admin';
	}

	/**
	 * @return Admin[]
	 */
	public function get()
	{
		return parent::get();
	}
}

