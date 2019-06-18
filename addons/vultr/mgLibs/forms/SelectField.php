<?php

namespace MGModule\vultr\mgLibs\forms;

use MGModule\vultr as main;


/**
 * Select Form Field
 *
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
class SelectField extends AbstractField
{
	public $translateOptions = true;
	public $addValueIfNotExits = false;
	public $options;
	public $select2 = false;
	public $multiple;

	function prepare()
	{
		if ($this->select2)
		{
			$this->type = 'select2';
			if (empty($this->addIDs))
			{
				$this->addIDs = 'RandID' . rand(0, 100);
			}
		}
		else
		{
			$this->type = 'select';
		}

		if ($this->translateOptions && array_keys($this->options) == range(0, count($this->options) - 1))
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

		if ($this->addValueIfNotExits)
		{
			if ($this->value && !isset($this->options[$this->value]))
			{
				$this->options[$this->value] = $this->value;
			}
		}

		if ($this->translateOptions)
		{
			if (!is_array($this->options))
			{
				throw new main\mgLibs\exceptions\System('Invalid Fields Options');
			}
			$options = array();
			foreach ($this->options as $value)
			{
				$options[$value] = main\mgLibs\Lang::T($this->formName, $this->name, 'options', $value);
			}
			$this->options = $options;
		}
	}
}