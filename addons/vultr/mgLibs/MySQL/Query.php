<?php

namespace MGModule\vultr\mgLibs\MySQL;
use MGModule\vultr as main;

/**
 * MySQL Query Class
 *
 * @author Michal Czech <michael@modulesgarden.com>
 * @SuppressWarnings(PHPMD)
 */
class Query{
    /**
     *
     * @var array
     */
    private $connection = array();
    
    /**
     * Use PDO for Connection
     * 
     * @var boolean 
     */
    static private $usePDO = false;
    
    /**
     *
     * @var main\mgLibs\MySQL\Query
     */
    static private $_instance;    
    
    static $lastQuery;
    
    /**
     * Disable construct & clone method
     */
    private function __construct() {;}
    private function __clone() {;}

    /**
     * Get Singleton instance
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param string $hostName
     * @param string $username
     * @param string $password
     * @param string $dbname
     * @param string $connectionName
     * @return main\mgLibs\MySQL\Query
     * @throws main\exception\System
     */
    public static function I()
    {
        if(empty(self::$_instance))
        {
            throw new main\mgLibs\exceptions\System('Object not Spawned');
        }
        return self::$_instance;
    }
    
    /**
     * Use Current Default MySQL Connection for queries
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     */
    public static function useCurrentConnection(){
        //Use by default PDO in WHMCS 6 and 7 
        if(class_exists('\Illuminate\Database\Capsule\Manager') && \Illuminate\Database\Capsule\Manager::connection()->getPdo())
        {
            self::$usePDO = true;
            self::$_instance->connection['default'] = \Illuminate\Database\Capsule\Manager::connection()->getPdo();
        }
        else
        {
            self::$_instance = new self();
            self::$_instance->connection['default'] = false;
        }
    }
    
    /**
     * Connect DB From File
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param string $file
     * @throws main\exception\System
     * @return boolean
     */
    public static function connectFromFile($file){
        if(!file_exists($file))
        {
            throw new main\mgLibs\exceptions\System('DB Connection File does not exits', main\mgLibs\exceptions\Codes::MYSQL_MISING_CONFIG_FILE);
        }
        
        self::$_instance = new self();
        
        include $file;
        
        foreach($config as $connectionName => $config)
        {
            if ($config['host']) 
            {
                if(self::$usePDO)
                {
                    if(!extension_loaded('PDO'))
                    {
                        throw new main\mgLibs\exceptions\System('Missing PDO Extension',  main\mgLibs\exceptions\Codes::MYSQL_MISING_PDO_EXTENSION);
                    }

                    try{                                       
                        self::$_instance->connection[$connectionName] = new \PDO("mysql:host=".$config['host'].";dbname=".$config['name'], $config['user'], $config['pass']); 

                        self::$_instance->connection[$connectionName]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    } catch (\Exception $ex) {
                        throw new main\mgLibs\exceptions\System('SQL Connection Error',exceptions\Codes::MYSQL_CONNECTION_FAILED);
                    }
                }
                else
                { 
                    if(self::$_instance->connection[$connectionName] = mysql_connect($config['host'], $config['user'], $config['pass'], true))
                    {
                        mysql_select_db($config['name'], self::$_instance->connection[$connectionName]);

                        if($error = mysql_error())
                        {
                            throw new main\mgLibs\exceptions\System($error,main\mgLibs\exceptions\Codes::MYSQL_CONNECTION_FAILED);
                        }
                    }
                    else
                    {
                        throw new main\mgLibs\exceptions\System('SQL Connection Error',main\mgLibs\exceptions\Codes::MYSQL_CONNECTION_FAILED);
                    }
                }
            }
        }
        
        return true;
    }
    
    /**
     * Disconnect all mysql connection
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     */
    static function dropAllConnection(){
        foreach(self::I()->connection as $name => &$connection)
        {
            $connection = null;
            unset(self::I()->connection[$name]);
        }
    }
    
  /**
     * Custom MySQL Query 
     * 
     * @param string $query
     * @param array $params
     * @param string $connectionName
     * @return result
     * @throws main\mgLibs\exceptions\System
     */
    static function query($query,array $params=array(), $connectionName = 'default')
    {
        if(!isset(self::$_instance->connection[$connectionName]))
        {
            throw new main\mgLibs\exceptions\System("Connection ".$connectionName.' not exits', main\mgLibs\exceptions\Codes::MYSQL_MISING_CONNECTION);
        }
        
        $newParams = array();
        foreach($params as $name => $value)
        {
            $newParams[':'.$name] = $value;
        }
        
        $params = $newParams;
        
        if(self::$usePDO)
        {
            try{
                $sth = self::$_instance->connection[$connectionName]->prepare($query);
                $a = $sth->execute($params);              
            } catch (\Exception $ex) {
                $dQuery = $query;
                foreach($params as $n => $v)
                {
                    $dQuery = str_replace($n, "'".$v."'", $dQuery);
                }
                
                throw new Exception('Error in SQL Query:'.$ex->getMessage(),$dQuery,$ex);
            }
            
            if(strpos($query, 'insert') !== false || strpos($query, 'INSERT')!== false )
            {
                $id = self::$_instance->connection[$connectionName]->lastInsertId(); 
            }
            else
            {
                $id = null;
            }
            
            return new Result($sth,$id);
        }
        else
        {
            foreach ($params as $key => $value) 
            {
                if(is_array($value))
                {
                    throw new main\mgLibs\exceptions\System("Cant use array as MySQL Value");
                }
                if($value === null)
                {
                    $query = str_replace("$key", "null", $query);
                }
                elseif($value === false)
                {
                    $query = str_replace("$key", "0", $query);
                }
                elseif(is_string($value))
                {
                $query = str_replace("$key", "'".mysql_real_escape_string($value)."'", $query);
            }
                else
                {
                    $query = str_replace("$key", mysql_real_escape_string($value), $query);
                }
            }
            
            self::$lastQuery = $query;
            
            if(!empty(self::$_instance->connection[$connectionName]))
            {
                $result = mysql_query($query,self::$_instance->connection[$connectionName]);
            }
            else
            {
                $result = mysql_query($query);
            }

            if($error = mysql_error())
            {
                throw new Exception('Error in SQL Query:'.$error,$query);
            }

            if(strpos($query, 'insert') !== false || strpos($query, 'INSERT')!== false )
            {
                $id = mysql_insert_id();
            }
            else
            {
                $id = null;
            }

            return new Result($result,$id);
        }
    }
    
    /**
     * Disconnect specifi MySQL socket
     * 
     * @param string $connectionName
     */
    static function dropInstance($connectionName = 'default')
    {
        if(self::$usePDO)
        {
            unset(self::$_instance->connection[$connectionName]);
        }
        else
        {
            mysql_close(self::$_instance->connection[$connectionName]);
        }
    }
    
    /**
     * Simple Insert Query
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param string $table
     * @param array $data
     * @param string $connectionName
     * @throws \exception\System
     * @return int id of new record
     */
    static function insert($table,array $data, $connectionName = 'default')
    {
        $cols = array();
        $valuesLabels = array();
        $values = array();
        $i = 0;
        foreach($data as $col => $value)
        {
            $cols[] = $col;
            $colName = 'col'.$i;
            $valuesLabels[] = ':'.$colName;
            
            $values[$colName] = $value;
            $i++;
        }
        
        $cols = implode("`,`", $cols);
        $valuesLabels = implode(",", $valuesLabels);

        $sql = "INSERT INTO $table (`$cols`) VALUES ($valuesLabels)";
          
        $val = self::query($sql,$values,$connectionName)->getID();
        
        return $val;
    }
    
    /**
     * Simple Insert Query
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param string $table
     * @param array $data
     * @param string $connectionName
     * @throws \exception\System
     * @return int id of new record
     */
    static function insertOnDuplicateUpdate($table,array $data, array $update, $connectionName = 'default')
    {
        $cols = array();
        $valuesLabels = array();
        $values = array();
        $i = 0;
        foreach($data as $col => $value)
        {
            $cols[] = $col;
            $colName = 'col'.$i;
            $valuesLabels[] = ':'.$colName;
            
            $values[$colName] = $value;
            $i++;
        }
        
        $cols = implode("`,`", $cols);
        $valuesLabels = implode(",", $valuesLabels);

       
        $sql = "INSERT INTO $table (`$cols`) VALUES ($valuesLabels)";
                        
        $sql .= "ON DUPLICATE KEY UPDATE ";
        
        $cols = array();
        $valuesLabels = array();

        foreach($update as $col => $value)
        {
            $colName = preg_replace("/[^A-Za-z0-9]/", '', $col);
            
            $cols[] = "`$col` = :$colName:";
                        
            $values[$colName] = $value;
        }
        
        $sql .= implode(",", $cols);
        
        $val = self::query($sql,$values,$connectionName)->getID();
        
        return $val;
    }
    
    /**
     * Simple Update Request
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param string $table
     * @param array $data
     * @param array $condition
     * @param array $conditionValues
     * @throws \exception\System
     * @return result
     */
    static function update($table,array $data,array $condition)
    {
        $conditionParsed = self::parseConditions($condition,$values);
        
        $cols = array();
        $valuesLabels = array();

        foreach($data as $col => $value)
        {
            $colName = preg_replace("/[^A-Za-z0-9]/", '', $col);
            
            $cols[] = "`$col` = :$colName";
                        
            $values[$colName] = $value;
        }
        
        $cols = implode(",", $cols);
                
        $sql = "UPDATE $table SET $cols ";
        
        if($conditionParsed)
        {
            $sql .= " WHERE ".$conditionParsed;
        }
        
        return self::query($sql,$values);
    }
    
    /**
     * Simple Delete Request
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param string $table
     * @param array $condition
     * @param array $conditionValues
     * @throws \exception\System
     * @return result
     */
    static function delete($table,array $condition)
    {               
        $sql = "DELETE FROM $table";
        
        $conditionParsed = self::parseConditions($condition,$values);
                
        if($conditionParsed)
        {
            $sql .= " WHERE ".$conditionParsed;
        }
        
        return self::query($sql,$values);
    }
    
    /**
     * Parse MySQL Conditions
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param type $condition
     * @param type $values
     * @return type
     */
    static function parseConditions($condition,&$values, $prefix = null, &$i = 0){
        $conditionParsed = array();
                
        $values = array();
        
        foreach($condition as $col => $value)
        {
            if(is_string($col))
            {
                if(is_array($value))
                {
                    $conditionTmp = array();
                    foreach($value as $v)
                    {
                        $colName = ':cond'.$i;
                        $conditionTmp[] = $colName;
                        $values['cond'.$i] = $v;
                        $i++;
                    }
                    if($prefix)
                    {
                        $conditionParsed[] = "`$prefix`.`$col` in (".implode(',',$conditionTmp).')';
                    }
                    else
                    {
                        $conditionParsed[] = "`$col` in (".implode(',',$conditionTmp).')';
                    }
                }
                else
                {
                    $colName = ':cond'.$i;    
                    if($prefix)
                    {
                        $conditionParsed[] = "`$prefix`.`$col` = $colName";
                    }
                    else
                    {
                        $conditionParsed[] = "`$col` = $colName";
                    }
                    
                    $values['cond'.$i] = $value;
                    $i++;
                }
            }
            elseif(is_array($value) && isset($value['customQuery']))
            {
                $conditionParsed[] = $value['customQuery'];
                foreach ($value['params'] as $n => $v)
                {
                    $values[$n] = $v;
                }
            }
            else
            {
                $conditionParsed[] = $value;
            }
            
        }

        return implode(' AND ', $conditionParsed);
    }
    
    static function formatSelectFields($cols,$prefix = null){
        foreach($cols as $name => &$value)
        {
            if(!is_int($name))
            {
                if($prefix)
                {
                   $value = "`$prefix`.`$name` as '$value'"; 
                }
                else
                {
                    $value = "`$name` as '$value'";
                }
            }
            else
            {
                if($prefix)
                {
                    $value = "`$prefix`.`$value`";
                }
                else
                {
                    $value = "`$value`";
                }
            }
        }
        unset($value);
        
        return implode(",", $cols);
    }
    
    static function formatOrderBy($orderBy,$prefix = null){
        if(empty($orderBy))
        {
            return;
        }
        
        $tmp = array();
        foreach($orderBy as $col => $vect)
        {
            if($prefix)
            {
                $tmp[] = "`$prefix`.`$col` ".(($vect=='ASC'||$vect=='asc')?'ASC':'DESC');
            }
            else
            {
                $tmp[] = "`$col` ".(($vect=='ASC'||$vect=='asc')?'ASC':'DESC');
            }
        }

        return " ORDER BY ".implode(',', $tmp);
    }
    
    static function formarLimit($limit,$offset)
    {
        if($limit)
        {
            if($offset)
            {
                return " LIMIT $offset , $limit ";
            }
            else
            {
                return " LIMIT 0 , $limit ";
            }
        }
    }
    
    /**
     * Simple Select Query
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param array $cols
     * @param string $table
     * @param array $conditionValues
     * @param array $groupBy
     * @param int $limit
     * @param int $offset
     * @throws \exception\System
     * @return result
     */
    static function select(array $cols,$table,array $condition = array(),array $orderBy = array(),$limit = null,$offset = 0, $connectionName = 'default')
    {
        
        $cols = self::formatSelectFields($cols);
        
        $sql = "SELECT $cols FROM $table";
        
        $conditionParsed = self::parseConditions($condition,$values);
         
        if($conditionParsed)
        {
            $sql .= " WHERE ".$conditionParsed;
        }

        $sql .= self::formatOrderBy($orderBy);
        
        $sql .= self::formarLimit($limit, $offset);
        
   
        return self::query($sql,$values);
    }
    
    /**
     * Simple Select Query
     * 
     * @author Michal Czech <michael@modulesgarden.com>
     * @param array $cols
     * @param string $table
     * @param array $conditionValues
     * @param array $groupBy
     * @param int $limit
     * @param int $offset
     * @throws \exception\System
     * @return result
     */
    static function count($colsName,$table,array $condition = array(),array $orderBy = array(),$limit = null,$offset = 0, $connectionName = 'default')
    {       
        $sql = "SELECT count($colsName) as count FROM $table";
        
        $conditionParsed = self::parseConditions($condition,$values);
                
        if($conditionParsed)
        {
            $sql .= " WHERE ".$conditionParsed;
        }
        
        if($orderBy)
        {
            $sql .= " ORDER BY ";
            $tmp = array();
            foreach($orderBy as $col => $vect)
            {
                $tmp[] = "`$col` $vect";
            }
            $sql .= implode(',', $tmp);
        }
        
        if($limit)
        {
            if($offset)
            {
                $sql .= " LIMIT $offset , $limit ";
            }
            else
            {
                $sql .= " LIMIT 0 , $limit ";
            }
        }

        return self::query($sql,$values)->fetchColumn('count');
    }
}
