<?php
namespace MGModule\vultr\models\whmcs\emails;
use MGModule\vultr as main;

/**
 * Description of Repository
 */
class Templates extends main\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Template';
	}

	/**
	 * @return Template[]
	 */
	public function get()
	{
		return parent::get();
	}

	/**
	 * @return Template
	 */
	public function fetchOne()
	{
		return parent::fetchOne();
	}

	/**
	 * @return \MGModule\vultr\models\whmcs\emails\Templates
	 */
	public function onlyGeneral()
	{
		$this->_filters['type'] = "general";

		return $this;
	}

	/**
	 * @return \MGModule\vultr\models\whmcs\emails\Templates
	 */
	public function onlyAdmin()
	{
		$this->_filters['type'] = "admin";

		return $this;
	}

	/**
	 * @param string $name
	 * @return \MGModule\vultr\models\whmcs\emails\Templates
	 */
	public function onlyName($name)
	{
		$this->_filters['name'] = mysql_real_escape_string($name);

		return $this;
	}
}
