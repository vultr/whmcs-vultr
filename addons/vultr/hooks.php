<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use MGModule\vultr as main;

require_once(dirname(dirname(__DIR__)) . "/servers/vultr/helper/vultr.helper.php");
require_once(dirname(dirname(__DIR__)) . "/servers/vultr/helper/lang.helper.php");

function vultrCronJob()
{
	require_once 'Loader.php';
	new main\Loader();

	try
	{
		//set instance
		main\Addon::I(true);
		$repo = new main\models\whmcs\service\Repository();
		foreach ($repo->get() as $service)
		{
			if ($service->id != 6)
			{
				continue;
			}

			$email = main\mgLibs\whmcsAPI\WhmcsAPI::request('getemails', array('clientid' => $service->clientID));
			$num = count($email);
			$service->customFields()->num = $num;
			$service->customFields()->update();
		}
	}
	catch (\Exception $ex)
	{
		main\mgLibs\error\Register::register($ex);
		main\Addon::vultrDump($ex);
	}
}

add_hook("AdminAreaPage", 1, "vultrCronJob");
function saveAddonConfig($vars)
{
	if ($vars['filename'] == "configaddonmods" && $_REQUEST['saved'] == "true")
	{
		if ($_POST['moduleName'] && $_POST['apiKey'])
		{
			require_once 'Loader.php';
			new main\Loader();

			try
			{
				$api = main\helpers\ApiHelper::getAPI($_POST['apiKey']);
				if ($api->response_code == 200)
				{
					$response = ['success' => 'true'];
				}
				else
				{
					$response = ['success' => 'Please check your API key.'];
				}
			}
			catch (Exception $ex)
			{
				$response = ['success' => $ex->getMessage()];
			}
			echo json_encode($response);

			die();
		}
		else
		{
			return <<<HTML
            <script type="text/javascript">
             jQuery( document ).ready(function(){
                var moduleName = localStorage.getItem('module');
                var apiKey = localStorage.getItem('apiKey');
                 serviceUrl = "configaddonmods.php?saved=true";

                 if(moduleName == 'vultr'){
                     var data = {
                         moduleName: moduleName,
                         apiKey: apiKey,
                     }
                     jQuery.ajax({
                             type: "POST",
                             url: serviceUrl,
                             data: data,
                             beforeSend: function () {
                                 localStorage.removeItem('module');
                                 jQuery('html, body').animate({scrollTop:$('#contentarea').position().top}, 'slow');
                                 jQuery('#contentarea').find('.infobox').html('<strong><span class="title">Changes Saved Successfully!</span></strong><br>Checking API Connection. Loading <i class="fa fa-spinner fa-spin"></i>');  
                             },
                             success: function (ret) {
                                var data = JSON.parse(ret);
                                if(data.success == 'true'){
                                    jQuery('#contentarea').find('.infobox').html('<strong><span class="title">Changes Saved Successfully!</span></strong><br><font color="green"><b>Connection Success.</b></font>'); 
                                }
                                else{
                                    jQuery('#contentarea').find('.infobox').html('<strong><span class="title">Changes Saved Successfully!</span></strong><br><font color="red"><b>Connection Failed: '+ data.success +'</b></font'); 
                                }
                             }
                      })
                 }
             });
            </script>
HTML;
		}
	}
}

add_hook("AdminAreaFooterOutput", 1, "saveAddonConfig");
function getConfigOptionId($optionname)
{
	$optionId = \WHMCS\Database\Capsule::table("tblproducts")
		->join("tblproductconfiglinks", "tblproductconfiglinks.pid", "=", "tblproducts.id")
		->join("tblproductconfiggroups", "tblproductconfiggroups.id", "=", "tblproductconfiglinks.gid")
		->join("tblproductconfigoptions", "tblproductconfigoptions.gid", "=", "tblproductconfiggroups.id")
		->select("tblproductconfigoptions.id")
		->where("tblproducts.id", "=", $_SESSION['cart']['products'][$_GET['i']]['pid'])
		->where("tblproductconfigoptions.optionname", "=", $optionname)
		->first();

	return $optionId;
}

add_hook('ClientAreaHeadOutput', 1, function ($params)
{
	if (isset($_GET['a']) && $_GET['a'] === 'confproduct')
	{
		$fields = VultrHelper::getAllOSAndAppCustomFields();
		$head_return = '
		<script type="text/javascript">
            $(document).ready(function(){';
		foreach ($fields as $value)
		{
			if (isset($value['appID']))
			{
				$head_return .= '
				$(\'select[name="configoption[' . $value['id'] . ']"]\').on(\'change\',function(){
					if($(this).val()==' . $value['appID']->id . ')
					{
						$(\'select[name="configoption[' . $value['app'] . ']"] option:first\').hide();
						$(\'select[name="configoption[' . $value['app'] . ']"]\').parent().parent().show();
						$(\'select[name="configoption[' . $value['app'] . ']"]\').val($(\'select[name="configoption[' . $value['app'] . ']"] option:eq(1)\').val());
						$(\'select[name="configoption[' . $value['app'] . ']"]\').trigger(\'change\');
					}
					else 
					{
						$(\'select[name="configoption[' . $value['app'] . ']"] option:first\').show();
						$(\'select[name="configoption[' . $value['app'] . ']"]\').parent().parent().hide();
						$(\'select[name="configoption[' . $value['app'] . ']"]\').val($(\'select[name="configoption[' . $value['app'] . ']"] option:first\').val());
						$(\'select[name="configoption[' . $value['app'] . ']"]\').trigger(\'change\');
					}
				});
				$(\'select[name="configoption[' . $value['id'] . ']"]\').trigger(\'change\');';
			}
		}
		$head_return .= '})</script>';
		return $head_return;
	}

	if (isset($_SESSION['vultrUpgrade']))
	{
		$script = $_SESSION['vultrUpgrade'];
		unset($_SESSION['vultrUpgrade']);

		return $script;
	}

	if (isset($_GET['action']) && $_GET['action'] == "productdetails")
	{
		foreach ($params['configurableoptions'] as $value)
		{
			if ($value['optionname'] == "Application" && $value['selectedname'] == "None")
			{
				$hiddenItemName = "Application";
			}

			if ($value['optionname'] == "OS Type" && $value['selectedname'] == "Application")
			{
				$hiddenItemName = "OS Type";
			}
		}

		return '
            <script type="text/javascript">
                $(document).ready(function() {
                    $("div#configoptions strong:contains(\'{$hiddenItemName}\')").closest(".row").hide();
                });    
            </script>';
	}
});

add_hook("ClientAreaFooterOutput", 1, function ($params)
{
	if (isset($_GET['a']) && $_GET['a'] === 'confproduct')
	{
		require_once 'Loader.php';
		new main\Loader();

		$productInfo = WHMCS\Database\Capsule::table("tblproducts")
			->select("tblproducts.configoption2", "tblproducts.servertype")
			->where("tblproducts.id", "=", $_SESSION['cart']['products'][$_GET['i']]['pid'])
			->first();

		if ($productInfo->servertype !== "vultr")
		{
			return;
		}

		$productPlanId = $productInfo->configoption2;
		$apiToken = \WHMCS\Database\Capsule::table("tbladdonmodules")
			->select("tbladdonmodules.value")
			->where("tbladdonmodules.module", "=", "vultr")
			->where("tbladdonmodules.setting", "=", "apiToken")
			->first();

		$vultrAPI = main\helpers\ApiHelper::getAPI($apiToken->value);
		$plans = $vultrAPI->plans_list();
		$ramAmount = $plans[$productPlanId]['bandwidth_gb'];

		$OSTypeOptionId = getConfigOptionId("os_type|OS Type");
		$OSTypeOptionId = $OSTypeOptionId->id;
		$applicationOptionId = getConfigOptionId("application|Application");
		$applicationOptionId = $applicationOptionId->id;
		if ($ramAmount < 2048)
		{

			return '
            <script type="text/javascript">
                $(document).ready(function(){
             
                    $("#inputConfigOption" + "{$OSTypeOptionId}" + " option:contains(\'Windows\')").remove();
                    $("#inputConfigOption" + "{$applicationOptionId}" + " option:contains(\'cPanel\')").remove();
                });
            </script>';
		}
	}
});

add_hook('ClientAreaPage', 1, function ($params)
{
	if (isset($_POST['VultrAction']))
	{
		ob_clean();
		$return = array();
		switch ($_POST['VultrAction'])
		{
			case 'start':
				$return = VultrHelper::startVMAction($params);
			break;

			case 'reboot':
				$return = VultrHelper::rebootVMAction($params);
			break;

			case 'stop':
				$return = VultrHelper::stopVMAction($params);
			break;

			case 'reinstall':
				$return = VultrHelper::reinstallVMAction($params);
			break;

			case 'checkStatus':
				$return = VultrHelper::checkStatusVMAction($params);
			break;

			case 'checkVMStatus':
				$return = VultrHelper::checkStatusVMAction($params);
				if ($return['power_status'] == 'running' && $return['vm_status'] == 'active')
				{
					$return['reload'] = true;
				}
				else
				{
					$return['reload'] = false;
				}
			break;

			default:
				$return = array('status' => 'error', 'message' => LangHelper::T('core.hook.unknown_operation'));
			break;
		}
		header('Content-Type: application/json');
		echo json_encode($return);

		die;
	}
});

add_hook('ClientAreaPageUpgrade', 1, function ($params)
{
	if (!VultrHelper::checkIsVultrUpgrade($params['id']))
	{
		return;
	}
	$script = '
	<script type="text/javascript">
		$(document).ready(function () {';
	if (isset($params['configoptions']))
	{
		$autoBackupFieldID = VultrHelper::getFieldId($params['id'], 'auto_backups');
		if ($autoBackupFieldID)
		{
			$script .= '$(\'[name="configoption[' . $autoBackupFieldID . ']"]\').parent(\'td\').parent(\'tr\').hide();';
		}

		$osFieldID = VultrHelper::getFieldId($params['id'], 'os_type');
		if ($osFieldID)
		{
			$script .= '$(\'[name="configoption[' . $osFieldID . ']"]\').parent(\'td\').parent(\'tr\').hide();';
		}

		$appFieldID = VultrHelper::getFieldId($params['id'], 'application');
		if ($appFieldID)
		{
			$script .= '$(\'[name="configoption[' . $appFieldID . ']"]\').parent(\'td\').parent(\'tr\').hide();';
		}

		foreach ($params['configoptions'] as $k => $v)
		{
			if ($v['id'] == $osFieldID || $v['id'] == $appFieldID)
			{
				foreach ($params['configoptions'][$k]['options'] as $key => $value)
				{
					if (!isset($value['selected']))
					{
						unset($params['configoptions'][$k]['options'][$key]);
					}
				}
			}
		}
	}

	if (isset($params['upgradepackages']))
	{
		$allowPackages = VultrHelper::getAllowProductUpgrades($params['id']);
		foreach ($params['upgradepackages'] as $key => $value)
		{
			$pInfo = Capsule::table('tblproducts')->where('id', $value['pid'])->first();
			if (!in_array($pInfo->configoption2, $allowPackages))
			{
				unset($params['upgradepackages'][$key]);
			}
		}

		if (empty($params['upgradepackages']))
		{
			$_SESSION['VULTR']['FLASH'][] = array('type' => 'warning', 'message' => LangHelper::T('core.hook.upgrade_empty'));
			header("Location: clientarea.php?action=productdetails&id=" . $params['id']);
			die();
		}

		return $params;
	}

	$_SESSION['vultrUpgrade'] = $script . '});</script>';

	return $params;
});

add_hook('AdminAreaHeadOutput', 1, function ($params)
{
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

add_hook('AdminAreaPage', 1, function ($params)
{
	if (isset($_POST['vultr_action']))
	{
		ob_clean();
		$return = array();
		switch ($_POST['vultr_action'])
		{
			case 'vultr_configurable_options':
				$return = VultrHelper::configurableOptions((int)filter_input(INPUT_POST, 'productID'));
			break;

			case 'vultr_custom_fields':
				$return = VultrHelper::customFields((int)filter_input(INPUT_POST, 'productID'));
			break;

			default:
				$return = array('status' => 'error', 'message' => LangHelper::T('core.hook.unknown_operation'));
			break;
		}
		header('Content-Type: application/json');
		echo json_encode($return);

		die;
	}
});

