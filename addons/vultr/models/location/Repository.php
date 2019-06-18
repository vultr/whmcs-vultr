<?php

namespace MGModule\vultr\models\location;

use WHMCS\Database\Capsule as DB;
use MGModule\vultr\helpers\ApiHelper;

/**
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository {

    public function getModelClass() {
        return __NAMESPACE__ . '\location';
    }

    public function getLocationList() {
        $api = ApiHelper::getAPI();
        return $api->regions_list();
    }

    public function getLocationSettings() {
        $locationSettings = DB::table('tbladdonmodules')->select('value')->where([
                    ['module', '=', 'vultr'],
                    ['setting', '=', 'locationSettings'],
                ])->first();
        return unserialize($locationSettings->value);
    }

    public function changeLocationSettings($input) {
        $settingArray = $this->getLocationSettings();

        if (array_key_exists((int) $input, $settingArray)) {
            unset($settingArray[$input]);
        } else {
            $settingArray[$input] = "disable";
        }
        $this->saveLocationSettings($settingArray);
    }

    private function saveLocationSettings($lcoationArray = []) {
        DB::table('tbladdonmodules')->where([
            ['module', '=', 'vultr'],
            ['setting', '=', 'locationSettings'],
        ])->update([
            'value' => serialize($lcoationArray),
        ]);
    }

}
