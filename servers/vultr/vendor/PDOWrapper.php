<?php

use Illuminate\Database\Capsule\Manager as DB;

//mysql_error() to try catch z PDOException
//mysql_close wywalic
//mysql_affected_rows ->> zmiana na PDOWrapper::num_rows($resource) 

class PDOWrapper
{
    public static function query($query, $params = array()) {
        $statement = DB::connection()
                ->getPdo()
                ->prepare($query);
        $statement->execute($params);
        return $statement;
    }
    
    public static function real_escape_string($string)
    {  
        return substr(DB::connection()->getPdo()->quote($string),1,-1);
    }
    
    public static function fetch_assoc($query)
    {
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    public static function fetch_array($query)
    {
        return $query->fetch(\PDO::FETCH_BOTH);
    }
    
    public static function fetch_object($query)
    {
        return $query->fetch(\PDO::FETCH_OBJ);
    }
    
    public static function num_rows($query)
    {
        $query->fetch(\PDO::FETCH_BOTH);
        return $query->rowCount();
    }
    
    public static function insert_id()
    {
        return DB::connection()
                ->getPdo()
                ->lastInsertId();
    }
}
