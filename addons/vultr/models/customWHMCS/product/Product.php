<?php

namespace MGModule\vultr\models\customWHMCS\product;


/**
 * @SuppressWarnings(PHPMD)
 */
class Product extends MGModule\vultr\models\whmcs\product\product
{

	function loadConfiguration($params)
	{
		return new Configuration($this->id);
	}

}