<?php
namespace MGModule\vultr\models\whmcs\admins;
use MGModule\vultr as main;

/**
 * Description of Roles
 *
 * @Table(name=tbladminroles,preventUpdate,prefixed=false)
 */
class Role extends main\mgLibs\models\Orm
{
	/**
	 * @Column(id)
	 * @var int
	 */
	protected $id;

	/**
	 * @Column()
	 * @var string
	 */
	protected $name;

	function getId()
	{
		return $this->id;
	}

	function getName()
	{
		return $this->name;
	}

}
