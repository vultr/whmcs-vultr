<?php

namespace MGModule\vultr\mgLibs\MySQL;

use MGModule\vultr as main;

/**
 * MySQL Exception
 */
class Exception extends main\mgLibs\exceptions\System
{
	private $_query;

	public function __construct($message, $query, $code = 0, $previous = null)
	{
		$this->_query = $query;
		$code = (int)$code;
		parent::__construct($message, $code, $previous);
	}
}
