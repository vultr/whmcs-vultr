<?php

namespace MGModule\vultr\controllers\addon\admin;

//use MGModule\vultr\helpers\PathHelper;

use MGModule\vultr as main;

/**
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Snapshots extends main\mgLibs\process\AbstractController {

    function indexHTML($input = array(), $vars = array()) {

//        if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($input['changeNS'])) {
//            $this->saveChanges($input, $vars);
//            $vars['success'] = main\mgLibs\Lang::T('messages', 'NameServersChange');
//        }
        $vars['snapshotList'] = $this->getSnapshotsList();
        $vars['allowSnapshots'] = $this->getAllowSnapshots();

        return array(
            'tpl'   => 'snapshots',
            'vars'  => $vars,
            'input' => $input
        );
    }

    private function getSnapshotsList() {
        $snapModel = new \MGModule\vultr\models\snapshots\Repository();
        return $snapModel->getSnapshotsList();
    }

    private function getAllowSnapshots() {
        $snapModel = new \MGModule\vultr\models\snapshots\Repository();
        return $snapModel->getAllowSnapshots();
    }

    public function changeSnapshotsSettingsJSON($input = [], $vars = []) {
        $snapModel = new \MGModule\vultr\models\snapshots\Repository();
        $snapModel->changeSnapshotsSettings($input['snapId']);
        return array
            (
            'success' => 'Snapshot '. $input['snapId'] .' settings has been changed'
        );
    }

}
