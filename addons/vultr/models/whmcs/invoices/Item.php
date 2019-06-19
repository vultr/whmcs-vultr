<?php
namespace MGModule\vultr\models\whmcs\invoices;
use MGModule\vultr as main;

/**
 * Description of Item
 *
 * @Table(name=tblinvoiceitems,preventUpdate,prefixed=false)
 */
class Item extends main\mgLibs\models\Orm
{
	/**
	 * @Column()
	 * @var int
	 */
	protected $id;

	/**
	 * @Column(name=invoiceid,as=invoiceId)
	 * @var int
	 */
	protected $invoiceId;

	/**
	 * @Column(name=userid,as=userId)
	 * @var int
	 */
	protected $userId;

	/**
	 * @Column(name=type)
	 * @var string
	 */
	protected $type;

	/**
	 * @Column(name=relid,as=relId)
	 * @var int
	 */
	protected $relId;

	/**
	 * @Column(name=description)
	 * @var string
	 */
	protected $description;


	/**
	 * @Column(name=amount)
	 * @var int
	 */
	protected $amount;


	/**
	 * @Column(name=taxed)
	 * @var int
	 */
	protected $taxed;

	/**
	 * @Column(name=duedate,as=dueDate)
	 * @var string
	 */
	protected $dueDate;

	/**
	 * @Column(name=paymentmethod )
	 * @var int
	 */
	protected $paymentmethod;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getInvoiceId()
	{
		return $this->invoiceId;
	}

	public function setInvoiceId($invoiceId)
	{
		$this->invoiceId = $invoiceId;

		return $this;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;

		return $this;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;

		return $this;
	}

	public function getRelId()
	{
		return $this->relId;
	}

	public function setRelId($relId)
	{
		$this->relId = $relId;

		return $this;
	}

	public function isDomainRegister()
	{
		return $this->type = 'DomainRegister';
	}

	public function isAddon()
	{
		return $this->type = 'Addon';
	}

	public function isHosting()
	{
		return $this->type = 'Hosting';
	}
}
