<?php

namespace MGModule\vultr\models\whmcs\clients;

use MGModule\vultr as main;

/**
 * Client Model
 *
 * @Table(name=tblclients,preventUpdate,prefixed=false)
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
class Client extends main\mgLibs\models\Orm
{
	/**
	 *
	 * @Column(id)
	 * @var int
	 */
	public $id;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $firstname;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $lastname;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $email;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $companyname;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $status;

	/**
	 *
	 * @Column(name=currency,as=currencyId)
	 * @var string
	 */
	protected $currencyId;

	/**
	 *
	 * @Column(name=address1)
	 * @var string
	 */
	protected $address1;

	/**
	 *
	 * @Column(name=address2)
	 * @var string
	 */
	protected $address2;

	/**
	 *
	 * @Column(name=city)
	 * @var string
	 */
	protected $city;

	/**
	 *
	 * @Column(name=state)
	 * @var string
	 */
	protected $state;

	/**
	 *
	 * @Column(name=postcode)
	 * @var string
	 */
	protected $postcode;

	/**
	 *
	 * @Column(name=country)
	 * @var string
	 */
	protected $country;

	/**
	 *
	 * @Column(name=phonenumber)
	 * @var string
	 */
	protected $phonenumber;


	private $_customFields;

	private $_currency;


	function getFullName()
	{
		return $this->firstname . ' ' . $this->lastname . (($this->companyname) ? (' (' . $this->companyname . ')') : '');
	}

	function getProfileUrl()
	{
		return 'clientssummary.php?userid=' . $this->id;
	}

	/**
	 * Get Custom Fields
	 *
	 * @return customFields
	 * @author Michal Czech <michael@modulesgarden.com>
	 */
	function customFields()
	{
		if (empty($this->_customFields))
		{
			$this->_customFields = new main\models\whmcs\clients\customFields\Repository($this->id);
		}

		return $this->_customFields;
	}

	/**
	 *
	 * @return main\models\whmcs\currencies\Currency
	 */
	public function getCurrency()
	{
		if (!empty($this->_currency))
		{
			return $this->_currency;
		}

		return $this->_currency = new main\models\whmcs\currencies\Currency($this->currencyId);
	}

	public function getCurrencyId()
	{
		return $this->currencyId;
	}

	/**
	 *
	 * @param int $currencyId
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setCurrencyId($currencyId)
	{
		$this->currencyId = $currencyId;
		return $this;
	}

	public function getAddress1()
	{
		return $this->address1;
	}

	/**
	 *
	 * @param string $address1
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setAddress1($address1)
	{
		$this->address1 = $address1;
		return $this;
	}

	public function getAddress2()
	{
		return $this->address2;
	}

	/**
	 *
	 * @param string $address2
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setAddress2($address2)
	{
		$this->address2 = $address2;
		return $this;
	}

	public function getCity()
	{
		return $this->city;
	}

	/**
	 *
	 * @param string $city
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setCity($city)
	{
		$this->city = $city;
		return $this;
	}

	public function getState()
	{
		return $this->state;
	}

	/**
	 *
	 * @param string $state
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setState($state)
	{
		$this->state = $state;
		return $this;
	}

	public function getPostcode()
	{
		return $this->postcode;
	}

	/**
	 *
	 * @param string $postcode
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setPostcode($postcode)
	{
		$this->postcode = $postcode;
		return $this;
	}

	public function getCountry()
	{
		return $this->country;
	}

	/**
	 *
	 * @param string $country
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setCountry($country)
	{
		$this->country = $country;
		return $this;
	}

	public function getPhonenumber()
	{
		return $this->phonenumber;
	}

	/**
	 *
	 * @param string $phonenumber
	 * @return \MGModule\QuickBooksDesktop\models\whmcs\clients\Client
	 */
	public function setPhonenumber($phonenumber)
	{
		$this->phonenumber = $phonenumber;
		return $this;
	}

	function getId()
	{
		return $this->id;
	}

	function getFirstname()
	{
		return $this->firstname;
	}

	function getLastname()
	{
		return $this->lastname;
	}


}
