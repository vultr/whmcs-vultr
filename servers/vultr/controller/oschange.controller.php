<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of oschange
 *
 * @author Krystian
 */
class OSChangeController extends VultrController
{

    public function __construct($params)
    {
        parent::__construct($params);
        if (!isset($this->params['customfields']['subid']) || empty($this->params['customfields']['subid'])) {
            SessionHelper::setFlashMessage('danger', LangHelper::T('core.client.create_vm_first'));
            $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
        }
    }

    public function indexAction()
    {
        
        if ($this->getVultrAPI()) {
            $servers = $this->vultrAPI->server_list();
      
            if (isset($servers[$this->params['customfields']['subid']])) {
                $return = array('info' => $servers[$this->params['customfields']['subid']]);
            
                if (trim($servers[$this->params['customfields']['subid']]['os']) == 'Application') {       
                    $apps = $this->vultrAPI->app_change_list($this->params['customfields']['subid']);
                    if (empty($apps)) {
                        SessionHelper::setFlashMessage('danger', LangHelper::T('oschange.index.no_available_app'));
                        $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
                    }
                    $return['apps'] = $apps;
                  
                    if (isset($_POST['vultrAPPID'])) {
                        $code = $this->vultrAPI->app_change($this->params['customfields']['subid'], filter_input(INPUT_POST, 'vultrAPPID'));
                        if ($code == '200') {
                            VultrHelper::updateApplicationStatus($this->serviceID, filter_input(INPUT_POST, 'vultrAPPID'));
                            SessionHelper::setFlashMessage('success', LangHelper::T('oschange.index.success_app'));
                            $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
                        } else {
                            SessionHelper::setFlashMessage('warning', $code);
                        }
                    }                
                } 
                else {
                    $oses = $this->vultrAPI->os_change_list($this->params['customfields']['subid']);
                    
                    if (empty($oses)) {
                        SessionHelper::setFlashMessage('danger', LangHelper::T('oschange.index.no_available_oses'));
                        $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
                    }
                    $return['oses'] = $oses;
 
                    if (isset($_POST['vultrOSID'])) {
                       
                        $code = $this->vultrAPI->os_change($this->params['customfields']['subid'], filter_input(INPUT_POST, 'vultrOSID'));
                        if ($code == '200') {
                            VultrHelper::updateOSStatus($this->serviceID, filter_input(INPUT_POST, 'vultrOSID'));
                            SessionHelper::setFlashMessage('success', LangHelper::T('oschange.index.success'));
                            $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
                        } else {
                            SessionHelper::setFlashMessage('warning', $code);
                        }
                    }            
                }
                return array('vars' => $return);
            } else {
                SessionHelper::setFlashMessage('info', LangHelper::T('oschange.index.vm_not_found'));
            }
        } else {
            return array('error' => LangHelper::T('scripts.core.connection_error'));
        }
    }
}
