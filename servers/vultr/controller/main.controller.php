<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class MainController extends VultrController
{

	public function __construct($params)
	{
		parent::__construct($params);
	}

	public function indexAction()
	{

		if ($this->params['status'] == 'Pending')
		{
			return;
		}

		if (empty($this->params['customfields']['subid']))
		{
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Main&cloudAction=create');
		}
		else
		{
			if ($this->getVultrAPI())
			{
				$servers = $this->vultrAPI->server_list();
				if (isset($servers[$this->params['customfields']['subid']]))
				{
					if (isset($_POST['vultrLabelAction']))
					{
						if ($label = strip_tags(filter_input(INPUT_POST, 'vultrLabel')))
						{
							$code = $this->vultrAPI->label_set($this->params['customfields']['subid'], $label);
							if ($code == '200')
							{
								SessionHelper::setFlashMessage('success', LangHelper::T('main.index.label_success'));
								$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
							}
							else
							{
								SessionHelper::setFlashMessage('error', $code);
							}
						}
						else
						{
							SessionHelper::setFlashMessage('error', LangHelper::T('main.index.label_error'));
						}
					}

					if (isset($_POST['ipv6revAdd']))
					{
						$ipv6 = filter_input(INPUT_POST, 'ipv6revip');
						if (!filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false)
						{
							$code = $this->vultrAPI->reverse_set_ipv6($this->params['customfields']['subid'], $ipv6, filter_input(INPUT_POST, 'ipv6revrev'));
							if ($code == '200')
							{
								SessionHelper::setFlashMessage('success', LangHelper::T('main.index.ipv6rev_set_success'));
								$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
							}
							else
							{
								SessionHelper::setFlashMessage('danger', $code);
							}
						}
						else
						{
							SessionHelper::setFlashMessage('danger', LangHelper::T('main.index.ipv6rev_bad_ip'));
						}
					}
					if (isset($_POST['vultrREVDNS']) && isset($_POST['vultrIP']))
					{
						$revStatus = $this->vultrAPI->reverse_set_ipv4(filter_input(INPUT_POST, 'vultrIP'), filter_input(INPUT_POST, 'vultrREVDNS'), $this->params['customfields']['subid']);
						if ($revStatus != '200')
						{
							SessionHelper::setFlashMessage('danger', $revStatus);
						}
						else
						{
							SessionHelper::setFlashMessage('success', LangHelper::T('main.index.rev_dns_success'));
						}
					}

					if (isset($_POST['detachIso']))
					{
						$detachResult = $this->vultrAPI->detach_iso($this->params['customfields']['subid']);
						if ($detachResult != '200')
						{
							SessionHelper::setFlashMessage('danger', $detachResult);
						}
						else
						{
							SessionHelper::setFlashMessage('success', LangHelper::T('main.index.detach_iso_success'));
							$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
						}
					}

					$servers[$this->params['customfields']['subid']]['bandwidth'] = ($servers[$this->params['customfields']['subid']]['current_bandwidth_gb'] / $servers[$this->params['customfields']['subid']]['allowed_bandwidth_gb'] * 100);
					if ($servers[$this->params['customfields']['subid']]['status'] == 'active')
					{

						if ($servers[$this->params['customfields']['subid']]['main_ip'] != '')
						{
							if ($this->params['domain'] != '' && $this->validateHostname($this->params['domain']))
							{
								$revStatus = $this->vultrAPI->reverse_set_ipv4($servers[$this->params['customfields']['subid']]['main_ip'], $this->params['domain'], $this->params['customfields']['subid']);
								if (!VultrHelper::checkRevDNSUpdated($this->serviceID))
								{
									VultrHelper::setRevDNSUpdated($this->serviceID, $this->clientID, $this->params['domain'], $revStatus);
								}
								else
								{
									VultrHelper::updateRevDNSRecord($this->serviceID, $this->params['domain'], $revStatus);
								}
							}
						}


						// Get attached ISO file name
						$mountedIsoName = VultrHelper::getMountedIsoFileName($this->vultrAPI, $this->params['customfields']['subid']);
						$isoStaus = $this->vultrAPI->iso_status($this->params['customfields']['subid'])["state"];
						if ($mountedIsoName == "" && $isoStaus != "ready")
						{
							$mountedIsoName = VultrHelper::getMountedIsoFileName($this->vultrAPI, $this->params['customfields']['subid']);
						}

						$availableIsosList = VultrHelper::getAvailableIsos($this->vultrAPI->iso_list());

						$isSnapshot = $this->params['configoptions']['os_type'] == '164' ? true : false;


						$vars = array(
							'server' => $servers[$this->params['customfields']['subid']],
							'ipv4' => $this->vultrAPI->list_ipv4($this->params['customfields']['subid']),
							'ipv6' => $this->vultrAPI->list_ipv6($this->params['customfields']['subid']),
							'ipv6rev' => $this->vultrAPI->reverse_list_ipv6($this->params['customfields']['subid']),
							'isoName' => $mountedIsoName,
							'availableIsos' => $availableIsosList,
							'isSnapshot' => $isSnapshot
						);
						$appInfo = $this->vultrAPI->get_app_info($this->params['customfields']['subid']);

						if (strlen($appInfo) > 0)
						{
							$vars['appInfo'] = $appInfo;
						}
						return array(
							'vars' => $vars
						);
					}
					else
					{
						$status = $servers[$this->params['customfields']['subid']]['status'];
						if ($status == 'pending')
						{
							$status = 'installing';
						}
						SessionHelper::setFlashMessage('info', LangHelper::T('main.index.vm_status_is') . $status);
						SessionHelper::setFlashMessage('info', LangHelper::T('main.create.reload_info'));
					}
				}
				else
				{
					SessionHelper::setFlashMessage('info', LangHelper::T('main.index.vm_not_found'));
				}
			}
			else
			{
				SessionHelper::setFlashMessage('success', LangHelper::T('main.index.connection_error'));
			}
		}
	}

	private function validateHostname($ip)
	{
		if (preg_match('/([a-zA-Z0-9-]+.)?[a-zA-Z0-9-]+.[a-zA-Z]{2,5}/', $ip))
		{
			return true;
		}
		return false;
	}

	public function createAction()
	{
		if (!empty($this->params['customfields']['subid']))
		{
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
		}


		if ($this->getVultrAPI())
		{
			if (isset($_POST['cloudCreateAction']))
			{
				$error = false;
				$vmParams = array(
					'DCID' => filter_input(INPUT_POST, 'vultrRegionDCID'),
					'VPSPLANID' => $this->params['configoption2'],
					'OSID' => $this->params['configoptions']['os_type']
				);
				if ($vmParams['OSID'] == '159')
				{
					switch ($_POST['vultrISOType'])
					{
						case 'ISO':
							if (!isset($_POST['vultrISOID']) || empty($_POST['vultrISOID']))
							{
								$error = true;
								SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.iso_not_found'));
							}
							if (!$error)
							{
								$vmParams['ISOID'] = filter_input(INPUT_POST, 'vultrISOID', FILTER_VALIDATE_INT);
							}
							break;
						case 'IPXECustom':
							if (!isset($_POST['vultrIPXEUrl']))
							{
								$error = true;
								SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.ipxe_not_found'));
							}
							$ipxeContent = file_get_contents($_POST['vultrIPXEUrl']);
							if (!$ipxeContent && $error == false)
							{
								$error = true;
								SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.ipxe_not_found'));
							}
							if (substr($ipxeContent, 0, 6) !== '#!ipxe' && $error == false)
							{
								$error = true;
								SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.pxe_script_error'));
							}
							if (!$error)
							{
								$vmParams['ipxe_chain_url'] = filter_input(INPUT_POST, 'vultrIPXEUrl');
							}
							break;
						case 'IPXEScript':
							if (!isset($_POST['vultrSCRIPTID']) || empty($_POST['vultrSCRIPTID']))
							{
								$error = true;
								SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.ipxe_script_not_found'));
							}
							if (!$error)
							{
								$vmParams['SCRIPTID'] = filter_input(INPUT_POST, 'vultrSCRIPTID');
							}
							break;
						default:
							$error = true;
							SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.iso_type_not_found'));
							break;
					}
				}
				else
				{
					if ($vmParams['OSID'] != '164' && $vmParams['OSID'] != "180" && $vmParams['OSID'] != "186")
					{
						if ($_POST['vultrSCRIPT'] == "1")
						{
							if (!isset($_POST['vultrSCRIPTID']) || empty($_POST['vultrSCRIPTID']))
							{
								$error = true;
								SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.boot_script_not_found'));
							}
							else
							{
								$vmParams['SCRIPTID'] = filter_input(INPUT_POST, 'vultrSCRIPTID');
							}
						}
					}
				}


				if (!isset($_POST['vultrHostname']) || empty($_POST['vultrHostname']))
				{
					$error = true;
					SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.hostname_empty'));
				}
				else
				{
					if ($this->validateHostname(filter_input(INPUT_POST, 'vultrHostname')))
					{
						Capsule::table('tblhosting')->where('id', $this->serviceID)->update(array('domain' => filter_input(INPUT_POST, 'vultrHostname')));
						$hostname = filter_input(INPUT_POST, 'vultrHostname');
						$vmParams['hostname'] = $hostname;
					}
					else
					{
						$error = true;
						SessionHelper::setFlashMessage('danger', LangHelper::T('main.create.hostname_not_valid'));
					}
				}
				if (!$error)
				{
					if ($vmParams['OSID'] == '164')
					{
						if ($SCRIPTID = filter_input(INPUT_POST, 'vultrSNAPSHOTID'))
						{
							$vmParams['SNAPSHOTID'] = $SCRIPTID;
						}
					}
					if ($enable_ipv6 = filter_input(INPUT_POST, 'vultrIPv6', FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 1))))
					{
						$vmParams['enable_ipv6'] = 'yes';
					}
					if ($enable_private_network = filter_input(INPUT_POST, 'vultrPrivNet', FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 1))))
					{
						$vmParams['enable_private_network'] = 'yes';
					}
					if ($label = strip_tags(filter_input(INPUT_POST, 'vultrLabel')))
					{
						$vmParams['label'] = $label;
					}

					if ($SSHkey = filter_input(INPUT_POST, 'vultrSSH'))
					{
						if ($SSHkeyID = filter_input(INPUT_POST, 'vultrSSHKEYID'))
						{
							$vmParams['SSHKEYID'] = $SSHkeyID;
						}
					}
					if (isset($this->params['configoptions']['auto_backups']) && $this->params['configoptions']['auto_backups'])
					{
						$vmParams['auto_backups'] = 'yes';
					}
					if ($vmParams['OSID'] == '186')
					{
						$vmParams['APPID'] = $this->params['configoptions']['application'];
					}

					$vm = $this->vultrAPI->create($vmParams);

					if (is_array($vm))
					{
						$this->addVMCustomFields($vm['SUBID']);
						SessionHelper::setFlashMessage('success', LangHelper::T('main.create.created_success'));
						$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
					}
					else
					{
						SessionHelper::setFlashMessage('danger', $vm);
					}
				}
			}
			// Enable/Disable Server Location
			$regionList = VultrHelper::getAvailableRegion($this->vultrAPI->regions_list());
			$snapshotsList = VultrHelper::getAllSnapshots($this->vultrAPI->snapshot_list(), $this->params['userid']);

			$isosList = VultrHelper::getAvailableIsos($this->vultrAPI->iso_list());

			return array(
				'vars' => array(
					'regions' => VultrHelper::prepareRegionList($regionList, $this->vultrAPI->plans_list(), $this->params['configoption2']),
					'startupscript' => VultrHelper::getUserScripts($this->clientID, $this->vultrAPI->startupscript_list()),
					'oses' => $this->vultrAPI->os_list(),
					'snapshots' => $snapshotsList,
					'backups' => VultrHelper::getUserBackups($this->vultrAPI->backup_list(), $this->vultrAPI->server_list(), $this->params['userid']),
					'isos' => $isosList,
					'apps' => $this->vultrAPI->app_list(),
					'sshkeys' => VultrHelper::getUserSSHKeys($this->clientID, $this->vultrAPI->sshkeys_list())
				)
			);
		}
		else
		{
			return array('error' => LangHelper::T('scripts.core.connection_error'));
		}
	}

	private function addVMCustomFields($SUBID)
	{
		$customField = Capsule::table('tblcustomfields')
			->where('type', 'product')
			->where('relid', $this->params['packageid'])
			->where('fieldname', 'LIKE', 'subid|%')->get();
		if (count($customField) > 0)
		{
			$customFieldValue = Capsule::table('tblcustomfieldsvalues')
				->where('fieldid', $customField[0]->id)
				->where('relid', $this->serviceID)->get();
			if (count($customFieldValue) > 0)
			{
				$customFieldValue = Capsule::table('tblcustomfieldsvalues')
					->where('fieldid', $customField[0]->id)
					->where('relid', $this->serviceID)->update(array('value' => $SUBID));
			}
			else
			{
				Capsule::table('tblcustomfieldsvalues')->insert(array('fieldid' => $customField[0]->id, 'relid' => $this->serviceID, 'value' => $SUBID));
			}
		}
	}

	public function deleteAction()
	{
		if (empty($this->params['customfields']['subid']))
		{
			$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID . '&cloudController=Main&cloudAction=create');
		}
		else
		{
			if ($this->getVultrAPI())
			{
				$code = $this->vultrAPI->reverse_delete_ipv6($this->params['customfields']['subid'], filter_input(INPUT_GET, 'vultrID'));
				if ($code == '200')
				{
					SessionHelper::setFlashMessage('success', LangHelper::T('main.index.ipv6rev_delete_success'));
				}
				else
				{
					SessionHelper::setFlashMessage('error', $code);
				}
			}
			else
			{
				SessionHelper::setFlashMessage('success', LangHelper::T('main.index.connection_error'));
			}
		}
		$this->redirect('clientarea.php?action=productdetails&id=' . $this->serviceID);
	}
}
