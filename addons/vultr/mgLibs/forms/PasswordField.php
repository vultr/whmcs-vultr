<?php

namespace MGModule\vultr\mgLibs\forms;

/**
 * Password Form Field
 *
 * @author Michal Czech <michael@modulesgarden.com>
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