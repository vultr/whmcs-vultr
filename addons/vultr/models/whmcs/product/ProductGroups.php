<?php
namespace MGModule\vultr\models\whmcs\product;
use MGModule\vultr as main;

/**
 * Description of repository
 */
class ProductGroups extends main\mgLibs\models\Repository
{

	public function getModelClass()
	{
		return __NAMESPACE__ . '\ProductGroup';
	}

	/**
	 * @return ProductGroup[]
	 */
	public function get()
	{
		return parent::get();
	}


}
