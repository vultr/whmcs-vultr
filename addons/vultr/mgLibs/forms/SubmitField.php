<?php

namespace MGModule\vultr\mgLibs\forms;

use MGModule\vultr as main;


/**
 * Submit Form Button
 */
class SubmitField extends AbstractField
{
	public $icon;
	public $color = 'success btn-inverse';
	public $type = 'submit';
	public $enableContent = true;
}