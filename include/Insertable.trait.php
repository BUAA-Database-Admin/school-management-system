<?php
/**
 * Trait Insertable
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

trait Insertable
{
    final public static function insert(array $col) : bool
    {
        $table = strtolower(preg_replace(['/([a-z])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', __CLASS__));
        $sql = "INSERT INTO `${table}` (`";
        $sql .= implode('`, `', array_keys($col));
        $sql .= '`) VALUES (';
        foreach ($col as $key => $value) {
            if (empty($value)) {
                $tmp[] = 'NULL';
            } elseif (self::$typeHint[$key][0] == 'int') {
                $tmp[] = $value;
            } else {
                $tmp[] = "'{$value}'";
            }
        }
        $sql .= implode(', ', $tmp);
        $sql .= ')';
        global $db;
        return $db->query($sql);
    }
}
