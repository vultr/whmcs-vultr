<?php
namespace MGModule\vultr\models\whmcs\admins;
use MGModule\vultr as main;


/**
 * Description of Repository
 */
class Roles extends main\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Role';
	}

	/**
	 * @return Role[]
	 */
	public function get()
	{
		return parent::get();
	}
}

