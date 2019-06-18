<?php
use Illuminate\Database\Capsule\Manager as Capsule;

require 'loader.php';

add_hook('AdminAreaHeadOutput', 1, function($params) {
    if ($params['filename'] == 'configproducts' && isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        $productID = (int) $_GET['id'];
        $product = Capsule::table('tblproducts')->select('id')->where('servertype', 'vultr')->where('id', $productID)->first();
        if ($product) {
            $script = str_replace('#id#', $productID, file_get_contents(__DIR__ . DS . 'assets' . DS . 'js' . DS . 'configproducts.js'));
            $return = '<script type="text/javascript">' . $script . '</script>';
            return $return;
        }
    }
});

/*add_hook('ClientAreaPage', 1, function($params) {
 
    if (isset($_POST['VultrAction'])) {
        ob_clean();
        $return = array();
        switch ($_POST['VultrAction']) {
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
                if ($return['power_status'] == 'running' && $return['vm_status'] == 'active') {
                    $return['reload'] = true;
                } else {
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
});*/

/*add_hook('ClientAreaHeadOutput', 1, function($params) {
 
    if (isset($_GET['a']) && $_GET['a'] === 'confproduct') {
        $fields = VultrHelper::getAllOSAndAppCustomFields();
   
        $head_return = '<script type="text/javascript">
  $(document).ready(function(){
  ';
        foreach ($fields as $value) {
            if (isset($value['appID'])) {
                $head_return .= '$(\'select[name="configoption[' . $value['id'] . ']"]\').on(\'change\',function(){
  if($(this).val()==' . $value['appID']->id . '){
    $(\'select[name="configoption[' . $value['app'] . ']"] option:first\').hide();
    $(\'select[name="configoption[' . $value['app'] . ']"]\').parent().parent().show();
    $(\'select[name="configoption[' . $value['app'] . ']"]\').val($(\'select[name="configoption[' . $value['app'] . ']"] option:eq(1)\').val());
    $(\'select[name="configoption[' . $value['app'] . ']"]\').trigger(\'change\');
  } else {
    $(\'select[name="configoption[' . $value['app'] . ']"] option:first\').show();
    $(\'select[name="configoption[' . $value['app'] . ']"]\').parent().parent().hide();
    $(\'select[name="configoption[' . $value['app'] . ']"]\').val($(\'select[name="configoption[' . $value['app'] . ']"] option:first\').val());
    $(\'select[name="configoption[' . $value['app'] . ']"]\').trigger(\'change\');
  }
  });
  $(\'select[name="configoption[' . $value['id'] . ']"]\').trigger(\'change\');
  ';
            }
        }
        $head_return .= '})</script>';
        return $head_return;
    }
    if (isset($_SESSION['vultrUpgrade'])) {
        $script = $_SESSION['vultrUpgrade'];
        unset($_SESSION['vultrUpgrade']);
        return $script;
    }
});*/

/*add_hook('ClientAreaPageUpgrade', 1, function($params) {
    if (!VultrHelper::checkIsVultrUpgrade($params['id'])) {
        return;
    }
    $script = '<script type="text/javascript">'
        . '$(document).ready(function () {';
    if (isset($params['configoptions'])) {
        $autoBackupFieldID = VultrHelper::getFieldId($params['id'], 'auto_backups');
        if ($autoBackupFieldID) {
            $script .= '$(\'[name="configoption[' . $autoBackupFieldID . ']"]\').parent(\'td\').parent(\'tr\').hide();';
        }
        $osFieldID = VultrHelper::getFieldId($params['id'], 'os_type');
        if ($osFieldID) {
            $script .= '$(\'[name="configoption[' . $osFieldID . ']"]\').parent(\'td\').parent(\'tr\').hide();';
        }
        $appFieldID = VultrHelper::getFieldId($params['id'], 'application');
        if ($appFieldID) {
            $script .= '$(\'[name="configoption[' . $appFieldID . ']"]\').parent(\'td\').parent(\'tr\').hide();';
        }
        foreach ($params['configoptions'] as $k => $v) {
            if ($v['id'] == $osFieldID || $v['id'] == $appFieldID) {
                foreach ($params['configoptions'][$k]['options'] as $key => $value) {
                    if (!isset($value['selected'])) {
                        unset($params['configoptions'][$k]['options'][$key]);
                    }
                }
            }
        }
    } 
    if (isset($params['upgradepackages'])) {
        $allowPackages = VultrHelper::getAllowProductUpgrades($params['id']);
        foreach ($params['upgradepackages'] as $key => $value) {
            $pInfo = Capsule::table('tblproducts')->where('id', $value['pid'])->first();
            if (!in_array($pInfo->configoption2, $allowPackages)) {
                unset($params['upgradepackages'][$key]);
            }
        }
        if (empty($params['upgradepackages'])) {
            $_SESSION['VULTR']['FLASH'][] = array('type' => 'warning', 'message' => LangHelper::T('core.hook.upgrade_empty'));
            header("Location: clientarea.php?action=productdetails&id=" . $params['id']);
            die();
        }
        return $params;
    }
    $_SESSION['vultrUpgrade'] = $script . '});</script>';
    return $params;
});*/

/*add_hook('AdminAreaHeadOutput', 1, function($params) {
    if ($params['filename'] == 'configproducts' && isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        $productID = (int) $_GET['id'];
        $product = Capsule::table('tblproducts')->select('id')->where('servertype', 'vultr')->where('id', $productID)->first();
        if ($product) {
            $script = str_replace('#id#', $productID, file_get_contents(__DIR__ . DS . 'assets' . DS . 'js' . DS . 'configproducts.js'));
            $return = '<script type="text/javascript">' . $script . '</script>';
            return $return;
        }
    }
});*/

/*add_hook('AdminAreaPage', 1, function($params) {
    if (isset($_POST['vultr_action'])) {
        ob_clean();
        $return = array();
        switch ($_POST['vultr_action']) {
            case 'vultr_configurable_options':
                $return = VultrHelper::configurableOptions((int) filter_input(INPUT_POST, 'productID'));
                break;
            case 'vultr_custom_fields':
                $return = VultrHelper::customFields((int) filter_input(INPUT_POST, 'productID'));
                break;

            default:
                $return = array('status' => 'error', 'message' => LangHelper::T('core.hook.unknown_operation'));
                break;
        }
        header('Content-Type: application/json');
        echo json_encode($return);
        die;
    }
});*/
