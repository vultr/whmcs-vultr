<?php
namespace MGModule\vultr\models\whmcs\domains;

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
