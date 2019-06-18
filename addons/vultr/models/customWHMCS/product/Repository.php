<?php

namespace MGModule\vultr\models\customWHMCS\product;
use MGModule\vultr as main;
use WHMCS\Database\Capsule as DB;
use MGModule\vultr\helpers\ProductsHelper;
/**
 * Description of repository
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository {
    
    
    public function getModelClass() {
        return __NAMESPACE__.'\Product';
    }
      
    public function saveSingleProduct($data) {
        $productID = DB::table('tblproducts')->insertGetId($data);
       // $insertResult = main\mgLibs\MySQL\Query::insert('tblproducts', $data);
      //  $configOptionsCreatingResult = ProductsHelper::configurableOptions($insertResult);
        $configOptionsCreatingResult = ProductsHelper::configurableOptions($productID);
       // $customFieldCreatingResult = ProductsHelper::customFields($insertResult);
        $customFieldCreatingResult = ProductsHelper::customFields($productID);
        return $productID;
    }
    
    public function insertPricing($data) {
       // $insertResult = main\mgLibs\MySQL\Query::insert('tblpricing', $data);
        DB::table('tblpricing')->insertGetId($data);
        return $insertResult;
    }
    
    public function createProductConfigurableOptions($productId) {
        return ProductsHelper::configurableOptions($productId);
    }
    

 
}
