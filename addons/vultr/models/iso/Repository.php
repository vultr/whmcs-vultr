<?php

namespace MGModule\vultr\models\iso;
use MGModule\vultr\helpers\ApiHelper;
/**
 * Description of Repository
 *
 * @author inbs-dev
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository {
    
    public function getModelClass() {
        return __NAMESPACE__ . '\iso';
    }
    
    public function getIsoList() {
        $api = ApiHelper::getAPI();
        return $api->iso_list();
    }
    
    public function getISOSettings() {
        $isoSettings = \WHMCS\Database\Capsule::table("tbladdonmodules")->select("tbladdonmodules.value")
                ->where("tbladdonmodules.module", "=", "vultr")->where("tbladdonmodules.setting", "=", "isoSettings")->first();
        return unserialize($isoSettings->value);
    }
    
    public function changeISOSettings($input) {
        $settingArray = $this->getISOSettings();

        if (array_key_exists((int) $input, $settingArray)) {
            unset($settingArray[$input]);
        } else {
            $settingArray[$input] = "disable";
        }
        $this->saveIsoSettings($settingArray);
    }
    
    public function saveIsoSettings($isoSettings){
        \WHMCS\Database\Capsule::table("tbladdonmodules")->where("tbladdonmodules.module", "=", "vultr")
                ->where("tbladdonmodules.setting", "=", "isoSettings")->update(["tbladdonmodules.value" => serialize($isoSettings)]);
    }
    
}

