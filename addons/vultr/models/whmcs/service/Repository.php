<?php

namespace MGModule\vultr\models\whmcs\service;

/**
 * Description of repository
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository
{
	public function getModelClass()
	{
		return __NAMESPACE__ . '\Service';
	}

	/**
	 * @return service
	 */
	public function get()
	{
		return parent::get();
	}

	/**
	 * @param int $clientId
	 * @return \MGModule\vultr\models\whmcs\service\Repository
	 */
	public function onlyClient($clientId)
	{
		$this->_filters['userid'] = (int)$clientId;

		return $this;
	}

	/**
	 * @param array $status
	 * @return \MGModule\vultr\models\whmcs\service\Repository
	 */
	public function onlyStatus(array $status)
	{
		$this->_filters['domainstatus'] = $status;

		return $this;
	}

	public function usernameNotNull()
	{
		$this->_filters[] = ' username != "" ';

		return $this;
	}
}
