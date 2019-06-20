<?php

namespace MGModule\vultr\mgLibs\exceptions;

/**
 * Exception Codes
 */
class Codes
{
	const MISSING_FILE_CLASS = 1;
	const PROPERTY_NOT_EXISTS = 2;
	const MISSING_OBJECT_PROPERTY = 3;

	// Database
	const MYSQL_CONNECTION_FAILED = 100;
	const MYSQL_QUERY_FAILED = 101;
	const MYSQL_MISSING_CONNECTION = 102;
	const MYSQL_MISSING_CONFIG_FILE = 103;
	const MYSQL_MISSING_PDO_EXTENSION = 104;
}
