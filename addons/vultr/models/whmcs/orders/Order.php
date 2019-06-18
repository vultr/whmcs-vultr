<?php

namespace MGModule\vultr\models\whmcs\orders;

use MGModule\vultr as main;

/**
 * Description of order
 *
 * @Table(name=tblorders,preventUpdate,prefixed=false)
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Order extends main\mgLibs\models\Orm
{
	/**
	 *
	 * @Column(int)
	 * @var int
	 */
	public $id;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $ordernum;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $userid;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $date;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $invoiceid;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $status;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	public $ipaddress;

	/**
	 *
	 * @var main\models\whmcs\clients\client
	 */
	private $_client;

	/**
	 *
	 * @return main\models\whmcs\clients\client
	 */
	public function client()
	{
		if (empty($this->_client))
		{
			$this->_client = new main\models\whmcs\clients\client($this->userid);
		}

		return $this->_client;
	}

	function getOrderUrl()
	{
		return 'orders.php?action=view&id=' . $this->id;
	}
}
