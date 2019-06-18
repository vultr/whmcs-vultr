<?php

namespace MGModule\vultr\models\whmcs\clients\customFields;

use MGModule\vultr as main;

/**
 * Description of repository
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Repository
{
	public $serviceID;
	private $_customFields;

	/**
	 * Mozna by bylo dodac wersje z wczytywanie po samym productid
	 *
	 * @param type $accountID
	 * @author Michal Czech <michael@modulesgarden.com>
	 */
	function __construct($serviceID, array $data = array())
	{
		$this->serviceID = $serviceID;

		if ($data)
		{
			foreach ($data as $name => $value)
			{
				$field = new customField();
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
		$query = "
            SELECT
                C.fieldname as name
                ,V.fieldid  as fieldid
                ,V.value    as value
            FROM
                tblcustomfieldsvalues V
            JOIN
                tblcustomfields C
                ON
                    V.fieldid = C.id
                    AND C.type = 'client'
            WHERE
                V.relid = :account_id:
        ";

		$result = \MGModule\vultr\mgLibs\MySQL\Query::query($query, array(
			'account_id' => $this->serviceID
		));

		while ($row = $result->fetch())
		{
			$name = explode('|', $row['name']);

			if (isset($this->_customFields[$name[0]]))
			{
				$this->_customFields[$name[0]]->id = $row['fieldid'];
			}
			else
			{
				$field = new customField();
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
	 *
	 * @author Michal Czech <michael@modulesgarden.com>
	 */
	function update()
	{
		$this->load();

		foreach ($this->_customFields as $field)
		{
			main\mgLibs\MySQL\Query::update(
				'tblcustomfieldsvalues'
				, array(
					'value' => $field->value
				)
				, array(
					'fieldid' => $field->id
				, 'relid' => $this->serviceID
				)
			);
		}
	}
}
