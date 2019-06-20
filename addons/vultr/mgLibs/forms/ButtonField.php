<?php

namespace MGModule\vultr\mgLibs\forms;

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