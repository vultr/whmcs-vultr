<?php

namespace MGModule\vultr\mgLibs\forms;
use MGModule\vultr as main;

/**
 * Abstract Form Field
 *
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
abstract class AbstractField {
    public $name;
    public $value;
    public $type;
    public $enableDescription = false;
    public $enableLabel = true;
    public $formName = false;
    public $default;
    public $nameAttr;
    public $addFormNameToFields = false;
    public $dataAttr = array();
    public $readonly = false;
    public $disabled = false;
    public $addIDs = false;
    public $colWidth = 9;
    public $labelcolWidth =2;
    public $continue = false;
    public $html = '';
    public $additinalClass = false;
    public $opentag;
    public $closetag;
    public $error;
    public $id = false;
    public $required = false;
    
    function __construct($params = array()) {  
        foreach($params as $name => $value)
        {
            if(property_exists($this, $name))
            {
                $this->{$name} = $value;
            }
        }
    }
    
    function prepare(){
        ;
    }
    
    function generate(){
        $this->prepare();
        
        if($this->addFormNameToFields && empty($this->nameAttr))
        {
            $this->nameAttr = $this->formName.'_'.$this->name;
        }
        
        if(empty($this->nameAttr))
        {
            $this->nameAttr = $this->name;
        }
        
        if(empty($this->value) && !empty($this->default))
        {
            $this->value = $this->default;
        }
        
        if($this->opentag == false)
        {
            $this->enableLabel = false;
        }
        
        main\mgLibs\Lang::stagCurrentContext('generateField');
        
        if($this->type == 'submit')
        {
            main\mgLibs\Lang::addToContext($this->value);
        }
        else
        {
            main\mgLibs\Lang::addToContext($this->name);
        }
        
        $this->html = main\mgLibs\Smarty::I()->view($this->type, (array)$this, main\mgLibs\process\MainInstance::getModuleTemplatesDir().DS.'formFields');
        
        main\mgLibs\Lang::unstagContext('generateField');
    }    
}