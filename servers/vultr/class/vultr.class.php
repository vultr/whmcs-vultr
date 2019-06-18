<?php
use Illuminate\Database\Capsule\Manager as Capsule;

class Vultr
{

    protected $params;
    protected $configArray = array();
    protected $vultrAPI;

    public function __construct($params)
    {
        $this->params = $params;
    }

    protected function addConfigOption($name, $params)
    {
        $this->configArray[$name] = $params;
    }

    public function getConfigOptions()
    {
        $product_id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
        
        $this->addConfigOption('apikey', array(
            "FriendlyName" => "Your API Key",
            "Type" => "text",
            "Size" => "25"
        ));
        $productApiKey = VultrHelper::getProductConfigOptions((int) $product_id, 'configoption1');
        if ($productApiKey) {
            $vultrAPI = new VultrAPI($productApiKey, 1);
            if ($vultrAPI->checkConnection()) {
                $this->addConfigOption('plan', array(
                    "FriendlyName" => "Select plan",
                    "Type" => "dropdown",
                    "Options" => VultrHelper::parsePlans($vultrAPI->plans_list())
                ));
            } else {
                $this->addConfigOption('apikey', array(
                    "FriendlyName" => "Your API Key",
                    "Type" => "text",
                    "Size" => "25",
                    "Description" => $vultrAPI->getMessage()
                ));
            }
        }
        
        return $this->configArray;
    }

    private function getProductConfigOptions($productID, $field = 'all', $default = '')
    {
        $result = Capsule::table('tblproducts')->where('id', $productID)->get();
        if ($field == 'all') {
            return $result;
        } else {
            if (isset($result->{$field})) {
                return $result->{$field};
            } else {
                return $default;
            }
        }
    }
    /*
     * Custom button operations
     */

    public function getAdminCustomButtonArray()
    {
        return array(
            'Start' => 'start',
            'Reboot' => 'reboot',
            'Halt' => 'halt',
            'Reinstall' => 'reinstall',
        );
    }

    public function start()
    {
        $vultrAPI = new \VultrAPI($this->params['configoption1']);
        if ($vultrAPI->checkConnection()) {
            if (isset($this->params['customfields']['subid'])) {
                $code = $vultrAPI->start($this->params['customfields']['subid']);
                if ($code != '200') {
                    return $vultrAPI->getMessage();
                } else {
                    return "success";
                }
            } else {
                return LangHelper::T('core.action.not_found_subid');
            }
        } else {
            return $vultrAPI->getMessage();
        }
    }

    public function reboot()
    {
        $vultrAPI = new \VultrAPI($this->params['configoption1']);
        if ($vultrAPI->checkConnection()) {
            if (isset($this->params['customfields']['subid'])) {
                $code = $vultrAPI->reboot($this->params['customfields']['subid']);
                if ($code != '200') {
                    return $vultrAPI->getMessage();
                } else {
                    return "success";
                }
            } else {
                return LangHelper::T('core.action.not_found_subid');
            }
        } else {
            return $vultrAPI->getMessage();
        }
    }

    public function halt()
    {
        $vultrAPI = new \VultrAPI($this->params['configoption1']);
        if ($vultrAPI->checkConnection()) {
            if (isset($this->params['customfields']['subid'])) {
                $code = $vultrAPI->halt($this->params['customfields']['subid']);
                if ($code != '200') {
                    return $vultrAPI->getMessage();
                } else {
                    return "success";
                }
            } else {
                return LangHelper::T('core.action.not_found_subid');
            }
        } else {
            return $vultrAPI->getMessage();
        }
    }

    public function reinstall()
    {
        $vultrAPI = new \VultrAPI($this->params['configoption1']);
        if ($vultrAPI->checkConnection()) {
            if (isset($this->params['customfields']['subid'])) {
                $code = $vultrAPI->reinstall($this->params['customfields']['subid']);
                if ($code != '200') {
                    return $vultrAPI->getMessage();
                } else {
                    return "success";
                }
            } else {
                return LangHelper::T('core.action.not_found_subid');
            }
        } else {
            return $vultrAPI->getMessage();
        }
    }

    public function destroy()
    {
        $vultrAPI = new \VultrAPI($this->params['configoption1']);
        if ($vultrAPI->checkConnection()) {
            if (isset($this->params['customfields']['subid'])) {
                $code = $vultrAPI->destroy($this->params['customfields']['subid']);
                if ($code != '200') {
                    return $vultrAPI->getMessage();
                } else {
                    return "success";
                }
            } else {
                return LangHelper::T('core.action.not_found_subid');
            }
        } else {
            return $vultrAPI->getMessage();
        }
    }
    /*
     * Admin area operations
     */

    public function createAccount()
    {
        return 'success'; //LangHelper::T('core.action.action_not_supported');
    }

    public function suspendAccount()
    {
        return $this->halt();
    }

    public function unsuspendAccount()
    {
        return $this->start();
    }

    public function terminateAccount()
    {
        return $this->destroy();
    }
    /*
     * Client Area Operations
     */

    public function changePackage()
    {
        VultrHelper::moveProductConfigOptionsOnUpgrade($this->params);
        $message = '';
        $vultrAPI = new \VultrAPI($this->params['configoption1']);
        if ($vultrAPI->checkConnection()) {
            $list = $vultrAPI->server_list();
            if (!empty($list[$this->params['customfields']['subid']])) {
                $availablePlans = $vultrAPI->upgrade_plan_list($this->params['customfields']['subid']);
                if ($this->params['configoption2'] != $list[$this->params['customfields']['subid']]['VPSPLANID']) {
                    $availablePlans = $vultrAPI->upgrade_plan_list($this->params['customfields']['subid']);
                    if (in_array($this->params['configoption2'], $availablePlans)) {
                        $code = $vultrAPI->upgrade_plan($this->params['customfields']['subid'], $this->params['configoption2']);
                        if ($code != '200') {
                            $message .= '|' . $vultrAPI->getMessage();
                        }
                    } else {
                        $message .= '|' . LangHelper::T('core.action.cant_upgrade');
                    }
                }
            } else {
                $message .= '|' . LangHelper::T('core.action.not_found_subid');
            }
        } else {
            $message .= $vultrAPI->getMessage();
        }
        if (strlen($message) > 0) {
            return $message;
        }
        return "success";
    }

    public function verifyAdminServiceSave()
    {
        $vultrAPI = new \VultrAPI($this->params['configoption1']);
        if ($vultrAPI->checkConnection()) {
            if (!empty($this->params['customfields']['subid'])) {
                $servers = $vultrAPI->server_list();
                if (isset($servers[$this->params['customfields']['subid']])) {
                    if ($servers[$this->params['customfields']['subid']]['auto_backups'] == 'yes') {
                        VultrHelper::updateAutoBackupsStatus($this->params['serviceid'], '1');
                    } else {
                        VultrHelper::updateAutoBackupsStatus($this->params['serviceid'], '0');
                    }
                }
            }
        }
        if ($this->params['configoptions']['application'] != '0' && $this->params['configoptions']['os_type'] != '186') {
            VultrHelper::changeOSTypeToApp($this->params['serviceid']);
        }
        if ($this->params['configoptions']['application'] == '0' && $this->params['configoptions']['os_type'] == '186') {
            VultrHelper::changeOSTypeToNoApp($this->params['serviceid']);
        }
    }
}
