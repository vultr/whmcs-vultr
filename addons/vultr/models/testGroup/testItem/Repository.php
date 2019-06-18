<?php

namespace MGModule\vultr\models\testGroup\TestItem;
use MGModule\vultr as main;
use MGModule\vultr\mgLibs;
use MGModule\vultr\models\testGroup\simpleItem;

/**
 * Description of repository
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository{
    public function getModelClass() {
        return __NAMESPACE__.'\TestItem';
    }
    
    public function get() {      
        $sql = "
            SELECT
                ".mgLibs\MySQL\Query::formatSelectFields(testItem::fieldDeclaration(),'B')."
                ,count(S.`". simpleItem\simpleItem::getProperyColumn('id')."`) as simpleNum
            FROM
                ".testItem::tableName()." B
            LEFT JOIN
                ".simpleItem\simpleItem::tableName()." S
                ON
                    S.`". simpleItem\simpleItem::getProperyColumn('testItemID')."` = B.`".testItem::getProperyColumn('id')."`
        ";

        $conditionParsed = mgLibs\MySQL\Query::parseConditions($this->_filters,$params,'B');

        if($conditionParsed)
        {
            $sql .= " WHERE ".$conditionParsed;
        }
        
        $sql .= " GROUP BY `B`.`".testItem::getProperyColumn('id')."` ";

        
        $sql .= mgLibs\MySQL\Query::formarLimit($this->_limit, $this->_offest);

        $result = mgLibs\MySQL\Query::query($sql,$params);
        
        $output = array();
        
        $class = $this->getModelClass();
        
        while($row = $result->fetch())
        {
            $output[] = new $class($row['id'],$row);
        }

        return $output;
    }
}
