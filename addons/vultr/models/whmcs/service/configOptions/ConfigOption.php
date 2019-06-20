<?php

namespace MGModule\vultr\models\whmcs\service\configOptions;

class ConfigOption
{
	public $id;
	public $name;
	public $type;
	public $frendlyName;
	public $value;
	public $options = array();
	public $optionsIDs = array();
}