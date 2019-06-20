<?php

namespace MGModule\vultr\mgLibs\forms;

use MGModule\vultr as main;

/**
 * Password Form Field
 */
class PasswordField extends AbstractField
{
	public $showPassword = false;
	public $type = 'password';

	function prepare()
	{
		if (!$this->showPassword)
		{
			self::asteriskVar($this->value);
		}
	}

	static function asteriskVar($input)
	{
		$num = strlen($input);
		$input = '';

		for ($i = 0; $i < $num; $i++)
		{
			$input .= '*';
		}

		return $input;
	}
}