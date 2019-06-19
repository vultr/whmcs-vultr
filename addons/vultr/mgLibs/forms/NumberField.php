<?php

namespace MGModule\vultr\mgLibs\forms;

use MGModule\vultr as main;

/**
 * Test Form Field
 */
class NumberField extends AbstractField
{
	public $enablePlaceholder = false;
	public $type = 'number';
	public $min = false;
	public $max = false;
}