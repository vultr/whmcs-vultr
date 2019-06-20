<?php
namespace MGModule\vultr\models\whmcs\domains;
use MGModule\vultr as main;

/**
 * Description of DomainPrice
 *
 * @Table(name=tbldomainpricing,preventUpdate,prefixed=false)
 */
class DomainTld extends main\mgLibs\models\Orm
{
	/**
	 * @Column()
	 * @var int
	 */
	protected $id;

	/**
	 * @Column(name=extension)
	 * @var string
	 */
	protected $extension;

	/**
	 * @Column(name=dnsmanagement,as=dnsManagement)
	 * @var string
	 */
	protected $dnsManagement;

	/**
	 * @Column(name=emailforwarding,as=emailForwarding)
	 * @var string
	 */
	protected $emailForwarding;

	/**
	 * @Column(name=idprotection,as=idProtection)
	 * @var string
	 */
	protected $idProtection;

	/**
	 * @Column(name=eppcode,as=eppCode)
	 * @var string
	 */
	protected $eppCode;

	/**
	 * @Column(name=autoreg,as=autoreg)
	 * @var string
	 */
	protected $autoreg;

	private $_domainRegisterPricing;

	public function getId()
	{
		return $this->id;
	}

	public function getExtension()
	{
		return $this->extension;
	}

	public function getDnsManagement()
	{
		return $this->dnsManagement;
	}

	public function getEmailForwarding()
	{
		return $this->emailForwarding;
	}

	public function getIdProtection()
	{
		return $this->idProtection;
	}

	public function getEppCode()
	{
		return $this->eppCode;
	}

	public function getAutoreg()
	{
		return $this->autoreg;
	}

	/**
	 * Get Pricing
	 *
	 * @return main\models\whmcs\pricing\Price[]
	 */
	public function getDomainRegisterPricing()
	{
		if (!empty($this->_domainRegisterPricing))
		{
			return $this->_domainRegisterPricing;
		}

		$repository = new main\models\whmcs\pricing\Repository();
		$repository->onlyDomainRegister();
		$repository->withRelation($this->id);
		$repository->withDomainCycle();
		$this->_domainRegisterPricing = array();
		foreach ($repository->get() as $price)
		{
			$this->_domainRegisterPricing[] = $price;
		}

		unset($repository);
		return $this->_domainRegisterPricing;
	}

	public function getPrice($currencyId, $billingCycle)
	{
		$repository = new main\models\whmcs\pricing\Repository();
		$repository->onlyDomainRegister();
		$repository->withRelation($this->id);
		$repository->withDomainCycle();
		$repository->onlyCurrency($currencyId);
		foreach ($repository->get() as $price)
		{
			return $price->getPrice($billingCycle);
		}

		return null;
	}
}
