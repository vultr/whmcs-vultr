<?php

namespace MGModule\vultr\mgLibs\exceptions;

/**
 * Use for general module errors
 */
class validation extends System
{
	private $fields = array();

	public function __construct($message, array $fields = array())
	{
		$this->fields = $fields;
		parent::__construct($message);
	}

	function getFields()
	{
		return $this->fields;
	}
}
