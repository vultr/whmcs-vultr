<?php
namespace MGModule\vultr\models\whmcs\product;
use MGModule\vultr as main;

/**
 * Description of ProductGroup
 *
 * @Table(name=tblproductgroups,preventUpdate,prefixed=false)
 */
class ProductGroup extends main\mgLibs\models\Orm
{

	/**
	 * @Column(int)
	 * @var int
	 */
	protected $id;

	/**
	 * @Column(name=name,as=name)
	 * @var string
	 */
	protected $name;

	/**
	 * @Column(name=headline,as=headLine)
	 * @var string
	 */
	protected $headLine;

	/**
	 * @Column(name=tagline,as=tagLine)
	 * @var string
	 */
	protected $tagLine;

	/**
	 * @Column(name=orderfrmtpl,as=orderForm)
	 * @var string
	 */
	protected $orderForm;

	/**
	 * @Column(name=disabledgateways,as=disabledGateways)
	 * @var string
	 */
	protected $disabledGateways;

	/**
	 * @Column(name=hidden)
	 * @var string
	 */
	protected $hidden;

	/**
	 * @Column(name=order)
	 * @var string
	 */
	protected $order;

	/**
	 * @Column(name=created_at,as=createdAt)
	 * @var string
	 */
	protected $createdAt;

	/**
	 * @Column(name=updated_at,as=updatedAt)
	 * @var string
	 */
	protected $updatedAt;

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getHeadLine()
	{
		return $this->headLine;
	}

	public function getTagLine()
	{
		return $this->tagLine;
	}

	public function getOrderForm()
	{
		return $this->orderForm;
	}

	public function getDisabledGateways()
	{
		return $this->disabledGateways;
	}

	public function getHidden()
	{
		return $this->hidden;
	}

	public function getOrder()
	{
		return $this->order;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

}

    
    
    