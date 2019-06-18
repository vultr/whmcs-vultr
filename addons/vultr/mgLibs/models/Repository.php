<?php

namespace MGModule\vultr\mgLibs\models;

use MGModule\vultr as main;

/**
 * Description of abstractModel
 *
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
abstract class Repository
{
	protected $_filters = array();
	protected $_limit = null;
	protected $_offest = 0;
	protected $_order = array();

	public function __construct($columns = array(), $search = array())
	{
		if (!empty($columns))
		{
			$this->columns = $columns;
		}

		if (!empty($search))
		{
			$this->search = $search;
		}
	}

	function getProperyColumn($property)
	{
		return forward_static_call(array($this->getModelClass(), 'getProperyColumn'), $property);
	}

	abstract function getModelClass();

	public function limit($limit)
	{
		$this->_limit = $limit;
	}

	public function offset($offset)
	{
		$this->_offest = $offset;
	}

	public function sortBy($field, $vect)
	{
		$column = forward_static_call(array($this->getModelClass(), 'getProperyColumn'), $field);
		$this->_order[$column] = $vect;
	}

	/**
	 *
	 * @return orm
	 */
	function get()
	{
		$result = main\mgLibs\MySQL\Query::select(
			self::fieldDeclaration()
			, self::tableName()
			, $this->_filters
			, $this->_order
			, $this->_limit
			, $this->_offest
		);

		$output = array();

		$class = $this->getModelClass();

		while ($row = $result->fetch())
		{
			$output[] = new $class($row['id'], $row);
		}

		return $output;
	}

	public function fieldDeclaration()
	{
		return forward_static_call(array($this->getModelClass(), 'fieldDeclaration'));
	}

	public function tableName()
	{
		return forward_static_call(array($this->getModelClass(), 'tableName'));
	}

	function count()
	{
		$fields = $this->fieldDeclaration();
		$first = key($fields);

		if (is_numeric($first))
		{
			$first = $fields[$first];
		}
		return main\mgLibs\MySQL\Query::count(
			$first
			, self::tableName()
			, $this->_filters
			, array()
			, $this->_limit
			, $this->_offest
		);
	}

	function delete()
	{
		return main\mgLibs\MySQL\Query::delete(
			self::tableName()
			, $this->_filters
		);
	}

	/**
	 *
	 * @param array $ids
	 * @return \MGModule\vultr\mgLibs\models\Repository
	 */
	public function idIn(array $ids)
	{

		foreach ($ids as &$id)
		{
			$id = (int)$id;
		}

		if (!empty($ids))
		{
			$this->_filters['id'] = $ids;
		}

		return $this;
	}

	/**
	 *
	 * @return Repository
	 */
	public function resetFilters()
	{
		$this->_filters = array();
		$this->_order = array();
		$this->_limit = null;
		return $this;
	}

	/**
	 *
	 * @return orm
	 * @throws main\mgLibs\exceptions\System
	 */
	public function fetchOne()
	{

		$result = main\mgLibs\MySQL\Query::select(
			self::fieldDeclaration()
			, self::tableName()
			, $this->_filters
			, $this->_order
			, 1
			, 0
		);

		$class = $this->getModelClass();
		$row = $result->fetch();
		if (empty($row))
		{
			$criteria = array();
			foreach ($this->_filters as $k => $v)
			{
				$criteria[] = "{$k}: $v";
			}
			$criteria = implode(", ", $criteria);
			throw new main\mgLibs\exceptions\System("Unable to find '{$class}' with criteria: ({$criteria}) ");
		}

		return new $class($row['id'], $row);
	}

	public function setSearch($search)
	{
		if (!$search)
		{
			return;
		}
		$search = mysql_real_escape_string($search);
		$filter = array();
		foreach ($this->search as $value)
		{
			$value = str_replace('?', $search, $value);
			$filter[] = "  $value ";
		}
		if (empty($filter))
		{
			return false;
		}
		$sql = implode("OR", $filter);
		if ($sql)
		{
			$this->_filters[] = ' (' . $sql . ') ';
		}
	}
}
