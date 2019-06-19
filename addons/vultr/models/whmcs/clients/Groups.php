<?php
namespace MGModule\vultr\models\whmcs\clients;
use MGModule\vultr as main;

/**
 * Description of Repository
 *
 * @SuppressWarnings(PHPMD)
 */
class Groups extends main\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Group';
	}

	/**
	 * @return Group[]
	 */
	public function get()
	{
		return parent::get();
	}
}

