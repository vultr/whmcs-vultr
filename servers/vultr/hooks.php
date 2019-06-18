<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require 'loader.php';

add_hook('AdminAreaHeadOutput', 1, function ($params){
	if ($params['filename'] == 'configproducts' && isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']))
	{
		$productID = (int)$_GET['id'];
		$product = Capsule::table('tblproducts')->select('id')->where('servertype', 'vultr')->where('id', $productID)->first();
		if ($product)
		{
			$script = str_replace('#id#', $productID, file_get_contents(__DIR__ . DS . 'assets' . DS . 'js' . DS . 'configproducts.js'));
			$return = '<script type="text/javascript">' . $script . '</script>';
			return $return;
		}
	}
});
