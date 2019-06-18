<?php

namespace MGModule\vultr\models\customWHMCS\product;
use MGModule\vultr as main;

/**
 * @Table(name=custom_configuration)
 */
class Configuration extends \MGModule\vultr\mgLibs\models\Orm{
    /**
     * 
     * @Column(id)
     * @var type 
     */
    public $id;
    
    /**
     * @Column(varchar=32)
     * @var type 
     */
    public $name;
    
    /**
     * @Column(varchar=32)
     * @var type 
     */
    public $confa;
}