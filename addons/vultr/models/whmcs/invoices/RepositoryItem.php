<?php

/* * ********************************************************************
 * vultr product developed. (2015-11-23)
 * *
 *
 *  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
 *  CONTACT                        ->       contact@modulesgarden.com
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 * ******************************************************************** */

namespace MGModule\vultr\models\whmcs\invoices;

/**
 * Description of Repository
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 */
class RepositoryItem extends \MGModule\vultr\mgLibs\models\Repository
{

	public function getModelClass()
	{
		return __NAMESPACE__ . '\Item';
	}

	/**
	 *
	 * @return Item[]
	 */
	public function get()
	{
		return parent::get();
	}

	/**
	 *
	 * @param int $id
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyInvoiceId($id)
	{

		$this->_filters['invoiceid'] = (int)$id;
		return $this;

	}

	/**
	 *
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyAddon()
	{

		$this->_filters['type'] = 'Addon';
		return $this;

	}

	/**
	 *
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyHosting()
	{

		$this->_filters['type'] = 'Hosting';
		return $this;

	}

	/**
	 *
	 * @return \MGModule\vultr\models\whmcs\pricing\RepositoryItem
	 */
	public function onlyDomainRegister()
	{

		$this->_filters['type'] = 'DomainRegister';
		return $this;

	}

	/**
	 *
	 * @return \MGModule\vultr\models\whmcs\invoices\RepositoryItem
	 */
	public function onlyHostingAndAddonAndDomainRegister()
	{

		$this->_filters['type'] = array('DomainRegister', 'Addon', 'DomainRegister');
		return $this;

	}


}
