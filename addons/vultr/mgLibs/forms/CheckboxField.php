<?php

namespace MGModule\vultr\mgLibs\forms;

use MGModule\vultr as main;

/**
 * CheckBox Form Field
 *
 * @SuppressWarnings(PHPMD)
 */
class CheckboxField extends AbstractField
{
	public $translateOptions = true;
	public $options;
	public $type = 'checkbox';
	public $inline = false;
	private $prepared = false;

	function prepare()
	{

		if ($this->prepared)
		{
			return;
		}

		$this->prepared = true;
		if (array_keys($this->options) == range(0, count($this->options) - 1))
		{
			$options = array();
			foreach ($this->options as $value)
			{
				$options[$value] = $value;
			}
			$this->options = $options;
		}
		else
		{
			$this->translateOptions = false;
		}

		if ($this->translateOptions)
		{
			$options = array();
			foreach ($this->options as $key => $value)
			{
				$options[$value] = main\mgLibs\Lang::T($this->name, 'options', $value);
			}
			$this->options = $options;
		}
	}
}