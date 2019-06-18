<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class DnsController extends VultrController {

    public function __construct($params) {
        parent::__construct($params);
        if (!isset($this->params['customfields']['subid']) || empty($this->params['customfields']['subid'])) {
            SessionHelper::setFlashMessage('danger', LangHelper::T('core.client.create_vm_first'));
            $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
        }
    }

    public function indexAction() {
        if ($this->getVultrAPI()) {
            $dns = $this->vultrAPI->dns_list();
            $domainsQuery = Capsule::table('vultr_dns')->select('domain')
                    ->where('client_id', $this->clientID)
                    //->where('service_id', $this->serviceID)
                    ->get();
            $domains = array();
            foreach ($domainsQuery as $domain) {
                $domains[$domain->domain] = $domain->domain;
            }
            foreach ($dns as $k => $value) {
                if (!in_array($value['domain'], $domains)) {
                    unset($dns[$k]);
                }
            }
            /*
             * NameServers
             * @author = Mateusz Pawłowski <mateusz.pa@moduelsgarden.com>
             */
            $nameServers = Capsule::table('tbladdonmodules')->select('value')->where([
                        ['module', '=', 'vultr'],
                        ['setting', '=', 'nameServers'],
                    ])->first();
            return array(
                'vars' => array(
                    'domains' => $dns,
                    'ns'      => unserialize($nameServers->value)
                )
            );
            /*
             * end NameServers
             */
        } else {
            return array('error' => LangHelper::T('scripts.core.connection_error'));
        }
    }

    public function createAction() {
        if ($this->getVultrAPI()) {
            $servers = $this->vultrAPI->server_list();
            if (isset($servers[$this->params['customfields']['subid']])) {
                $ip = $servers[$this->params['customfields']['subid']]['main_ip'];
            } else {
                SessionHelper::setFlashMessage('warning', LangHelper::T('dns.create.vm_not_found'));
                $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
            }
        } else {
            return array('error' => LangHelper::T('scripts.core.connection_error'));
        }
        if (isset($_POST['cloudCreateAction'])) {
            if (!empty($_POST['vultrDNSdomainName'])) {
                $domain = filter_input(INPUT_POST, 'vultrDNSdomainName');
            } else if (!empty($_POST['vultrDNSdomainID'])) {
                $domain = filter_input(INPUT_POST, 'vultrDNSdomainID');
            }
            if (isset($domain)) {
                $api = $this->vultrAPI->domain_create($domain, filter_input(INPUT_POST, 'vultrDNSserverIP'));

                if ($api == '200') {
                    
                    $server1Name = \WHMCS\Database\Capsule::table("tbladdonmodules")->select("tbladdonmodules.value")
                            ->where("tbladdonmodules.module", "=", "vultr")->where("tbladdonmodules.setting", "=", "nameServers")->first();
                    $nameservers = unserialize($server1Name->value);
                    $nameServer1 = $nameservers['ns1'];
                    $apiResponse = $this->vultrAPI->soa_update(array("domain" => $domain, "nsprimary" => $nameServer1));                 
                  
                    /*
                     * Update NameServers after create
                     * @author = Mateusz Pawłowski <mateusz.pa@moduelsgarden.com>
                     */
                    $records = $this->vultrAPI->dns_records($domain);
                    $nsFlag = 1;
                    $nameServers = Capsule::table('tbladdonmodules')->select('value')->where([
                                ['module', '=', 'vultr'],
                                ['setting', '=', 'nameServers'],
                            ])->first();
                    $nsUpdate = unserialize($nameServers->value);
                    foreach ($records as $value) {
                        if ($value['type'] == "NS") {
                            $update = array(
                                'domain'   => $domain,
                                'RECORDID' => $value['RECORDID'],
                                'name'     => "",
                                'data'     => $nsUpdate['ns' . $nsFlag]
                            );
                            $api = $this->vultrAPI->update_record($update);
                            $nsFlag++;
                        }
                    }
                    /*
                     * end Update
                     */
                    Capsule::table('vultr_dns')->insert(array('client_id' => $this->clientID, 'service_id' => $this->serviceID, 'domain' => $domain));
                    SessionHelper::setFlashMessage('success', LangHelper::T('dns.create.add_domain'));

                    $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Dns');
                } else {
                    SessionHelper::setFlashMessage('warning', $api);
                }
            }
        }
        return array(
            'vars' => array(
                'ip'      => $ip,
                'domains' => Capsule::table('tbldomains')->select('id', 'domain')->where('userid', $this->clientID)->get(),
            )
        );
    }

    public function deleteAction() {
        $domain = filter_input(INPUT_GET, 'vultrID');
        $allow = Capsule::table('vultr_dns')->where('domain', $domain)
                ->where('client_id', $this->clientID)
                //->where('service_id', $this->serviceID)
                ->first();
        if (!empty($allow)) {
            if ($this->getVultrAPI()) {
                if ($this->vultrAPI->domain_delete($domain) == '200') {
                    Capsule::table('vultr_dns')->where('domain', $domain)->delete();
                    SessionHelper::setFlashMessage('success', LangHelper::T('dns.delete.delete_success'));
                } else {
                    SessionHelper::setFlashMessage('danger', LangHelper::T('dns.delete.delete_error'));
                }
            } else {
                return array('error' => LangHelper::T('scripts.core.connection_error'));
            }
        } else {
            SessionHelper::setFlashMessage('danger', LangHelper::T('dns.delete.delete_error'));
        }
        $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Dns');
    }

    public function manageAction() {
        $domain = filter_input(INPUT_GET, 'vultrID');
        $allow = Capsule::table('vultr_dns')->where('domain', $domain)
                ->where('client_id', $this->clientID)
                //->where('service_id', $this->serviceID)
                ->first();
        if (!empty($allow)) {
            if ($this->getVultrAPI()) {
                if (isset($_POST['vultrUpdateAction'])) {
                    $updated = array();
                    $deleted = array();

                    foreach ($_POST['record'] as $key => $value) {
                        if (isset($value['delete']) && $value['delete'] == 'on') {
                            $api = $this->vultrAPI->delete_record(array('domain' => $domain, 'RECORDID' => $key));
                            if ($api != '200') {
                                SessionHelper::setFlashMessage('danger', $api);
                            } else {
                                $deleted[$key] = $key;
                            }
                        } else {
                            $update = array(
                                'domain'   => $domain,
                                'RECORDID' => $key,
                                'name'     => $value['name'],
                                'data'     => $value['data']
                            );
                            if (isset($value['priority'])) {
                                $update['priority'] = $value['priority'];
                            }
                            if (isset($value['ttl']) && $value['ttl'] != '') {
                                $update['ttl'] = $value['ttl'];
                            }
                            $api = $this->vultrAPI->update_record($update);
                            
                            if ($api != '200') {
                                SessionHelper::setFlashMessage('danger', $api);
                            } else {
                                $updated[$key] = $key;
                            }
                        }
                    }
                    if (isset($updated) && !empty($updated)) {
                        if (count($updated) == 1) {
                            SessionHelper::setFlashMessage('success', LangHelper::T('dns.manage.update_success', rtrim(implode(', ', $updated)), ', '));
                        } else {
                            SessionHelper::setFlashMessage('success', LangHelper::T('dns.manage.update_success_multi', rtrim(implode(', ', $updated)), ', '));
                        }
                    }
                    if (isset($deleted) && !empty($deleted)) {
                        if (count($updated) == 1) {
                            SessionHelper::setFlashMessage('success', LangHelper::T('dns.manage.delete_success', rtrim(implode(', ', $deleted)), ', '));
                        } else {
                            SessionHelper::setFlashMessage('success', LangHelper::T('dns.manage.delete_success_multi', rtrim(implode(', ', $deleted)), ', '));
                        }
                    }
                }
                if (isset($_POST['vultrAddAction'])) {
                    $params = array(
                        'domain' => $domain,
                        'name'   => filter_input(INPUT_POST, 'name'),
                        'type'   => filter_input(INPUT_POST, 'type'),
                        'data'   => filter_input(INPUT_POST, 'data'),
                        'ttl'    => filter_input(INPUT_POST, 'ttl'));
                    if (in_array($params['type'], array('MX', 'SRV'))) {
                        $params['priority'] = filter_input(INPUT_POST, 'priority');
                    }
                    $api = $this->vultrAPI->create_record($params);
                 
                    if ($api != '200') {
                        SessionHelper::setFlashMessage('danger', $api);
                    }  
                    else {
                            SessionHelper::setFlashMessage('success', LangHelper::T('dns.manage.add_success'));
                        }
                }
                $records = $this->vultrAPI->dns_records($domain);
                if (is_array($records)) {
                    return array('vars' => array('records' => $records, 'domain' => $domain));
                } else {
                    return array('vars' => array('records' => array(), 'domain' => $domain));
                }
            } else {
                return array('error' => LangHelper::T('scripts.core.connection_error'));
            }
        } else {
            SessionHelper::setFlashMessage('danger', LangHelper::T('dns.manage.error'));
        }
        $this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Dns');
    }

}
