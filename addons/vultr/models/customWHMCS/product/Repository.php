<?php

namespace MGModule\vultr\models\customWHMCS\product;

use MGModule\vultr\helpers\ProductsHelper;
use WHMCS\Database\Capsule as DB;

/**
 * Description of repository
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Product';
	}

	public function saveSingleProduct($data)
	{
		return DB::table('tblproducts')->insertGetId($data);
	}

	public function insertPricing($data)
	{
		return DB::table('tblpricing')->insertGetId($data);
	}

	public function createProductConfigurableOptions($productId)
	{
		return ProductsHelper::configurableOptions($productId);
	}


}
