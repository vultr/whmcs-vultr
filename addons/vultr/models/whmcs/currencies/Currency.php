<?php
namespace MGModule\vultr\models\whmcs\currencies;
use MGModule\vultr as main;

/**
 * Description of Currency
 *
 * @Table(name=tblcurrencies,preventUpdate,prefixed=false)
 */
class Currency extends main\mgLibs\models\Orm
{

	/**
	 * @Column()
	 * @var int
	 */
	protected $id;

	/**
	 * @Column(name=code)
	 * @var string
	 */
	protected $code;

	/**
	 * @Column(name=prefix)
	 * @var string
	 */
	protected $prefix;

	/**
	 * @Column(name=suffix)
	 * @var string
	 */
	protected $suffix;

	/**
	 * @Column(name=format)
	 * @var int
	 */
	protected $format;

	/**
	 * @Column(name=rate)
	 * @var int
	 */
	protected $rate;

	/**
	 * @Column(name=default)
	 * @var int
	 */
	protected $default;

	public function __construct($id = false, $data = array())
	{
		if ($id === "0")
		{
			$row = main\mgLibs\MySQL\Query::select(array("id"), self::tableName(), array("default" => "1"))->fetch();
			$id = $row['id'];
		}

		parent::__construct($id, $data);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getPrefix()
	{
		return $this->prefix;
	}

	public function getSuffix()
	{
		return $this->suffix;
	}

	public function getFormat()
	{
		return $this->format;
	}

	public function getRate()
	{
		return $this->rate;
	}

	public function getDefault()
	{
		return $this->default;
	}
}
