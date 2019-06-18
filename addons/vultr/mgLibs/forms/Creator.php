<?php

namespace MGModule\vultr\mgLibs\forms;
use MGModule\vultr as main;


/**
 * Form Creator
 *
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
class Creator{
    /**
     *
     * @var abstractField[]
     */
    public $fields = array();
    public $hidden = array();
    public $name;
    public $url = null;
    public $addFormNameToFields = false;
    public $addIDs = true;
    public $autoPrepare = true;      
    public $getHTMLCount = 0;
    public $lastID = null;
    
    function __construct($name,$options = array()) {
        $this->name = $name;
        $this->addIDs = $name;
        
        foreach($options as $name => $value)
        {
            if(property_exists($this, $name))
            {
                $this->{$name} = $value;
            }
        }
        
        $this->hidden[] = new HiddenField(array(
            'name'      => 'mg-token'
            ,'value'    => md5(time())
        ));
    }
    
    /**
     * 
     * @param \MGModule\vultr\mgLibs\forms\className $field
     * @param type $dataOrName
     * @param type $data
     * @throws main\mgLibs\exceptions\System
     */
    function addField($field,$dataOrName = null,$data = array()){
        
        if(is_string($dataOrName))
        {
            $data['name'] = $dataOrName;
        }
        elseif(is_array($dataOrName))
        {
            $data = $dataOrName;
        }
        
        $data['formName'] = $this->name;
        
        if(is_object($field))
        {
            if(get_parent_class($field) !== __NAMESPACE__.'\\'.'AbstractField')
            {
                throw new \MGModule\vultr\mgLibs\exceptions\System('Unable to use this object as form field');
            }
                        
            if($field->type == 'hidden')
            {
                $this->hidden[]             = $field;
            }
            else
            {
                $this->fields[]             = $field;
            }
            
        }
        elseif(is_string($field) && is_array($data))
        {
            $field = ucfirst($field);
            $className = __NAMESPACE__.'\\'.$field.'Field';
            
            if(!class_exists($className))
            {
                throw new \MGModule\vultr\mgLibs\exceptions\System('Unable to crate form field type:'.$className);
            }
            
            $field = new $className($data);
            
            $field->formName            = $this->name;
            
            if($field->type == 'hidden')
            {
                $this->hidden[]             = $field;
            }
            else
            {
                $this->fields[]             = $field;
            }
            
        }
        else
        {
            throw new \MGModule\vultr\mgLibs\exceptions\System('Unable create form field object');
        }
    }
    
    function anyField(){
        return !empty($this->fields);
    }

    function prepare(){
        foreach($this->fields as &$field)
        {
            $field->html                = null;
            $field->addFormNameToFields = $this->addFormNameToFields;
            $field->addIDs              = $this->addIDs;
            $field->formName            = $this->name;
        }
    }
    
    function setIDs($id){
        $this->addIDs = $id;
    }
    
    function getHTML($container = 'default',$data = array()){
        main\mgLibs\Lang::stagCurrentContext('generateForm');
        main\mgLibs\Lang::addToContext($this->name);

        if($this->autoPrepare)
        {
            $this->addIDs .= '_'.$container;
            $this->prepare();
        }
        
        $closedTag = true;
        
        foreach($this->fields as $field)
        {
            if(empty($field->html))
            {
                if($closedTag)
                {
                    $field->opentag = true;
                }
                else
                {
                    $field->opentag = false;
                    $closedTag      = true;
                }
                
                if($field->continue)
                {
                    $closedTag = $field->closetag = false;
                }
                else
                {
                    $field->closetag = true;
                }
                
                $field->generate();
            }
        }
        
        foreach($this->hidden as $field)
        {
            if(empty($field->html))
            {
                $field->generate();
            }
        }
        
        $data['name']       = $this->name;
        $data['url']        = $this->url;
        $data['fields']     = $this->fields;
        $data['hidden']     = $this->hidden;
                
        $html = main\mgLibs\Smarty::I()->view($container, $data,   main\mgLibs\process\MainInstance::getModuleTemplatesDir().DS.'formFields'.DS.'containers');
        
        main\mgLibs\Lang::unstagContext('generateForm');
        
        $this->getHTMLCount++;
        
        return $html;
    }
    
    public function deleteFields(){
            $this ->fields = array();
            $this ->hidden = array();
    }
    

    /**
     * 
     * @param type $prefix
     * @return \MGModule\vultr\mgLibs\forms\Creator
     */
    public function rebuildFieldIds($prefix){
        
        foreach($this ->fields as $field){
            if($field->id){
                $field->id .=$prefix;
                $field->html = null;
            }
        }
        
        return $this;
    }
    
}