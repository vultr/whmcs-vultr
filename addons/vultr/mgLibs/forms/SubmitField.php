<?php

namespace MGModule\vultr\mgLibs\forms;


/**
 * Submit Form Button
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class SubmitField extends AbstractField
{
	public $icon;
	public $color = 'success btn-inverse';
	public $type = 'submit';
	public $enableContent = true;
}