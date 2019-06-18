<?php

if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);



function vultr_config(){
    require_once 'Loader.php';
    new \MGModule\vultr\Loader();
    return MGModule\vultr\Addon::config();
}

function vultr_activate(){
    require_once 'Loader.php';
    new \MGModule\vultr\Loader();
    return MGModule\vultr\Addon::activate();
}

function vultr_deactivate(){
    require_once 'Loader.php';
    new \MGModule\vultr\Loader();
    return MGModule\vultr\Addon::deactivate();
}

function vultr_upgrade($vars){
    require_once 'Loader.php';
    new \MGModule\vultr\Loader();
    return MGModule\vultr\Addon::upgrade($vars);
}

function vultr_output($params){
    require_once 'Loader.php';
    new \MGModule\vultr\Loader();
    
    MGModule\vultr\Addon::I(FALSE,$params);
    
    if(!empty($_REQUEST['json']))
    {
        ob_clean();
        header('Content-Type: text/plain');
        echo MGModule\vultr\Addon::getJSONAdminPage($_REQUEST);
        die();
    }
    
    if(!empty($_REQUEST['customPage']))
    {
        ob_clean();
        echo MGModule\vultr\Addon::getHTMLAdminCustomPage($_REQUEST);
        die();
    }

    echo MGModule\vultr\Addon::getHTMLAdminPage($_REQUEST);
}


function vultr_clientarea(){
    require_once 'Loader.php';
    new \MGModule\vultr\Loader();
    
    
    
    if(!empty($_REQUEST['json']))
    {
        ob_clean();
        header('Content-Type: text/plain');
        echo MGModule\vultr\Addon::getJSONClientAreaPage($_REQUEST);
        die();
    }
    
    return MGModule\vultr\Addon::getHTMLClientAreaPage($_REQUEST);
}