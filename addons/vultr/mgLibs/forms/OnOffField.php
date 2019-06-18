<?php

namespace MGModule\vultr\mgLibs\forms;

use MGModule\vultr as main;

/**
 * Test Form Field
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class OnOffField extends AbstractField
{
	public $enablePlaceholder = false;
	public $type = 'onoff';
}