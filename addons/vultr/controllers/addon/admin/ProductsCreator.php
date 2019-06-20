<?php

namespace MGModule\vultr\controllers\addon\admin;

use MGModule\vultr as main;
use WHMCS\Database\Capsule as DB;


/**
 * Description of actions
 */
$pathToVendor = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . DIRECTORY_SEPARATOR . "servers" . DIRECTORY_SEPARATOR .
	"vultr" . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR;
include_once $pathToVendor . "VultrAPI.php";

class ProductsCreator extends main\mgLibs\process\AbstractController
{
	public function indexHTML($input = [], $vars = [])
	{

		//get API Token from addon module settings


		$token = DB::table("tbladdonmodules")->select("tbladdonmodules.value")
			->where("tbladdonmodules.module", "=", "vultr")
			->where("tbladdonmodules.setting", "=", "apiToken")->get();


		$productGroups = DB::table("tblproductgroups")->select("tblproductgroups.id", "tblproductgroups.name")->get();
		$vars['productGroups'] = $productGroups;


		$currencies = DB::table("tblcurrencies")->select("tblcurrencies.id", "tblcurrencies.code")->get();
		$vars['currencies'] = $currencies;

		$apiConnection = new \VultrAPI($token[0]->value);
		$plans = $apiConnection->plans_list();
		$vars['apiProducts'] = $plans;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($input['createSingle']))
		{
			$this->saveProduct($input, $vars);
			$vars['success'] = main\mgLibs\Lang::T('messages', 'single_product_created');
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($input['createMass']))
		{
			$this->saveProducts($input, $vars);
			$vars['success'] = main\mgLibs\Lang::T('messages', 'mass_product_created');
		}

		return array
		(
			'tpl' => 'products_creator',
			'vars' => $vars
		);
	}

	public function saveProduct($input = array())
	{
		$token = DB::table("tbladdonmodules")->select("tbladdonmodules.value")
			->where("tbladdonmodules.module", "=", "vultr")
			->where("tbladdonmodules.setting", "=", "apiToken")->get();

		$productData = array(
			'type' => 'server',
			'gid' => $input['gid'],
			'name' => $input['name'],
			'hidden' => '0',
			'showdomainoptions' => 0,
			'paytype' => $input['paytype'],
			'servertype' => 'vultr',
			'configoption1' => $token[0]->value,
			'configoption2' => $input['configoption2']
		);

		$repository = new main\models\customWHMCS\product\Repository();

		$insertedProductId = $repository->saveSingleProduct($productData);

		foreach ($input['currency'] as $value)
		{
			$pricingData = array(
				'type' => 'product',
				'relid' => $insertedProductId
			);
			foreach ($value as $k => $v)
			{
				$pricingData[$k] = $v;
			}
			$result = $repository->insertPricing($pricingData);
			if ($result)
			{
				unset($_POST['createSingle']);
			}
		}
	}

	public function saveProducts($input)
	{


		$token = DB::table("tbladdonmodules")->select("tbladdonmodules.value")
			->where("tbladdonmodules.module", "=", "vultr")
			->where("tbladdonmodules.setting", "=", "apiToken")->get();

		$apiConnection = new \VultrAPI($token[0]->value);
		$plans = $apiConnection->plans_list();
		$repository = new main\models\customWHMCS\product\Repository();
		$currencies = DB::table("tblcurrencies")->select("tblcurrencies.id", "tblcurrencies.code")->get();

		foreach ($plans as $value)
		{
			if ($value['VPSPLANID'] >= 100)
			{
				$productData = array(
					'type' => 'server',
					'gid' => $input['gid'],
					'name' => $value['name'],
					'hidden' => '0',
					'showdomainoptions' => 0,
					'paytype' => "free",
					'servertype' => 'vultr',
					'configoption1' => $token[0]->value,
					'configoption2' => $value['VPSPLANID']
				);

				$insertedProductId = $repository->saveSingleProduct($productData);

				foreach ($currencies as $val)
				{
					$pricingData = array(
						'type' => 'product',
						'currency' => $val->id,
						'relid' => $insertedProductId,
						'msetupfee' => 0,
						'qsetupfee' => 0,
						'ssetupfee' => 0,
						'asetupfee' => 0,
						'bsetupfee' => 0,
						'tsetupfee' => 0,
						'monthly' => -1,
						'quarterly' => -1,
						'semiannually' => -1,
						'annually' => -1,
						'biennially' => -1,
						'triennially' => -1
					);

					$result = $repository->insertPricing($pricingData);

				}
			}
		}

		unset($_POST['createMass']);
	}

}
