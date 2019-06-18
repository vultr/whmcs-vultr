<?php

/* * ********************************************************************
 * vultr product developed. (2015-11-23)
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

namespace MGModule\vultr\models\whmcs\pricing;

/**
 * Description of Repository
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository {
    
    public function getModelClass() {
        return __NAMESPACE__.'\Price';
    }
    
    /**
     * 
     * @return Price[]
     */
    public function get() {
        return parent::get();
    }
    
    
    public function onlyProducts(){
        
        $this->_filters['type'] = 'product';
        
    }
    
    public function onlyAddon(){
        
        $this->_filters['type'] = 'addon';
        
    }
    
    public function onlyDomainRegister(){
        
        $this->_filters['type'] = 'domainregister';
        
    }
    
    public function withRelation($relationId){
        
        $this->_filters['relid'] = (int) $relationId;
        
    }
    
    public function onlyCurrency($currencyId){
        
        $this->_filters['currency'] = (int) $currencyId;
        
    }
    
    public function withBillingCycle(){
        $this->_filters[] = " ( monthly > 0.00 OR quarterly > 0.00 OR semiannually > 0.00 OR annually > 0.00 OR  biennially > 0.00  OR triennially > 0.00 )";
    }
    
    public function withDomainCycle(){
        $this->_filters[] = " ( msetupfee > 0.00 OR qsetupfee  > 0.00 OR ssetupfee  > 0.00 OR asetupfee  > 0.00 OR  bsetupfee > 0.00  OR tsetupfee > 0.00 "
                          . "  OR monthly > 0.00 OR quarterly > 0.00 OR semiannually > 0.00 OR annually > 0.00 OR  biennially > 0.00  OR triennially > 0.00 )";
    }
}
