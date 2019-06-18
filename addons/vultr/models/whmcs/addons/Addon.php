<?php

/* * ********************************************************************
 * vultr product developed. (2015-11-17)
 * *
 *
 *  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
 *  CONTACT                        ->       contact@modulesgarden.com
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 * ******************************************************************** */

namespace MGModule\vultr\models\whmcs\addons;
use MGModule\vultr as main;

/**
 * Description of Addon
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 * @Table(name=tbladdons,preventUpdate,prefixed=false)
 */
class Addon extends main\mgLibs\models\Orm{
    /**
     * @Column()
     * @var int
     */
    protected $id;
    
    /**
     * @Column(name=packages)
     * @var string 
     */
    protected $packages;
    /**
     * @Column(name=name)
     * @var string 
     */
    protected $name;
        /**
     * @Column(name=description)
     * @var string 
     */
    protected $description;
    /**
     * @Column(name=billingcycle,as=billingCycle)
     * @var string 
     */
    protected $billingCycle;
    /**
     * @Column(name=tax)
     * @var string 
     */
    protected $tax;
    /**
     * @Column(name=showorder)
     * @var string 
     */
    protected $showorder;
    /**
     * @Column(name=downloads)
     * @var string 
     */
    protected $downloads;
    /**
     * @Column(name=autoactivate,as=autoActivate)
     * @var string 
     */
    protected $autoActivate;
    /**
     * @Column(name=suspendproduct,as=suspendProduct)
     * @var string 
     */
    protected $suspendProduct;
    /**
     * @Column(name=welcomeemail,as=welcomeEmail)
     * @var int
     */
    protected $welcomeEmail;
    /**
     * @Column(name=weight)
     * @var int
     */
    protected $weight;
    
    private $_pricing;
    
    function getId() {
        return $this->id;
    }

    function getPackages() {
        return $this->packages;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getBillingCycle() {
        return $this->billingCycle;
    }

    function getTax() {
        return $this->tax;
    }

    function getShoworder() {
        return $this->showorder;
    }

    function getDownloads() {
        return $this->downloads;
    }

    function getAutoActivate() {
        return $this->autoActivate;
    }

    function getSuspendProduct() {
        return $this->suspendProduct;
    }

    function getWelcomeEmail() {
        return $this->welcomeEmail;
    }

    function getWeight() {
        return $this->weight;
    }

    /**
     * Get Pricing
     * @return main\models\whmcs\pricing\Price[]
     */
    public function getPricing(){
        if(!empty($this->_pricing))
            return $this->_pricing;
        
        $repositor = new main\models\whmcs\pricing\Repository();
        $repositor->onlyAddon();
        $repositor->withRelation($this->id);
        $repositor->withBillingCycle();
        $this->_pricing = array();
        foreach($repositor->get() as $price){
            $this->_pricing[] = $price;
        }
        unset($repositor);
        return $this->_pricing;
    }
    
    public function getPrice($currencyId, $billingCycle){
        
        $repositor = new main\models\whmcs\pricing\Repository();
        $repositor->onlyAddon();
        $repositor->withRelation($this->id);
        $repositor->withBillingCycle();
        $repositor->onlyCurrency($currencyId);
        foreach($repositor->get() as $price){
            return $price->getPrice($billingCycle);
        }
        
        return null;
    }
}
