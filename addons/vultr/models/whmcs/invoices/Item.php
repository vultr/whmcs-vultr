<?php

/* * ********************************************************************
 * vultr product developed. (2015-12-09)
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

namespace MGModule\vultr\models\whmcs\invoices;
use MGModule\vultr as main;

/**
 * Description of Item
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 * @Table(name=tblinvoiceitems,preventUpdate,prefixed=false)
 * 
 */
class Item extends main\mgLibs\models\Orm{
    
    /**
     * @Column()
     * @var int
     */
    protected $id;
    
     /**
     * @Column(name=invoiceid,as=invoiceId)
     * @var int
     */
    protected $invoiceId;
    
     /**
     * @Column(name=userid,as=userId)
     * @var int
     */
    protected $userId;
    
     /**
     * @Column(name=type)
     * @var string
     */
    protected $type;
    
     /**
     * @Column(name=relid,as=relId)
     * @var int
     */
    protected $relId;
    
     /**
     * @Column(name=description)
     * @var string
     */
    protected $description;
    
    
     /**
     * @Column(name=amount)
     * @var int
     */
    protected $amount;	
    
    
     /**
     * @Column(name=taxed)
     * @var int
     */
    protected $taxed;
    
     /**
     * @Column(name=duedate,as=dueDate)
     * @var string
     */
    protected $dueDate;
     	
    
     /**
     * @Column(name=paymentmethod )
     * @var int
     */
    protected $paymentmethod ;
    
    	
    public function getId() {
        return $this->id;
    }

    public function getInvoiceId() {
        return $this->invoiceId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getType() {
        return $this->type;
    }

    public function getRelId() {
        return $this->relId;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setInvoiceId($invoiceId) {
        $this->invoiceId = $invoiceId;
        return $this;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setRelId($relId) {
        $this->relId = $relId;
        return $this;
    }

    public function isDomainRegister() {
        return $this->type ='DomainRegister';
    }

    public function isAddon() {
        return $this->type ='Addon';
    }
    
    public function isHosting() {
        return $this->type ='Hosting';
    }
    
    
}
