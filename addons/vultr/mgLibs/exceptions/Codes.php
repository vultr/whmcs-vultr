<?php

namespace MGModule\vultr\mgLibs\exceptions;
use MGModule\vultr as main;

/**
 * Exception Codes 
 * 
 * @todo extends number of supported codes
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Codes {
    const MISING_FILE_CLASS                         = 1;
    const PROPERTY_NOT_EXISTS                       = 2;
    const MISING_OBJECT_PROPERTY                    = 3;
    
    // Database
    const MYSQL_CONNECTION_FAILED                   = 100;
    const MYSQL_QUERY_FAILED                        = 101;
    const MYSQL_MISING_CONNECTION                   = 102;
    const MYSQL_MISING_CONFIG_FILE                  = 103;
    const MYSQL_MISING_PDO_EXTENSION                = 104;
}
