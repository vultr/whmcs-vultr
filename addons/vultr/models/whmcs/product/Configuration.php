<?php

namespace MGModule\vultr\models\whmcs\product;
use MGModule\vultr as main;

/**
 * Description of configuration
 *
 * @SuppressWarnings(PHPMD)
 */
class Configuration
{
	private static $_configurationArray;
	private $_productID;
	private $_configuration;

	function __construct($productID, array $params = array())
	{
		if (empty($productID))
		{
			throw new main\mgLibs\exceptions\System('Provide Product ID at first');
		}

		$this->_productID = $productID;

		if (!isset($params['configoption1']))
		{
			$fields = array();
			for ($i = 1; $i < 25; $i++)
			{
				$fields['configoption' . $i] = 'configoption' . $i;
			}

			$params = main\mgLibs\MySQL\Query::select($fields, 'tblproducts', array('id' => $productID))->fetch();
		}

		if (empty(self::$_configurationArray))
		{
			$mainConfig = main\mgLibs\process\MainInstance::I()->configuration();

			if (method_exists($mainConfig, 'getServerWHMCSConfig'))
			{
				$config = $mainConfig->getServerWHMCSConfig();
				if (is_array($config))
				{
					self::$_configurationArray = $config;
				}
			}
		}

		if (is_array(self::$_configurationArray) && !empty(self::$_configurationArray))
		{
			$i = 1;
			foreach (self::$_configurationArray as $name)
			{
				$this->_configuration[$name] = $params['configoption' . $i];
				$i++;
			}
		}
		else
		{
			for ($i = 1; $i < 25; $i++)
			{
				$this->_configuration[$i] = $params['configoption' . $i];
			}
		}
	}

	static function setDefaultConfigurationArray($configurationArray)
	{
		self::$_configurationArray = $configurationArray;
	}

	function setConfigurationArray(array $configurationArray = array())
	{
		if (empty($configurationArray))
		{
			$configurationArray = self::$_configurationArray;
		}

		$i = 1;
		foreach ($configurationArray as $name)
		{
			if (isset($this->_configuration[$i]))
			{
				$this->_configuration[$name] = $this->_configuration[$i];
				unset($this->_configuration[$i]);
			}

			$i++;
		}
	}

	function __get($name)
	{
		return $this->_configuration[$name];
	}

	function __set($name, $value)
	{
		$this->_configuration[$name] = $value;
	}

	function __isset($name)
	{
		return isset($this->_configuration[$name]);
	}

	function save()
	{
		$params = array();
		if (self::$_configurationArray)
		{
			$i = 1;
			foreach (self::$_configurationArray as $name)
			{
				$params['configoption' . $i] = $this->_configuration[$name];
				$i++;
			}
		}
		else
		{
			for ($i = 1; $i < 25; $i++)
			{
				$params['configoption' . $i] = $this->_configuration[$i];
				$i++;
			}
		}

		main\mgLibs\MySQL\Query::update('tblproducts', $params, array('id' => $this->_productID));
	}
}
