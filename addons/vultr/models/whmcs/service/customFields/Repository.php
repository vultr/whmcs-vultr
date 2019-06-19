<?php

namespace MGModule\vultr\models\whmcs\service\customFields;

use MGModule\vultr as main;

/**
 * Description of repository
 */
class Repository
{
	public $serviceID;
	private $_customFields;

	/**
	 * @param type $accountID
	 */
	function __construct($serviceID, array $data = array())
	{
		$this->serviceID = $serviceID;
		if ($data)
		{
			foreach ($data as $name => $value)
			{
				$field = new CustomField();
				$field->name = $name;
				$field->value = $value;
				$this->_customFields[$field->name] = $field;
			}
		}
		else
		{
			$this->load();
		}
	}

	function load()
	{
		$query = '
		SELECT C.fieldname as name, V.fieldid as fieldid, V.value as value
		FROM tblcustomfieldsvalues V
		JOIN tblcustomfields C
			ON C.id = V.fieldid
			AND C.type = \'product\'
		JOIN tblhosting H
			ON V.relid = H.id
			And C.relid = H.packageid
		WHERE H.id = :account_id:';

		$result = \MGModule\vultr\mgLibs\MySQL\Query::query($query, array(':account_id:' => $this->serviceID));

		while ($row = $result->fetch())
		{
			$name = explode('|', $row['name']);
			if (isset($this->_customFields[$name[0]]))
			{
				$this->_customFields[$name[0]]->id = $row['fieldid'];
			}
			else
			{
				$field = new CustomField();
				$field->id = $row['fieldid'];
				$field->name = $name[0];
				$field->value = $row['value'];

				$this->_customFields[$field->name] = $field;
			}
		}
	}

	function __isset($name)
	{
		return $this->_customFields[$name];
	}

	function __get($name)
	{
		if (isset($this->_customFields[$name]))
		{
			return $this->_customFields[$name]->value;
		}
	}

	function __set($name, $value)
	{
		if (isset($this->_customFields[$name]))
		{
			$this->_customFields[$name]->value = $value;
		}
	}

	/**
	 * Update Custom Fields
	 */
	function update()
	{
		$this->load();

		foreach ($this->_customFields as $field)
		{
			$data['value'] = $field->value;
			$condition['fieldid'] = $field->id;
			$condition['relid'] = $this->serviceID;
			main\mgLibs\MySQL\Query::update('tblcustomfieldsvalues', $data, $condition);
		}
	}
}
