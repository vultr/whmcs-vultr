<?php

/* * ********************************************************************
 * MGMF product developed. (2016-02-10)
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

namespace MGModule\vultr\models\whmcs\admins;
use MGModule\vultr as main;

/**
 * Description of Admin
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 * @Table(name=tbladmins,preventUpdate,prefixed=false)
 */
class Admin extends main\mgLibs\models\Orm{
    
    /**
     *
     * @Column(id)
     * @var int
     */
    protected $id;
    
    /**
     *
     * @Column(name=roleid,as=roleId)
     * @var int
     */
    protected $roleId;
    
    /**
     *
     * @Column(name=username)
     * @var int
     */
    protected $username;
    
    /**
     *
     * @Column(name=firstname,as=firstName)
     * @var int
     */
    protected $firstName;
    /**
     *
     * @Column(name=lastname,as=lastName)
     * @var int
     */
    protected $lastName;
    
    /**
     *
     * @Column(name=email)
     * @var int
     */
    protected $email;    	
    
    
    function getId() {
        return $this->id;
    }

    function getRoleId() {
        return $this->roleId;
    }

    function getUsername() {
        return $this->username;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getEmail() {
        return $this->email;
    }

}
