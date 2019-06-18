<?php

namespace MGModule\vultr\models\whmcs\service\configOptions;

use MGModule\vultr as main;

/**
 * Description of repository
 *
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
class Repository
{
	private $serviceID;
	/**
	 *
	 * @var configOption[]
	 */
	private $_configOptions = array();

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
				$field = new configOption();
				$field->name = $name;
				$field->value = $value;
				$this->_configOptions[$field->name] = $field;
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
                V.id
                ,V.optionid
                ,V.qty
                ,O.optionname
                ,O.optiontype
                ,S.id as suboptionid
                ,S.optionname as suboptionname
            FROM
                tblhostingconfigoptions V
            JOIN
                tblproductconfigoptions O
                ON
                    V.configid = O.id
            JOIN
                tblproductconfiglinks L
                ON
                    L.gid = O.gid
            JOIN
                tblhosting H
                ON
                    H.packageid = L.pid
                    AND H.id = V.relid
            LEFT JOIN
                tblproductconfigoptionssub S
                ON
                    S.configid = O.id
            WHERE
                H.id = :service_id:
        ";

		$result = \MGModule\vultr\mgLibs\MySQL\Query::query($query, array(
			'service_id' => $this->serviceID
		));

		while ($row = $result->fetch())
		{
			$tmp = explode('|', $row['optionname']);

			$name = $friendlyName = $tmp[0];

			if (isset($tmp[1]))
			{
				$friendlyName = $tmp[1];
			}

			if (isset($this->_configOptions[$name]))
			{
				$field = $this->_configOptions[$name];
			}

			$field = new configOption();
			$field->id = $row['id'];
			$field->name = $name;
			$field->frendlyName = $friendlyName;

			$tmp = explode('|', $row['suboptionname']);

			$value = $valueLabel = $tmp[0];

			if (isset($tmp[1]))
			{
				$valueLabel = $tmp[1];
			}

			switch ($row['optiontype'])
			{
				case 1:
				case 2:
					$field->optionsIDs[$value] = $row['suboptionid'];
					$field->options[$value] = $valueLabel;

					if ($row['suboptionid'] == $row['optionid'] && empty($field->value))
					{
						$field->value = $value;
					}
					break;
				case 3:
				case 4:
					$field->value = $row['qty'];
					$field->value = $row['qty'];
					break;
			}

			$this->_configOptions[$field->name] = $field;
		}
	}

	function __isset($name)
	{
		return $this->_configOptions[$name];
	}

	function __get($name)
	{
		if (isset($this->_configOptions[$name]))
		{
			return $this->_configOptions[$name]->value;
		}
	}

	function __set($name, $value)
	{
		if (isset($this->_configOptions[$name]))
		{
			$this->_configOptions[$name]->value = $value;
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

		foreach ($this->_configOptions as $field)
		{
			$cols = array();

			switch ($field->type)
			{
				case 1:
				case 2:
					$cols['optionid'] = $field->optionsIDs[$field->value];
					break;
				case 3:
				case 4:
					$cols['qty'] = $field->value;
					break;
			}

			main\mgLibs\MySQL\Query::update(
				'tblhostingconfigoptions'
				, $cols
				, array(
					'id' => $field->id
				)
			);
		}
	}
}
