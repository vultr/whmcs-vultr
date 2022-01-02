<?php
if (!class_exists('VultrAPI2')) {
    /**
     * Vultr.com API Client
     * @package vultr
     * @version 2.0
     * @author  https://github.com/whattheserver/whmcs-vultr
     * @license http://www.opensource.org/licenses/mit-license.php MIT
     * @see     https://github.com/whattheserver/whmcs-vultr/
     */
    class VultrAPI2
    {

        /**
         * API Token
         * @access private
         * @type string $api_token Vultr.com API token
         * @see https://my.vultr.com/settings/
         */
        private $api_token = '';

        /**
         * API Endpoint
         * @access public
         * @type string URL for Vultr.com API
         */
        public $endpoint = 'https://api.vultr.com/v2/';

        /**
         * Current Version
         * @access public
         * @type string Current version number
         */
        public $version = '2.0';

        /**
         * User Agent
         * @access public
         * @type string API User-Agent string
         */
        public $agent = 'Vultr.com API Client';

        /**
         * Debug Variable
         * @access public
         * @type bool Debug API requests
         */
        public $debug = true;

        /**
         * Snapshots Variable
         * @access public
         * @type mixed Array to store snapshot IDs
         */
        public $snapshots = array();

        /**
         * Plans Variable
         * @access public
         * @type mixed Array to store VPS Plan IDs
         */
        public $plans = array();

        /**
         * Regions Variable
         * @access public
         * @type mixed Array to store available regions
         */
        public $regions = array();

        /**
         * Scripts Variable
         * @access public
         * @type mixed Array to store startup scripts
         */
        public $scripts = array();

        /**
         * Servers Variable
         * @access public
         * @type mixed Array to store server data
         */
        public $servers = array();

        /**
         * Account Variable
         * @access public
         * @type mixed Array to store account data
         */
        public $account = array();

        /**
         * OS List Variable
         * @access public
         * @type mixed Array to store OS list
         */
        public $oses = array();

        /**
         * SSH Keys variable
         * @access public
         * @type mixed Array to store SSH keys
         * */
        public $ssh_keys = array();

        /**
         * Response code variable
         * @access public
         * @type int Holds HTTP response code from API
         * */
        public $response_code = 0;

        /**
         * Response code variable
         * @access public
         * @type bool Determines whether to include the response code, default: false
         * */
        public $get_code = false;

        /**
         * Cache ttl for all get requests
         * @access public
         * $type int TTL in seconds
         */
        public $cache_ttl = 1;
        public $message = '';

        /**
         * Cache folder
         * @access public
         * $type string Cache dir
         */
        public $cache_dir = '/tmp/vultr-api-client-cache';
        private $request_type;

        /**
         * Constructor function
         * @param string $token
         * @param int $cache_ttl
         * @return void
         * @see https://my.vultr.com/settings/
         */
        public function __construct(string $token, $cache_ttl = 1)
        {
            $this->api_token = $token;
            $this->cache_ttl = $cache_ttl;
            $this->account = self::account_info();
        }

        /**
         * Get Account info
         * @see https://www.vultr.com/api/#tag/account
         * @return mixed
         */
        public function account_info()
        {
            return self::get('account');
        }

        /**
         * Get OS list
         * @see https://www.vultr.com/api/#operation/list-os
         * @return mixed
         */
        public function os_list()
        {
            return self::get('os');
        }

        /**
         * OS Upgrade/Change Options
         * @see https://www.vultr.com/api/#operation/get-instance-upgrades
         * @see
         * @param string $instanceid
         * @return mixed
         */
        public function os_change_list(string $instanceid)
        {
            return self::get("instances/{$instanceid}/upgrades?type=os");
        }

        /**
         * OS Change/ Reinstall
         * @see https://www.vultr.com/api/#operation/update-instance
         * @see
         * @param string $instanceid
         * @param string $osid // https://www.vultr.com/api/#operation/list-isos
         * @return mixed
         */
        public function os_change(string $instanceid, string $osid)
        {
            return self::patch("instances/{$instanceid}", array('os_id' => $osid));
        }

        /**
         * List available ISOs in your account.
         * @see https://www.vultr.com/api/#iso_list
         * @return mixed Available ISO images
         * */
        public function iso_list()
        {
            return self::get('iso');
        }

        /**
         * List all Vultr Public ISOs.
         * @see https://www.vultr.com/api/#operation/list-public-isos
         * @return array Available ISO images
         * */
        public function public_iso_list()
        {
            return self::get('iso-public');
        }


        /**
         * Attach an ISO to an Instance.
         * @see https://www.vultr.com/api/#operation/attach-instance-iso
         * @param string $instanceid AKA Instance ID: 35sdw3f-234w-5678-e89g-2adfwebiuewib
         * @param string $isoid cb676a46-66fd-4dfb-b839-443f2e6c0b60
         * @return mixed 202|400|401|404
         */
        public function attach_iso(string $instanceid, string $isoid)
        {
            return self::post("instances/{$instanceid}/iso/attach", array('iso_id' => $isoid));
        }

        /**
         * Detach ISO
         * @see https://www.vultr.com/api/#operation/detach-instance-iso
         * @param string $instanceid
         * @return mixed
         */
        public function detach_iso(string $instanceid)
        {
            return self::post("instances/{$instanceid}/iso/detach", []);
        }

        /**
         * Get ISO Status
         * @see https://www.vultr.com/api/#operation/get-instance-iso-status
         * @param string $instanceid
         * @return mixed
         */
        public function iso_status(string $instanceid)
        {
            return self::get("instances/{$instanceid}/iso");
        }

        /**
         * List available snapshots
         * @see https://www.vultr.com/api/#snapshot_snapshot_list
         * @return mixed
         */
        public function snapshot_list()
        {
            return self::get('snapshots');
        }

        /**
         * Destroy snapshot
         * @see https://www.vultr.com/api/#snapshot_destroy
         * @param string $snapshot_id Example: c68bcc12-7852-4b08-9294-b81b6e7a728f
         * @return int HTTP response code
         */
        public function snapshot_destroy(string $snapshot_id)
        {
            //$args = array('SNAPSHOTID' => $snapshot_id);
            return self::delete("snapshots/{$snapshot_id}");
        }

        /**
         * Create snapshot
         * @see https://www.vultr.com/api/#operation/create-snapshot
         * @param string $instanceid
         * @param $description
         * @return bool|int|mixed|string
         */
        public function snapshot_create(string $instanceid, $description)
        {
            $desc = preg_replace('/\s+/', '_', $description);
            $args = array('instance_id' => $instanceid, 'description' => $desc);
            return self::post('snapshots', $args);
        }

        /**
         * List all DNS Domains in your account.
         * @see https://www.vultr.com/api/#operation/list-dns-domains
         * @return int|mixed|string
         */
        public function dns_list()
        {
            return self::get('domains');
        }

        /**
         * Create Domain
         * @see https://www.vultr.com/api/#operation/create-dns-domain
         * @param string $domain Your registered DNS Domain name.
         * @param string|null $ip The default IP address for your DNS Domain. If omitted an empty domain zone will be created.
         * @param bool $dns_sec Enable or disable DNSSEC.
         * @return bool|int|mixed|string
         */
        public function domain_create(string $domain, string $ip=null, bool $dns_sec=false)
        {
            $args = array('domain' => $domain);
            if ($ip !== null) {
                $args['ip'] = $ip;
            }
            if ($dns_sec !== false) {
                $args['dns_sec'] = $dns_sec;
            }
            return self::post('domains', $args);
        }

        /**
         * Delete Domain
         * @see https://www.vultr.com/api/#operation/delete-dns-domain
         * @param string $domain
         * @return bool|int|mixed|string
         */
        public function domain_delete(string $domain)
        {
            return self::delete("domains/{$domain}");
        }

        /**
         * Get the DNS records for the Domain.
         * @param $domain
         * @see https://www.vultr.com/api/#operation/list-dns-domain-records
         * @return int|mixed|string
         */
        public function dns_records($domain)
        {
            return self::get("domains/{$domain}/records");
        }

        /**
         * Create a DNS record for a domain.
         * @see https://www.vultr.com/api/#operation/create-dns-domain-record
         * @param $domain
         * @param $args
         * @return bool|int|mixed|string
         */
        public function create_record($domain, $args)
        {
            return self::post("domains/{$domain}/records", $args);
        }

        /**
         * Delete a DNS record.
         * @see https://www.vultr.com/api/#operation/delete-dns-domain-record
         * @param string $domain The DNS Domain.
         * @param string $recordid The DNS Record id.
         * @return bool|int|mixed|string
         */
        public function delete_record(string $domain, string $recordid)
        {
            return self::delete("domains/{$domain}/records/{$recordid}");
        }

        /**
         * Update the information for a DNS record. All attributes are optional.
         * If not set, the attributes will retain their original values.
         * @see https://www.vultr.com/api/#operation/update-dns-domain-record
         * @param $args
         * @return bool|int|mixed|string
         */
        public function update_record($args)
        {
            $domain = $args['domain'];
            $recordid = $args['RECORDID'];
            unset($args['domain']);
            unset($args['RECORDID']);
            return self::patch("domains/{$domain}/records/{$recordid}", $args);
        }

        /**
         * Update SOA information
         * @see https://www.vultr.com/api/#operation/update-dns-domain-soa
         * @param array $args : ["domain" => $domain, "nsprimary" => $nameServer1, "email" => $email]
         * @return bool|int|mixed|string
         */
        public function soa_update(array $args)
        {
            $domain = $args['domain'];
            unset($args['domain']);
            return self::patch("domains/{$domain}/soa", $args);
        }

        /**
         * Get SOA information for the DNS Domain.
         * @see https://www.vultr.com/api/#operation/get-dns-domain-soa
         * @param string $domain
         * @return int|mixed|string
         */
        public function soa_info(string $domain)
        {
            return self::get("domains/{$domain}/soa");
        }

        /**
         * Get Available Instance Upgrades
         * @see https://www.vultr.com/api/#operation/get-instance-upgrades
         * @param string $instanceid
         * @return int|mixed|string
         */
        public function upgrade_plan_list(string $instanceid)
        {
            return self::get("instances/{$instanceid}/upgrades" . '?type=plans');
        }

        /**
         * Upgrade Plan / Update Instance
         * @see https://www.vultr.com/api/#operation/update-instance
         * @param string $instanceid
         * @param string $vpsplanid // https://www.vultr.com/api/#operation/list-plans
         * @return void
         */
        public function upgrade_plan(string $instanceid, string $vpsplanid)
        {
            return self::patch("instances/{$instanceid}", ['plan' => $vpsplanid]);
        }

        /**
         * List available applications
         * @see https://www.vultr.com/api/#app_app_list
         * @return array Available applications
         * */
        public function app_list(): array
        {
            $vultr_apps_nice = [];
            $apps = self::get('applications');

            foreach ($apps as $app) {
                foreach ($app as $key=>$value) {
                    if (!empty($value['id'])) {
                        $app_fixed = [
                            "APPID" => $value['id'],
                            "name" => $value['name'],
                            "short_name" => $value['short_name'],
                            "deploy_name" => $value['deploy_name'],
                        ];
                        $vultr_apps_nice[$value['id']] = $app_fixed;
                    }
                }
            }
            return $vultr_apps_nice;
        }

        /**
         * List available applications for instance
         * @see https://www.vultr.com/api/#operation/get-instance-upgrades
         * @param string $instanceid
         * @return mixed Available applications
         */
        public function app_change_list(string $instanceid)
        {
            return self::get("instances/{$instanceid}/upgrades?type=applications");
        }

        /**
         * Reinstall via Application ID
         * @see https://www.vultr.com/api/#operation/update-instance
         * @param string $instanceid // server
         * @param integer $appid // Available applications from https://www.vultr.com/api/#operation/list-applications
         * @return bool|int|mixed|string
         */
        public function app_change(string $instanceid, int $appid)
        {
            return self::patch("instances/{$instanceid}", ['app_id' => $appid]);
        }

        /**
         * List available plans
         * @see https://www.vultr.com/api/#plans_plan_list
         * @return mixed
         */
        public function plans_list()
        {
            return self::get('plans');
        }

        /**
         * List available regions
         * @see https://www.vultr.com/api/#regions_region_list
         * @return mixed
         */
        public function regions_list()
        {
            return self::get('regions');
        }

        /**
         * Determine region availability
         * @see https://www.vultr.com/api/#operation/list-available-compute-region
         * @param string $region_id
         * @return mixed VPS plans available at given region
         */
        public function regions_availability(string $region_id)
        {
            return self::get("regions/{$region_id}/availability");
        }


        /**
         * Get Instance userdata
         * Get the user-supplied, base64 encoded user data for an Instance.
         * @see https://www.vultr.com/api/#operation/get-instance-userdata
         * @param string $instanceid
         * @return int|mixed|string
         */
        public function server_userData(string $instanceid)
        {
            return self::get("instances/{$instanceid}/user-data");
        }

        /**
         * List startup scripts
         * @see https://www.vultr.com/api/#operation/list-startup-scripts
         * @return mixed List of startup scripts
         */
        public function startupscript_list()
        {
            return self::get('startup-scripts');
        }

        /**
         * Update startup script
         * @see https://www.vultr.com/api/#operation/update-startup-script
         * @param string $script_id
         * @param string $name The name of the Startup Script.
         * @param string $script The base-64 encoded Startup Script contents
         * @param string $script_type The Startup Script type. boot (default) pxe
         * @return int HTTP response code
         */
        public function startupscript_update(string $script_id, string $name, string $script, $script_type='default')
        {
            $args = array(
                'type' => $script_type,
                'name' => $name,
                'script' => $script
            );
            return self::patch("startup-scripts/{$script_id}", $args);
        }

        /**
         * Destroy startup script
         * @see https://www.vultr.com/api/#startupscript_destroy
         * @param string $script_id
         * @return int HTTP response code
         */
        public function startupscript_destroy(string $script_id)
        {
            return self::delete("startup-scripts/{$script_id}");
        }

        /**
         * Create startup script
         * @see https://www.vultr.com/api/#operation/create-startup-script
         * @param string $script_name The name of the Startup Script.
         * @param string $script_contents The base-64 encoded Startup Script.
         * @param string $script_type boot (default) or pxe
         * @return string Script ID: "id": "cb676a46-66fd-4dfb-b839-443f2e6c0b60"
         */
        public function startupscript_create(string $script_name, string $script_contents, string $script_type)
        {
            $args = array(
                'name' => $script_name,
                'script' => $script_contents,
                'type' => $script_type
            );
            $script = self::post('startup-scripts', $args);
            return $script['startup_script']['id'];
        }

        /**
         * Server Available in Region
         * @param string $region_id : https://www.vultr.com/api/#operation/list-regions
         * @param string $plan_id : https://www.vultr.com/api/#operation/list-plans
         * @throws Exception
         */
        public function server_available(string $region_id, string $plan_id)
        {
            $availability = self::regions_availability($region_id);
            if (!in_array($plan_id, $availability)) {
                throw new Exception('Plan ID ' . $plan_id . ' is not available in region ' . $region_id);
            }
        }

        /**
         * List servers
         * @see https://www.vultr.com/api/#server_server_list
         * @return mixed List of servers
         */
        public function server_list()
        {
            return self::get('instances');
        }

        /**
         * Display server bandwidth
         * @see https://www.vultr.com/api/#operation/get-instance-bandwidth
         * @param string $instanceid
         * @return mixed Bandwidth history
         */
        public function bandwidth(string $instanceid)
        {
            return self::get("instances/{$instanceid}/bandwidth");
        }

        /**
         * List IPv4 Addresses allocated to specified server
         * @see https://www.vultr.com/api/#operation/get-instance-ipv4
         * @param string $instanceid
         * @return mixed IPv4 address list
         */
        public function list_ipv4(string $instanceid)
        {
            $ipv4 = self::get("instances/{$instanceid}/ipv4");
            return $ipv4['ipv4s'];
        }

        /**
         * Create IPv4 address
         * @see https://www.vultr.com/api/#operation/create-instance-ipv4
         * @param string $instanceid
         * @param string Reboot server after adding IP: <yes|no>, default: yes
         * @return int HTTP response code
         * */
        public function ipv4_create(string $instanceid, $reboot='yes')
        {
            $args = array(
                'reboot' => ($reboot == 'yes' ? 'yes' : 'no')
            );
            return self::post("instances/{$instanceid}/ipv4", $args);
        }

        /**
         * Destroy IPv4 Address
         * @see https://www.vultr.com/api/#operation/delete-instance-ipv4
         * @param string $instanceid
         * @param string $ip4
         * @return int HTTP response code
         */
        public function destroy_ipv4(string $instanceid, string $ip4)
        {
            return self::delete("instances/{$instanceid}/ipv4/{$ip4}");
        }

        /**
         * Set Reverse DNS for IPv4 address
         * @see https://www.vultr.com/api/#operation/create-instance-reverse-ipv4
         * @param string $ip The IPv4 address.
         * @param string $rdns The IPv4 reverse entry.
         * @param string $instanceid
         * @return int HTTP response code
         */
        public function reverse_set_ipv4(string $ip, string $rdns, string $instanceid)
        {
            $args = [
                "ip" => $ip,
                "reverse" => $rdns];

            return self::post("instances/{$instanceid}/ipv4/reverse", $args);
        }

        /**
         * Set Default Reverse DNS for IPv4 address
         * @see https://www.vultr.com/api/#operation/post-instances-instance-id-ipv4-reverse-default
         * @param string $instanceid
         * @param string $ip
         * @return int HTTP response code
         */
        public function reverse_default_ipv4(string $instanceid, string $ip)
        {
            $args = array(
                'ip' => $ip
            );
            return self::post("instances/{$instanceid}/reverse/default", $args);
        }

        /**
         * List IPv6 addresses for specified server
         * @see https://www.vultr.com/api/#operation/get-instance-ipv6
         * @param string $instanceid
         * @return mixed IPv6 allocation info
         */
        public function list_ipv6(string $instanceid)
        {
            $ipv6 = self::get("instances/{$instanceid}/ipv6");
            return $ipv6['ipv6s'];
        }

        /**
         * List Instance IPv6 Reverse
         * @see https://www.vultr.com/api/#operation/list-instance-ipv6-reverse
         * @param string $instanceid
         * @return mixed IPv6 allocation info
         */
        public function reverse_list_ipv6(string $instanceid)
        {
            $ipv6 = self::get("instances/{$instanceid}/ipv6/reverse");
            return $ipv6['reverse_ipv6s'];
        }

        /**
         * Get Application Information
         * @see https://www.vultr.com/api/#operation/get-instance
         * @param string $instanceid
         * @return mixed Application Information
         */
        public function get_app_info(string $instanceid)
        {
            $app_id = self::get("instances/{$instanceid}")['instance']['app_id'];
            $app_info = self::app_list()[$app_id]['name'];
            return $app_info['name'];
        }


        /**
         * Set Reverse DNS for IPv6 address
         * @see https://www.vultr.com/api/#operation/create-instance-reverse-ipv6
         * @param string $instanceid
         * @param string $ipv6
         * @param string $rdns
         * @return int HTTP response code
         */
        public function reverse_set_ipv6(string $instanceid, string $ipv6, string $rdns)
        {
            $args = array(
                'ip' => $ipv6,
                'reverse' => $rdns
            );
            return self::post("instances/{$instanceid}/ipv6/reverse", $args);
        }

        /**
         * Delete IPv6 Reverse DNS
         * @see https://www.vultr.com/api/#operation/delete-instance-reverse-ipv6
         * @param string $instanceid
         * @param string $ipv6 IPv6 address
         * @return int HTTP response code
         * */
        public function reverse_delete_ipv6(string $instanceid, string $ipv6)
        {
            return self::delete("instances/{$instanceid}/ipv6/reverse/{$ipv6}");
        }

        /**
         * Reboot server
         * @see https://www.vultr.com/api/#operation/reboot-instance
         * @param string $instanceid
         * @return int HTTP response code
         */
        public function reboot(string $instanceid)
        {
            return self::post("instances/{$instanceid}/reboot", []);
        }

        /**
         * Halt server
         * @see https://www.vultr.com/api/#operation/halt-instances
         * @param string $instanceid
         * @return int HTTP response code
         */
        public function halt(string $instanceid)
        {
            $args = array('instance_ids' => array($instanceid));
            return self::post('instances/halt', $args);
        }

        /**
         * Start server
         * @see https://www.vultr.com/api/#operation/start-instance
         * @param string $instanceid
         * @return int HTTP response code
         */
        public function start(string $instanceid)
        {
            return self::post("instances/{$instanceid}/start");
        }

        /**
         * Destroy server
         * @see https://www.vultr.com/api/#operation/delete-instance
         * @param string $instanceid
         * @return int HTTP response code
         */
        public function destroy(string $instanceid)
        {
            return self::delete("instances/{$instanceid}");
        }

        /**
         * Reinstall OS on an instance
         * @see https://www.vultr.com/api/#operation/reinstall-instance
         * @param string $instanceid
         * @param string $hostname
         * @return int HTTP response code
         */
        public function reinstall(string $instanceid, $hostname='')
        {
            $args = array('hostname' => $hostname);
            return self::post("instances/{$instanceid}/reinstall", $args);
        }

        /**
         * Set server label
         * @see https://www.vultr.com/api/#operation/update-instance
         * @param string $instanceid
         * @param string $label
         * @return int HTTP response code
         */
        public function label_set(string $instanceid, string $label)
        {
            $args = array(
                'label' => $label
            );
            return self::patch("instances/{$instanceid}", $args);
        }

        /**
         * Restore Server Snapshot
         * @see https://www.vultr.com/api/#operation/restore-instance
         * @param string $instanceid The Instance ID.
         * @param string $snapshot_id The Snapshot id used to restore this instance.
         * @return int HTTP response code
         */
        public function restore_snapshot(string $instanceid, string $snapshot_id)
        {
            $args = array(
                'snapshot_id' => $snapshot_id
            );
            return self::post("instances/{$instanceid}/restore", $args);
        }

        /**
         * Restore Backup
         * @see https://www.vultr.com/api/#operation/restore-instance
         * @param string $instanceid
         * @param string $backup_id
         * @return int HTTP response code
         */
        public function restore_backup(string $instanceid, string $backup_id)
        {
            $args = array(
                'backup_id' => $backup_id
            );
            return self::post("instances/{$instanceid}/restore", $args);
        }

        /**
         * List Backups
         * @see https://www.vultr.com/api/#operation/list-backups
         * @return mixed
         */
        public function backup_list()
        {
            return self::get('backups');
        }

        /**
         * List Instance specific backups
         * @see https://www.vultr.com/api/#operation/list-backups
         * @param $instanceid
         * @return mixed
         */
        public function instance_backup_list($instanceid)
        {
            return self::get("backups" ."?instance_id={$instanceid}");
        }

        /**
         * Server Create
         * @see https://www.vultr.com/api/#operation/create-instance
         * @param $config
         * @return bool|int|mixed|string
         */
        public function create($config)
        {
            try {
                self::server_available((int)$config['DCID'], (int)$config['VPSPLANID']);
            } catch (Exception $e) {
                return false;
            }

            return self::post('instances', $config);
        }

        /**
         * SSH Keys List method
         * @see https://www.vultr.com/api/#sshkey_sshkey_list
         * @return FALSE if no SSH keys are available
         * @return mixed with whatever ssh keys get returned
         */
        public function sshkeys_list()
        {
            $try = self::get('ssh-keys');
            if (sizeof($try) < 1) {
                return false;
            }
            return $try;
        }

        /**
         * SSH Keys Create method
         * @see https://www.vultr.com/api/#sshkey_sshkey_create
         * @param string $name
         * @param string $key [openssh formatted public key]
         * @return FALSE if no SSH keys are available
         * @return mixed with whatever ssh keys get returned
         */
        public function sshkey_create(string $name, string $key)
        {
            $args = array(
                'name' => $name,
                'ssh_key' => $key
            );
            return self::post('ssh-keys', $args);
        }

        /**
         * SSH Keys Update method
         * @see https://www.vultr.com/api/#sshkey_sshkey_update
         * @param string $key_id
         * @param string $name
         * @param string $key [openssh formatted public key]
         * @return int HTTP response code
         */
        public function sshkey_update(string $key_id, string $name, string $key)
        {
            $args = array(
                'SSHKEYID' => $key_id,
                'name' => $name,
                'ssh_key' => $key
            );
            return self::patch('sshkey/update', $args);
        }

        /**
         * SSH Keys Destroy method
         * @see https://www.vultr.com/api/#sshkey_sshkey_destroy
         * @param string $key_id
         * @return int HTTP response code
         */
        public function sshkey_destroy(string $key_id)
        {
            $args = array('SSHKEYID' => $key_id);
            return self::delete('sshkey/destroy', $args);
        }

        /**
         * GET Method
         * @param string $method
         * @param mixed $args
         * @return int|mixed|string
         */
        public function get(string $method, $args = false)
        {
            $this->request_type = 'GET';
            $this->get_code = false;
            return self::query($method, $args);
        }


        /**
         * DELETE Method
         * @param $method
         * @param $args
         * @return bool|int|mixed|string
         */
        public function delete($method, $args=[])
        {
            $this->request_type = 'DELETE';
            return self::query($method, $args);
        }


        /**
         * PATCH Method
         * @param $method
         * @param $args
         * @return bool|int|mixed|string
         */
        public function patch($method, $args)
        {
            $this->request_type = 'PATCH';
            return self::query($method, $args);
        }

        /**
         * POST Method
         * @param $method
         * @param $args
         * @return bool|int|mixed|string
         */
        public function post($method, $args)
        {
            $this->request_type = 'POST';
            return self::query($method, $args);
        }

        /**
         * PUT Method
         * @param $method
         * @param $args
         * @return bool|int|mixed|string
         */
        public function put($method, $args)
        {
            $this->request_type = 'PUT';
            return self::query($method, $args);
        }

        /**
         * API Query Function
         * @param string $method
         * @param mixed $args
         * @return int|mixed|string
         */
        private function query(string $method, $args)
        {
            $methodArray = explode('/', $method);
            $apiRequiredArray = array(
                'account',
                'auth',
                'backup',
                'backups',
                'baremetal',
                'blocks',
                'dns',
                'firewalls',
                'iso',
                'network',
                'plans',
                'reservedip',
                'reserved-ips',
                'server',
                'snapshots',
                'sshkey',
                'ssh-keys',
                'startupscript',
                'startup-scripts',
                'user',
                'users',
                'type',
                'per_page',
                'instance_id',
                'tag',
                'label',
                'main_ip',
                'cursor',
                'instances',
                'os',
                'domains',
                'load-balancers',
                'bare-metals',
                'object-storage',
                'private-networks',

            );

            $url = $this->endpoint . $method;
            $apiRequired = false;

            if ($this->debug) {
                echo $this->request_type . ' ' . $url . PHP_EOL;
            }

            $_defaults = array(
                CURLOPT_USERAGENT => sprintf('%s v%s (%s) - WHMCS Module', $this->agent, $this->version, 'https://github.com/whattheserver/vultr-provisioning-module/'),
                CURLOPT_HEADER => 0,
                CURLOPT_VERBOSE => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_HTTP_VERSION => '1.0',
                CURLOPT_FOLLOWLOCATION => 0,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTPHEADER => array('Accept: application/json')
            );

            if (in_array($methodArray[0], $apiRequiredArray)) {
                array_push($_defaults[CURLOPT_HTTPHEADER], "Authorization: Bearer $this->api_token");
                $apiRequired = true;
            }

            $cacheable = false;
            switch ($this->request_type) {

                case 'POST':

                    $post_data = json_encode($args);
                    $_defaults[CURLOPT_URL] = $url;
                    $_defaults[CURLOPT_POST] = 1;
                    $_defaults[CURLOPT_POSTFIELDS] = $post_data;
                    break;

                case 'PUT':
                    $post_data = json_encode($args);
                    $_defaults[CURLOPT_URL] = $url;
                    $_defaults[CURLOPT_CUSTOMREQUEST] = 'PUT';
                    $_defaults[CURLOPT_POSTFIELDS] = $post_data;
                    break;

                case 'PATCH':
                    $post_data = json_encode($args);
                    $_defaults[CURLOPT_URL] = $url;
                    $_defaults[CURLOPT_CUSTOMREQUEST] = 'PATCH';
                    $_defaults[CURLOPT_POSTFIELDS] = $post_data;
                    break;

                case 'DELETE':
                    //$post_data = http_build_query($args);
                    $_defaults[CURLOPT_URL] = $url;
                    $_defaults[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                    //$_defaults[CURLOPT_POSTFIELDS] = $post_data;
                    break;

                case 'GET':
                    if ($args !== false) {
                        $get_data = http_build_query($args);
                        $_defaults[CURLOPT_URL] = $url . '?' . $get_data;
                    } else {
                        $_defaults[CURLOPT_URL] = $url;
                    }

                    $cacheable = true;
                    $response = $this->serveFromCache($_defaults[CURLOPT_URL]);
                    if ($response !== false) {
                        $this->response_code = 200;
                        return $response;
                    }
                    break;

                default:
                    break;
            }

            // To avoid rate limit hits
            if ($this->readLast() == time() && $apiRequired) {
                usleep(333);
            }

            $apisess = curl_init();
            curl_setopt_array($apisess, $_defaults);
            $response = curl_exec($apisess);
            $httpCode = curl_getinfo($apisess, CURLINFO_HTTP_CODE);
            // logModuleCall('Vultr', $url, $args, "HTTP Code: " . $httpCode . "\n" . $response);
            $this->writeLast();

            /**
             * Check to see if there were any API exceptions thrown
             * If so, then error out, otherwise, keep going.
             */
            try {
                self::isAPIError($apisess, $response);
            } catch (Exception $e) {
                curl_close($apisess);
                $message = $e->getMessage() . PHP_EOL;
                $this->message = $message;
                return $message;
            }

            /**
             * Close our session
             * Return the decoded JSON response
             */
            curl_close($apisess);
            $obj = json_decode($response, true);

            if ($this->get_code) {
                return (int)$this->response_code;
            }

            if ($cacheable) {
                $this->saveToCache($url, $response);
            } else {
                $this->purgeCache($url);
            }

            return $obj;
        }

        public function getCode(): int
        {
            return (int)$this->response_code;
        }

        public function checkConnection(): bool
        {
            return $this->getCode() == 200;
        }

        public function getMessage(): string
        {
            return $this->message;
        }

        /**
         * API Error Handling
         * @param cURL_Handle $response_obj
         * @param string $response
         * @throws Exception if invalid API location is provided
         * @throws Exception if API token is missing from request
         * @throws Exception if API method does not exist
         * @throws Exception if Internal Server Error occurs
         * @throws Exception if the request fails otherwise
         */
        public function isAPIError($response_obj, string $response)
        {
            $code = curl_getinfo($response_obj, CURLINFO_HTTP_CODE);
            $this->response_code = $code;

            if ($this->debug) {
                echo $code . PHP_EOL;
            }

            switch ($code) {
                case 400:
                    throw new Exception('400: Bad Request');
                    break;
                case 401:
                    throw new Exception('401: Unauthorized');
                    break;
                case 403:
                    throw new Exception('403: Forbidden');
                    break;
                case 404:
                    throw new Exception('404: Not Found');
                    break;
                case 500:
                    throw new Exception('500: Internal Server Error');
                    break;
                case 503:
                    throw new Exception('503: Service Unavailable. Your request exceeded the API rate limit.');
                    break;
                case 412:
                    throw new Exception('Request failed: ' . $response);
                    break;
                default:
                case 200:
                case 201:
                case 202:
                case 204:
                    break;
            }
        }

        protected function serveFromCache($url)
        {
            // garbage collect 5% of the time
            if (mt_rand(0, 19) == 0) {
                $files = glob("$this->cache_dir/*");
                $old = time() - ($this->cache_ttl * 2);
                foreach ($files as $file) {
                    if (filemtime($file) < $old) {
                        unlink($old);
                    }
                }
            }

            $hash = md5($url);
            $group = $this->groupFromUrl($url);
            $file = "$this->cache_dir/$group-$hash";
            if (file_exists($file) && filemtime($file) > (time() - $this->cache_ttl)) {
                $response = file_get_contents($file);
                return json_decode($response, true);
            }
            return false;
        }

        protected function saveToCache($url, $json)
        {
            if (!file_exists($this->cache_dir)) {
                mkdir($this->cache_dir);
            }

            $hash = md5($url);
            $group = $this->groupFromUrl($url);
            $file = "$this->cache_dir/$group-$hash";
            file_put_contents($file, $json);
        }

        protected function groupFromUrl($url)
        {
            $group = 'default';
            if (preg_match('@/v1/([^/]+)/@', $url, $match)) {
                return $match[1];
            }
        }

        protected function purgeCache($url)
        {
            $group = $this->groupFromUrl($url);
            $files = glob("$this->cache_dir/$group-*");
            foreach ($files as $file) {
                unlink($file);
            }
        }

        protected function writeLast()
        {
            if (!file_exists($this->cache_dir)) {
                mkdir($this->cache_dir);
            }

            file_put_contents("$this->cache_dir/last", time());
        }

        protected function readLast()
        {
            if (file_exists("$this->cache_dir/last")) {
                return file_get_contents("$this->cache_dir/last");
            }
        }
    }
}
