<?php

namespace MGModule\vultr\models\products;

use WHMCS\Database\Capsule as DB;

/**
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{

	private $productsObject;

	public function __construct($columns = array(), $search = array())
	{
		parent::__construct($columns, $search);
		$this->getProductsArray();
	}

	private function getProductsArray()
	{
		$this->productsObject = DB::table("tblproducts")
			->join("tblproductgroups", "tblproducts.gid", "=", "tblproductgroups.id")
			->leftJoin("tblproductconfiglinks", "tblproducts.id", "=", "tblproductconfiglinks.pid")
			->select("tblproducts.id as id", "tblproductgroups.id as groupId", "tblproductgroups.name as groupName", "tblproducts.name as name", "tblproducts.paytype as paytype", "tblproducts.configoption2 as configoption2", "tblproductconfiglinks.gid as configurableID")
			->where("tblproducts.servertype", "=", "vultr");
	}

	public function getModelClass()
	{
		return __NAMESPACE__ . '\products';
	}

	public function getProducts()
	{

		return $this->productsObject->get();
	}

	public function countProducts()
	{
		return $this->productsObject->count();
	}

	public function orderByProducts($column, $dir)
	{
		$this->productsObject->orderBy($column, $dir);
	}

	public function limitProducts($limit)
	{
		$this->productsObject->limit($limit);
	}

	public function offset($limit)
	{
		$this->productsObject->offset($limit);
	}

	public function removeProduct($productId)
	{
		//rozbite, bo najprawdopodbniej dojdą jeszcze configoptions
		$this->deletePrice($productId);
		$deleteInfo = $this->deleteProduct($productId);
		if ($deleteInfo == 1)
		{
			return 'success';
		}
		else
		{
			return $deleInfo;
		}
	}

	private function deletePrice($productId)
	{
		return DB::table("tblpricing")->where([
			['type', '=', 'product'],
			['relid', '=', $productId],
		])->delete();
	}

	private function deleteProduct($productId)
	{
		return DB::table("tblproducts")->where('id', '=', $productId)->delete();
	}

}
