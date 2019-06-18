<?php
use Illuminate\Database\Capsule\Manager as Capsule;

class VultrController
{

    public $vultrAPI;
    public $clientID;
    public $serviceID;
    public $params;

    public function __construct($params)
    {
        $this->clientID = $params['userid'];
        $this->serviceID = $params['serviceid'];
        $this->params = $params;
        $this->createTables();
    }

    public function redirect($url)
    {
        header("Location: " . $url);
        die();
    }

    public function getVultrAPI()
    {
        $vultrAPI = new VultrAPI($this->params['configoption1'], 1);
        if ($vultrAPI->checkConnection()) {
            $this->vultrAPI = $vultrAPI;
            return true;
        } else {
            return FALSE;
        }
    }

    public function createTables()
    {
        if (!Capsule::schema()->hasTable('vultr_sshkeys')) {
            Capsule::schema()->create(
                'vultr_sshkeys', function ($table) {
                $table->integer('client_id');
                $table->string('SSHKEYID');
            }
            );
        }
        if (!Capsule::schema()->hasTable('vultr_snapshots')) {
            Capsule::schema()->create(
                'vultr_snapshots', function ($table) {
                $table->increments('id');
                $table->integer('client_id');
                $table->integer('service_id');
                $table->string('SNAPSHOTID');
                $table->integer('SUBID');
            }
            );
        }
        if (!Capsule::schema()->hasTable('vultr_scripts')) {
            Capsule::schema()->create(
                'vultr_scripts', function ($table) {
                $table->integer('client_id');
                $table->integer('SCRIPTID');
                $table->string('type');
            }
            );
        }
        if (!Capsule::schema()->hasTable('vultr_dns')) {
            Capsule::schema()->create(
                'vultr_dns', function ($table) {
                $table->integer('client_id');
                $table->integer('service_id');
                $table->string('domain');
            }
            );
        }
        if (!Capsule::schema()->hasTable('vultr_revdns')) {
            Capsule::schema()->create(
                'vultr_revdns', function ($table) {
                $table->integer('client_id');
                $table->integer('service_id');
                $table->text('updated');
                $table->text('reverse');
            }
            );
        }
    }
}
