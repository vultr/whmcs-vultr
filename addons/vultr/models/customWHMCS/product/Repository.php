<?php

namespace MGModule\vultr\models\customWHMCS\product;

use MGModule\vultr as main;
use WHMCS\Database\Capsule as DB;
use MGModule\vultr\helpers\ProductsHelper;

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
		$productID = DB::table('tblproducts')->insertGetId($data);

		return $productID;
	}

	public function insertPricing($data)
	{
		DB::table('tblpricing')->insertGetId($data);
		return $insertResult;
	}

	public function createProductConfigurableOptions($productId)
	{
		return ProductsHelper::configurableOptions($productId);
	}


}
