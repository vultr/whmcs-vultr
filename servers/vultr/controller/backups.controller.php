<?php

class BackupsController extends VultrController
{

    public function __construct($params)
    {
        parent::__construct($params);
        if (!isset($this->params['customfields']['subid']) || empty($this->params['customfields']['subid'])) {
            SessionHelper::setFlashMessage('danger', LangHelper::T('core.client.create_vm_first'));
            $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
        }
        if (!isset($this->params['configoptions']['auto_backups']) || ($this->params['configoptions']['auto_backups'] != 'Yes' && $this->params['configoptions']['auto_backups'] != '1')) {
            SessionHelper::setFlashMessage('danger', LangHelper::T('backups.other.not_available'));
            $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
        }
    }

    public function indexAction()
    {
        if ($this->getVultrAPI()) {
            $servers = $this->vultrAPI->server_list();
            if (isset($servers[$this->params['customfields']['subid']])) {
                $server = $servers[$this->params['customfields']['subid']];
            } else {
                SessionHelper::setFlashMessage('warning', LangHelper::T('backups.index.vm_not_found'));
                $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
            }
            $backups = $this->vultrAPI->backup_list();
            foreach ($backups as $key => $value) {
                if (strpos($value['description'], $server['main_ip']) === false) {
                    unset($backups[$key]);
                } else {
                    $backups[$key]['size'] = VultrHelper::recalcSize($backups[$key]['size']);
                }
            }
            return array('vars' => array('backups' => $backups));
        } else {
            return array('error' => LangHelper::T('scripts.core.connection_error'));
        }
    }

    public function restoreAction()
    {
        if ($this->getVultrAPI()) {
            $id = filter_input(INPUT_GET, 'vultrID');
            $api = $this->vultrAPI->restore_backup($this->params['customfields']['subid'], $id);
            if ($api != '200') {
                SessionHelper::setFlashMessage('danger', $api);
            } else {
                SessionHelper::setFlashMessage('success', LangHelper::T('backups.restore.success'));
            }
            $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Backups');
        } else {
            return array('error' => LangHelper::T('scripts.core.connection_error'));
        }
    }
}
