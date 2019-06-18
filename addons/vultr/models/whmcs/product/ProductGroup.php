<?php

/* * ********************************************************************
 * DiscountCenter product developed. (2016-02-09)
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
namespace MGModule\vultr\models\whmcs\product;
use MGModule\vultr as main;
/**
 * Description of ProductGroup
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 * @Table(name=tblproductgroups,preventUpdate,prefixed=false)
 */
class ProductGroup extends main\mgLibs\models\Orm{
    
    /**
     *
     * @Column(int) 
     * @var int
     */
    protected $id;
    /**
     *
     * @Column(name=name,as=name)
     * @var string 
     */
    protected $name;
    /**
     *
     * @Column(name=headline,as=headLine)
     * @var string 
     */
    protected $headLine;
    /**
     *
     * @Column(name=tagline,as=tagLine)
     * @var string 
     */
    protected $tagLine;
    /**
     *
     * @Column(name=orderfrmtpl,as=orderForm)
     * @var string 
     */
    protected $orderForm;
    /**
     *
     * @Column(name=disabledgateways,as=disabledGateways)
     * @var string 
     */
    protected $disabledGateways;
    /**
     *
     * @Column(name=hidden)
     * @var string 
     */
    protected $hidden;
    /**
     *
     * @Column(name=order)
     * @var string 
     */
    protected $order;
    /**
     *
     * @Column(name=created_at,as=createdAt)
     * @var string 
     */
    protected $createdAt;
    /**
     *
     * @Column(name=updated_at,as=updatedAt)
     * @var string 
     */
    protected $updatedAt;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getHeadLine() {
        return $this->headLine;
    }

    public function getTagLine() {
        return $this->tagLine;
    }

    public function getOrderForm() {
        return $this->orderForm;
    }

    public function getDisabledGateways() {
        return $this->disabledGateways;
    }

    public function getHidden() {
        return $this->hidden;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}

    
    
    