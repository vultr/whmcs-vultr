<?php
namespace MGModule\vultr\models\whmcs\invoices;

/**
 * Description of Repository
 */
class RepositoryItem extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Item';
	}

	/**
	 * @return Item[]
	 */
	public function get()
	{
		return parent::get();
	}

	/**
	 * @param int $id
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyInvoiceId($id)
	{
		$this->_filters['invoiceid'] = (int)$id;

		return $this;
	}

	/**
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyAddon()
	{
		$this->_filters['type'] = 'Addon';

		return $this;
	}

	/**
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyHosting()
	{
		$this->_filters['type'] = 'Hosting';

		return $this;
	}

	/**
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyDomainRegister()
	{
		$this->_filters['type'] = 'DomainRegister';

		return $this;
	}

	/**
	 * @return \MGModule\vultr\models\whmcs\invoices\RepositoryItem
	 */
	public function onlyHostingAndAddonAndDomainRegister()
	{
		$this->_filters['type'] = array('DomainRegister', 'Addon', 'DomainRegister');

		return $this;
	}
}
