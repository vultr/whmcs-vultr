<?php
namespace MGModule\vultr\models\whmcs\domains;
use MGModule\vultr as main;

/**
 * Description of Repository
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\DomainTld';
	}

	/**
	 * @return DomainTld[]
	 */
	public function get()
	{
		return parent::get();
	}
}
