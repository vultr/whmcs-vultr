<?php
namespace MGModule\vultr\models\whmcs\pricing;

/**
 * Description of Repository
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{

	public function getModelClass()
	{
		return __NAMESPACE__ . '\Price';
	}

	/**
	 * @return Price[]
	 */
	public function get()
	{
		return parent::get();
	}


	public function onlyProducts()
	{
		$this->_filters['type'] = 'product';
	}

	public function onlyAddon()
	{
		$this->_filters['type'] = 'addon';
	}

	public function onlyDomainRegister()
	{
		$this->_filters['type'] = 'domainregister';
	}

	public function withRelation($relationId)
	{
		$this->_filters['relid'] = (int)$relationId;
	}

	public function onlyCurrency($currencyId)
	{
		$this->_filters['currency'] = (int)$currencyId;
	}

	public function withBillingCycle()
	{
		$filters = ' ( monthly > 0.00 OR quarterly > 0.00 OR semiannually > 0.00 OR annually > 0.00 OR  biennially > 0.00  OR triennially > 0.00 )';

		$this->_filters[] = $filters;
	}

	public function withDomainCycle()
	{
		$filters = ' ( msetupfee > 0.00 OR qsetupfee  > 0.00 OR ssetupfee  > 0.00 OR asetupfee  > 0.00 OR  bsetupfee > 0.00  OR tsetupfee > 0.00 ';
		$filters .= '  OR monthly > 0.00 OR quarterly > 0.00 OR semiannually > 0.00 OR annually > 0.00 OR  biennially > 0.00  OR triennially > 0.00 )';

		$this->_filters[] = $filters;
	}
}
