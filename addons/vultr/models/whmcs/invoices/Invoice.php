<?php
namespace MGModule\vultr\models\whmcs\invoices;
use MGModule\vultr as main;

/**
 * Description of Item
 *
 * @Table(name=tblinvoices,preventUpdate,prefixed=false)
 */
class Invoice extends main\mgLibs\models\Orm
{
	/**
	 * @Column()
	 * @var int
	 */
	protected $id;

	/**
	 * @Column(name=userid,as=userId)
	 * @var int
	 */
	protected $userId;

	/**
	 * @Column(name=invoicenum,as=invoiceNum)
	 * @var int
	 */
	protected $invoiceNum;

	/**
	 * @Column(name=date)
	 * @var string
	 */
	protected $date;

	/**
	 * @Column(name=duedate)
	 * @var string
	 */
	protected $duedate;

	/**
	 * @Column(name=datepaid)
	 * @var string
	 */
	protected $datepaid;

	/**
	 * @Column(name=subtotal)
	 * @var string
	 */
	protected $subtotal;

	private $_client;

	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return \MGModule\vultr\models\whmcs\invoices\Invoice
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getInvoiceNum()
	{
		return $this->invoiceNum;
	}

	/**
	 * @param int $invoiceNum
	 * @return \MGModule\vultr\models\whmcs\invoices\Invoice
	 */
	public function setInvoiceNum($invoiceNum)
	{
		$this->invoiceNum = $invoiceNum;

		return $this;
	}

	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param string $date
	 * @return \MGModule\vultr\models\whmcs\invoices\Invoice
	 */
	public function setDate($date)
	{
		$this->date = $date;

		return $this;
	}

	public function getDuedate()
	{
		return $this->duedate;
	}

	/**
	 * @param string $duedate
	 * @return \MGModule\vultr\models\whmcs\invoices\Invoice
	 */
	public function setDuedate($duedate)
	{
		$this->duedate = $duedate;

		return $this;
	}

	public function getDatepaid()
	{
		return $this->datepaid;
	}

	/**
	 * @param string $datepaid
	 * @return \MGModule\vultr\models\whmcs\invoices\Invoice]
	 */
	public function setDatepaid($datepaid)
	{
		$this->datepaid = $datepaid;

		return $this;
	}

	public function getSubtotal()
	{
		return $this->subtotal;
	}

	/**
	 * @param string $subtotal
	 * @return \MGModule\vultr\models\whmcs\invoices\Invoice
	 */
	public function setSubtotal($subtotal)
	{
		$this->subtotal = $subtotal;

		return $this;
	}

	/**
	 * @return main\models\whmcs\clients\Client
	 */
	public function getClient()
	{
		if (!empty($this->_client))
		{
			return $this->_client;
		}

		return $this->_client = new main\models\whmcs\clients\Client($this->getUserId());
	}

	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 * @return \MGModule\vultr\models\whmcs\invoices\Invoice
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;

		return $this;
	}
}
