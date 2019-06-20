<?php

namespace MGModule\vultr\models\whmcs\service;
use MGModule\vultr as main;

/**
 * Description of account
 * @Table(name=tblhosting,preventUpdate,prefixed=false)
 * @SuppressWarnings(PHPMD)
 */
class service extends main\mgLibs\models\Orm
{

	/**
	 * @Column()
	 * @var type
	 */
	public $id;

	/**
	 * @Column(name=userid,as=userid)
	 * @var int
	 */
	public $clientID = 0;

	/**
	 * @Column(name=dedicatedip,as=dedicatedip)
	 * @var string
	 */
	public $dedicatedIP = null;

	/**
	 * @Column(name=assignedips,as=assingedips)
	 * @var array
	 */
	public $IPList = array();

	/**
	 * @Column(name=server,as=serverid)
	 * @var int
	 */
	public $serverID;

	/**
	 * @Column(name=packageid,as=pid)
	 * @var int
	 */
	public $productID;

	/**
	 * @Column()
	 * @var string
	 */
	public $domain;

	/**
	 * @Column()
	 * @var string
	 */
	public $username;

	/**
	 * @Column(as=passwordEncrypted)
	 * @var string
	 */

	public $password;
	/**
	 * @Column(name=nextduedate=nextDueDate)
	 * @var string
	 */
	public $nextDueDate;

	/**
	 * @Column(name=orderid)
	 * @var int
	 */
	protected $_orderid;

	/**
	 * @Column(name=domainstatus,as=_domainstatus)
	 * @var string
	 */
	protected $_status;

	/**
	 * @Column(name=billingcycle,as=_billingcycle)
	 * @var string
	 */
	protected $_billingcycle;

	/**
	 * @var client
	 */
	private $_client;

	/**
	 * @var server
	 */
	private $_server;

	/**
	 * @var main\models\whmcs\product\product
	 */
	private $_product;

	/**
	 * @var main\models\whmcs\service\customFields\repository
	 */
	private $_customFields;

	/**
	 * @var main\models\whmcs\service\configOption\repository
	 */
	private $_configOptions;

	/**
	 * Load Account
	 *
	 * @param int $id
	 * @param array $data
	 * @throws main\mgLibs\exceptions\systemLoad
	 */
	function __construct($id = null, $data = array())
	{
		$this->id = $id;
		$this->load($data);
	}

	/**
	 * Set Object Properties
	 *
	 * @param array $data
	 * @throws main\mgLibs\exceptions\system
	 */
	function load(array $data = array())
	{
		if (empty($this->id) && !empty($data['serviceid']))
		{
			$this->id = $data['serviceid'];
		}

		if ($this->id !== null && empty($data))
		{
			$data = main\mgLibs\MySQL\query::select(static::fieldDeclaration(), static::tableName(), array('id' => $this->id))->fetch();
			if (empty($data))
			{
				throw new main\mgLibs\exceptions\system('Unable to find ' . get_class($this) . ' with ID:' . $this->id);
			}
		}

		if (isset($data['passwordEncrypted']))
		{
			$data['password'] = decrypt($data['passwordEncrypted']);
		}

		if (!empty($data['dedicatedip']))
		{
			$this->dedicatedIP = $this->IPList[] = $data['dedicatedip'];
		}

		if (!empty($data['assingedips']))
		{
			foreach (explode("\n", $data['assingedips']) as $ip)
			{
				if ($ip)
				{
					$this->IPList[] = $ip;
				}
			}
		}

		if (!empty($data['_domainstatus']))
		{
			$this->_status = $data['_domainstatus'];
			$this->_billingcycle = $data['_billingcycle'];
		}

		if (!empty($data['userid']))
		{
			$this->clientID = $data['userid'];
			$this->serverID = $data['serverid'];
			$this->domain = $data['domain'];
			$this->productID = $data['pid'];
			$this->username = $data['username'];
			$this->password = $data['password'];
		}

		if (!empty($data['server']))
		{
			$this->_server = $this->loadServer($data['serverid'], array(
				'hostname' => $data['serverhostname'],
				'username' => $data['serverusername'],
				'password' => $data['serverpassword'],
				'accesshash' => $data['serveraccesshash'],
				'secure' => $data['serversecure'],
				'ip' => $data['serverip']
			));
		}

		if (!empty($data['customfields']))
		{
			$this->_customFields = new main\models\whmcs\service\customFields\Repository($this->id, $data['customfields']);
		}

		if (!empty($data['configoptions']))
		{
			$this->_configOptions = new configOptions\Repository($this->id);
		}

		if (!empty($data['_orderid']))
		{
			$this->_orderid = $data['_orderid'];
		}

		if (!empty($data['nextDueDate']))
		{
			$this->nextDueDate = $data['nextDueDate'];
		}
	}

	/**
	 * Load Account Server
	 * Function allows to easy overwrite server object
	 *
	 * @param int $id
	 * @param array $data
	 * @return main\models\whmcs\servers\server
	 */
	protected function loadServer($id, $data = array())
	{
		return new main\models\whmcs\servers\Server($id, $data);
	}

	/**
	 * Get Server Connected With Service
	 *
	 * @return main\models\whmcs\servers\server
	 */
	public function server()
	{
		if (empty($this->_server))
		{
			$this->_server = $this->loadServer($this->serverID);
		}

		return $this->_server;
	}

	/**
	 * Get Client Connected with Service
	 *
	 * @return main\models\whmcs\clients\client
	 */
	function client()
	{
		if (empty($this->_client))
		{
			$this->_client = $this->loadClient();
		}

		return $this->_client;
	}

	/**
	 * Load Client
	 * Function allows to easy overwrite product object
	 *
	 * @param array $data
	 * @return main\models\whmcs\service\client
	 */
	protected function loadClient($data = array())
	{
		return new main\models\whmcs\clients\Client($this->clientID, $data);
	}

	/**
	 * Get Merged Configs from product configuration & custom fields & config options
	 *
	 * @return \stdClass
	 */
	function mergedConfig()
	{
		$obj = new \stdClass();
		foreach ($this->product()->configuration as $name => $value)
		{
			if (!empty($value))
			{
				$obj->$name = $value;
			}
		}

		foreach ($this->customFields()->toArray(false) as $name => $value)
		{
			if (!empty($value))
			{
				$obj->$name = $value;
			}
		}

		foreach ($this->configOptions()->toArray(false) as $name => $value)
		{
			if (!empty($value))
			{
				$obj->$name = $value;
			}
		}

		return $obj;
	}

	/**
	 * Get Product Service
	 *
	 * @return main\models\whmcs\product\product
	 */
	public function product()
	{
		if (empty($this->_product))
		{
			$this->_product = $this->loadProduct();
		}

		return $this->_product;
	}

	/**
	 * Load Product
	 * Function allows to easily overwrite product object
	 *
	 * @param array $data
	 * @return main\models\whmcs\product\product
	 */
	protected function loadProduct($data = array())
	{
		return new main\models\whmcs\product\Product($this->productID, $data);
	}

	/**
	 * Get Custom Fields
	 *
	 * @return customFields\repository
	 */
	function customFields()
	{
		if (empty($this->_customFields))
		{
			$this->_customFields = new main\models\whmcs\service\customFields\Repository($this->id);
		}

		return $this->_customFields;
	}

	/**
	 * Get Config Options
	 *
	 * @return configOptions
	 */
	function configOptions()
	{
		if (empty($this->_configOptions))
		{
			$this->_configOptions = new main\models\whmcs\service\configOptions\Repository($this->id);
		}

		return $this->_configOptions;
	}

	/**
	 * Save Account Settings
	 *
	 * @param array $cols
	 */
	function save($cols = array())
	{
		$cols['password'] = encrypt($this->password);

		if (($key = array_search($this->dedicatedIP, $this->IPList)) !== false)
		{
			unset($this->IPList[$key]);
		}

		$cols['assignedips'] = implode("\n", $this->IPList);

		parent::save($cols);
	}

	function getBillingCycleNumMonth()
	{
		switch ($this->billingcycle())
		{
			case 'Monthly':
				return 1;
			case 'Quarterly':
				return 3;
			case 'Semi-Annually':
				return 6;
			case 'Annually':
				return 12;
			case 'Biennially':
				return 24;
			case 'Triennially':
				return 36;
		}

		return 0;
	}

	function billingcycle()
	{
		if (empty($this->_billingcycle))
		{
			$this->load();
		}

		return $this->_billingcycle;
	}

	function status()
	{
		if (empty($this->_status))
		{
			$this->load();
		}

		return $this->_status;
	}

	function orderId()
	{
		if (empty($this->_orderid))
		{
			$this->load();
		}

		return $this->_orderid;
	}

	/**
	 * @return \MGModule\proxmoxAddon\models\recovery\RecoveryVM
	 */
	function getRecoveryVM($vserverID = '0')
	{
		$where = array("service_id" => $this->id);
		if ($vserverID !== '0')
		{
			$where['vserver_id'] = $vserverID;
		}

		$data = main\mgLibs\MySQL\query::select(main\models\recovery\RecoveryVM::fieldDeclaration(), main\models\recovery\RecoveryVM::tableName(), $where)->fetch();
		if (!empty($data['id']))
		{
			return new main\models\recovery\RecoveryVM ($data['id'], $data);
		}

		$obj = new main\models\recovery\RecoveryVM ();
		$obj->setServiceID($this->id);
		$obj->setServerID($this->serverID);
		$obj->setClientID($this->clientID);
		if ($vserverID !== '0')
		{
			$obj->setVserverID($vserverID);
		}

		return $obj;
	}
}
