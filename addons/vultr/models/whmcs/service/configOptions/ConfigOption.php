<?php

namespace MGModule\vultr\models\whmcs\service\configOptions;

use MGModule\vultr as main;

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