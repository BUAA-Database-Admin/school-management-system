<?php
/**
 * Trait Updatable
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

trait Updatable
{
    final public function update(string ...$fields) : bool
    {
        if (sizeof($fields)) {
            return $this->updateFields($fields);
        }
        return $this->updateFields(array_keys(static::$typeHint));
    }

    final private function updateFields($arr) : bool
    {
        $table = strtolower(preg_replace(['/([a-z])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', __CLASS__));
        $sql = "UPDATE `{$table}` SET ";
        $clauses = array();
        foreach ($arr as $value) {
            if (is_null(static::$typeHint[$value])) {
                continue;
            }
            $clause = "`{$value}` = ";
            if (is_null($this->{$value})) {
                $clause .= 'NULL';
            } elseif (static::$typeHint[$value][0] == 'int') {
                $clause .= $this->{$value};
            } else {
                $clause .= "'{$this->{$value}}'";
            }
            $clauses[] = $clause;
        }
        $sql .= implode(', ', $clauses);
        reset(static::$typeHint);
        $primary = key(static::$typeHint);
        $sql .= " WHERE `{$primary}` = {$this->{$primary}}";
        global $db;
        return $db->query($sql);
    }
}
