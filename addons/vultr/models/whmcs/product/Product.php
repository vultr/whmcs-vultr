<?php

namespace MGModule\vultr\models\whmcs\product;
use MGModule\vultr as main;

/**
 * Description of product
 *
 * @Table(name=tblproducts,preventUpdate,prefixed=false)
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Product extends main\mgLibs\models\Orm{
    /**
     *
     * @Column(int) 
     * @var int
     */
    public $id;
    
    /**
     *
     * @Column()
     * @var string 
     */
    public $type;
    
    /**
     *
     * @Column(int) 
     * @var int
     */
    public $gid;
    
    /**
     * @Column() 
     * @var string 
     */
    public $name;
    
    /**
     * @Column(name=servertype) 
     * @var string 
     */
    public $serverType;

    /**
     * @Column(name=servergroup) 
     * @var int 
     */
    public $serverGroupID;
            
    /**
     *
     * @var main\models\service\server 
     */
    private $_server;
    
    /**
     * 
     * @var configuration 
     */
    private $_configuration;
        
    /**
     *
     * @var main\models\whmcs\customFields\Repository 
     */
    private $_customFields;
            
    /**
     * Create Product 
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param int $id
     * @param array $params
     */
    function __construct($id = null, $params = array()) {
        $this->id = $id;
        $this->load($params);
    }
        
    /**
     * Load Product 
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param array $params
     */
    function load($params = array()){
        if(empty($params))
        {
            $fields = static::fieldDeclaration();
            
            for($i=1;$i<25;$i++)
            {
                $fields['configoption'.$i] = 'configoption'.$i;
            }
            
            $params = main\mgLibs\MySQL\Query::select(
                    $fields
                    , static::tableName()
                    , array(
                        'id'    => $this->id
                    )
            )->fetch();
        }

        $this->fillProperties($params);
        
        if(isset($params['serverGroupID']))
        {
            $this->serverGroupID = $params['serverGroupID'];
        }
        
        if(isset($params['configoption1']))
        {
            $this->_configuration = $this->loadConfiguration($params);
        }
    }
    
    /**
     * Load Server
     * 
     * @return \MGModule\vultr\models\service\server
     */
    protected function loadServer(){
        if(empty($this->serverGroupID))
        {
            $this->load();
        }

        $server = main\mgLibs\MySQL\Query::query("
            SELECT 
                S.id
            FROM
                tblservers S
            JOIN
                tblservergroupsrel R
                ON S.id = R.serverid 
            WHERE
                R.groupid = :groupID:
                AND disabled = 0
        ",array(
            ':groupID:'     => $this->serverGroupID
        ))->fetchColumn();
        
        return new main\models\whmcs\servers\server($server);
    }
    
    /**
     * Get Server
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @return main\models\service\server
     */
    function getServer(){
        if(empty($this->_server))
        {
            $this->_server = $this->loadServer();
        }
        
        return $this->_server;
    }
    
    /**
     * Load Configuration
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param array $params
     * @return \MGModule\vultr\models\product\Configuration
     */
    protected function loadConfiguration($params = array()){
        return new Configuration($this->id,$params);
    }
            
    /**
     * Get Configuration
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @return configuration
     */
    function configuration(){
        if(empty($this->_configuration))
        {
            $this->_configuration = $this->loadConfiguration();
        }
        
        return $this->_configuration;
    }
    
    /**
     * Get Custom Fields
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @return main\models\whmcs\customFields\Repository
     */
    function customFields(){
        if(empty($this->_customFields))
        {
            $this->_customFields = new main\models\whmcs\customFields\Repository('product', $this->id);
        }
        
        return $this->_customFields;
    }
    
    function configOptionsGroups(){
        
    }
    
    function getId() {
        return $this->id;
    }

    function getType() {
        return $this->type;
    }

    function getGid() {
        return $this->gid;
    }

    function getName() {
        return $this->name;
    }

    function getServerType() {
        return $this->serverType;
    }

    function getServerGroupID() {
        return $this->serverGroupID;
    }


}
