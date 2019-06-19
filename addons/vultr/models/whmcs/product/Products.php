<?php

namespace MGModule\vultr\models\whmcs\product;

/**
 * Description of repository
 */
class Products extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Product';
	}
}
