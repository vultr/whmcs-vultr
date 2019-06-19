<?php
namespace MGModule\vultr\models\whmcs\clients;
use MGModule\vultr as main;


/**
 * Description of Repository
 *
 * @SuppressWarnings(PHPMD)
 */
class Clients extends main\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Client';
	}

	/**
	 * @return Client[]
	 */
	public function get()
	{
		return parent::get();
	}
}

