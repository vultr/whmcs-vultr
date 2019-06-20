<?php

namespace MGModule\vultr\controllers\addon\admin;

use MGModule\vultr as main;

/**
 * Description of actions
 */
class Home extends main\mgLibs\process\AbstractController
{

	/**
	 *
	 *
	 * @author Michal Czech <michael@modulesgarden.com>
	 */
	function indexHTML($input = array(), $vars = array())
	{
		return array(
			'tpl' => 'home',
			'vars' => $vars,
			'input' => $input
		);
	}

}
