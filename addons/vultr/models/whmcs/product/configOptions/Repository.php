<?php

namespace MGModule\vultr\models\whmcs\product\configOptions;

use MGModule\vultr as main;

/**
 * Product Custom Fields Collection
 */
class Repository
{
	static private $configuration;
	private $_groups = array();
	private $_assignedids = array();

	function __construct($productIds)
	{
		if (!empty($productIds))
		{
			$this->assigedToProduct($productIds);
			$this->get();
		}
	}

	public function assigedToProduct($productIds)
	{
		if (is_array($productIds))
		{
			$this->_assignedids = array();
			foreach ($productIds as $pid)
			{
				$this->_assignedids[] = (int)$pid;
			}
		}
		else
		{
			$this->_assignedids[] = (int)($productIds);
		}
	}

	/**
	 * Load Product Custom Fields
	 *
	 * @param int $productID
	 */
	function get()
	{
		$sql = '
		SELECT id, name, description, pid 
		FROM tblproductconfiggroups G
		LEFT JOIN tblproductconfiglinks L
			ON L.gid = G.id';

		$condition = array();

		if ($this->_assignedids)
		{
			$condition = "L.pid in (" . implode(',', $this->_assignedids) . ")";
		}

		if ($condition)
		{
			$sql .= " WHERE " . $condition;
		}

		$result = main\mgLibs\MySQL\Query::query($sql);

		while ($row = $result->fetch())
		{
			if (isset($this->_groups[$row['id']]))
			{
				$this->_groups[$row['id']]->addPID($row['pid']);
			}
			else
			{
				$this->_groups[$row['id']] = new main\models\whmcs\product\configOptions\group($row['id'], $row);
			}
		}

		return $this->_groups;
	}

	static function setConfiguration(array $configuration)
	{
		self::$configuration = $configuration;
	}

	/**
	 * Compare current Fields with Declaration from Module Configuration
	 *
	 * @param bool $onlyRequired
	 * @return array
	 */
	function checkFields(array $configuration = array())
	{
		if (empty($configuration))
		{
			$configuration = self::$configuration;
		}

		$missingFields = array();
		foreach ($configuration as $fieldDeclaration)
		{
			$found = false;
			foreach ($this->_groups as $field)
			{
				if ($fieldDeclaration->name === $field->name)
				{
					$found = true;

					break;
				}
			}
			if (!$found)
			{
				$name = (empty($fieldDeclaration->friendlyName)) ? $fieldDeclaration->name : $fieldDeclaration->friendlyName;
				$missingFields[$fieldDeclaration->name] = $name;
			}
		}

		return $missingFields;
	}


	/**
	 * Generate Custom Fields Depends on declaration in Module Configuration
	 * @param array $configuration
	 */
	function generateFromConfiguration(array $configuration = array())
	{
		if (empty($configuration))
		{
			$configuration = self::$configuration;
		}

		foreach ($configuration as $fieldDeclaration)
		{
			$found = false;
			foreach ($this->_groups as $field)
			{
				if ($fieldDeclaration->name === $field->name)
				{
					$found = true;
					break;
				}
			}
		}
	}
}
