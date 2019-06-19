<?php

namespace MGModule\vultr\mgLibs\forms;

use MGModule\vultr as main;

/**
 * Button Form Field
 */
class ButtonField extends AbstractField
{
	public $icon;
	public $color = 'success';
	public $type = 'button';
	public $enableContent = true;
	public $textLabel = false;
}