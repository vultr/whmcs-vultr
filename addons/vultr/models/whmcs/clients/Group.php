<?php

/* * ********************************************************************
 * DiscountCenter product developed. (2015-11-24)
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

namespace MGModule\vultr\models\whmcs\clients;

use MGModule\vultr as main;

/**
 * Description of Group
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 * @Table(name=tblclientgroups,preventUpdate,prefixed=false)
 * @SuppressWarnings(PHPMD)
 */
class Group extends main\mgLibs\models\Orm
{
	/**
	 *
	 * @Column(id)
	 * @var int
	 */
	protected $id;

	/**
	 *
	 * @Column(name=groupname,as=name)
	 * @var string
	 */
	protected $name;

	/**
	 *
	 * @Column(name=groupcolour,as=colour)
	 * @var string
	 */
	protected $colour;

	/**
	 *
	 * @Column(name=discountpercent,as=discountPercent)
	 * @var string
	 */
	protected $discountPercent;

	/**
	 *
	 * @Column(name=susptermexempt,as=exemptFromSuspendTerminate)
	 * @var string
	 */
	protected $exemptFromSuspendTerminate;

	/**
	 *
	 * @Column(name=separateinvoices,as=separateInvoices)
	 * @var string
	 */
	protected $separateInvoices;

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getColour()
	{
		return $this->colour;
	}

	public function getDiscountPercent()
	{
		return $this->discountPercent;
	}

	public function getExemptFromSuspendTerminate()
	{
		return $this->exemptFromSuspendTerminate;
	}

	public function getSeparateInvoices()
	{
		return $this->separateInvoices;
	}

}
