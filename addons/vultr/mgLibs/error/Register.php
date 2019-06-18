<?php

namespace MGModule\vultr\mgLibs\error;
use MGModule\vultr as main;

/**
 * Description of error\register
 *
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
class Register{        
    static private $_errorRegister = null;
    
    static function setErrorRegisterClass($class){
        self::$_errorRegister = $class;
    }
    
    
    static function register($ex){        
        if(self::$_errorRegister && class_exists(self::$_errorRegister,false))
        {
            call_user_func(array(self::$_errorRegister,'register',$ex));
        }
        elseif(class_exists(main\mgLibs\process\MainInstance::I()->getMainNamespace().'\models\whmcs\errors\Register'))
        {
            call_user_func(array(main\mgLibs\process\MainInstance::I()->getMainNamespace().'\models\whmcs\errors\Register','register'),$ex);
        }
        else
        {
            $token = 'Unknow Token';

            if(method_exists($ex, 'getToken'))
            {
                $token = $ex->getToken();
            }

            $debug = print_r($ex,true);

            \logModuleCall("MGError",__NAMESPACE__,array(
                        'message' => $ex->getMessage()
                        ,'code'   => $ex->getCode()
                        ,'token'  => $token
                    ),  $debug,0,0);
        }
    }
}