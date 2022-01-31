<?php
require_once '../lib/Database/Adapter/Abstract.php';
require_once '../lib/Config.php';

class ConfigDatabase {    
    public static function load(DatabaseAdapterAbstract $adapter, 
        $table = 'config', $field1 = 'name', $field2 = 'value') {
        $sql = 'SELECT * FROM `'.$table.'`';
        
        $statement = $adapter->query($sql);
        $rows      = array();
        while ($row = $adapter->fetchRow($statement)) {            
            if (($rows[$row[$field1]] = @unserialize($row[$field2])) === false) {
                $rows[$row[$field1]] = $row[$field2];
            }
        }
        return $rows;
    }    
    
    public static function save(Config $config, DatabaseAdapterAbstract $adapter, 
        $table = 'config', $field1 = 'name', $field2 = 'value') {
            
        foreach ($config as $name => $value) {
            $sql = 'REPLACE INTO `'.$table.'` 
				SET 
					`'.$field1.'`=\''.$name.'\',
					`'.$field2.'`=\''.serialize($value).'\'					
			'; $adapter->query($sql);
        }
    }
}
?>