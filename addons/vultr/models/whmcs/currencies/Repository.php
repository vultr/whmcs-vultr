<?php
namespace MGModule\vultr\models\whmcs\currencies;

/**
 * Description of Repository
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Currency';
	}

	/**
	 * @return Currency[]
	 */
	public function get()
	{
		return parent::get();
	}
}

