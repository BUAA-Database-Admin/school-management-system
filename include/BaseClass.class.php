<?php

/**
 * Class BaseClass
 *
 * Base class for all other custom classes.
 *
 * @author EternalPhane
 */
require_once 'config.php';
abstract class BaseClass
{
    protected static $typeHint;
    protected static $table;
    public static abstract function init();
    public function __construct(array $arr_both)
    {
        foreach ($arr_both as $key => $value) {
            $this->{$key} = $value;
        }
        foreach (get_object_vars($this) as $key => $value) {
            if (isset(self::$typeHint[$key])) {
                settype($this->{$key}, self::$typeHint[$key]);
            }
        }
    }
    public final function __get(string $name)
    {
        if (property_exists(get_class($this), $name)) {
            return $this->{$name};
        }
    }
    public final function __set(string $name, $value)
    {
        if (property_exists(get_class($this), $name)) {
            $this->{$name} = $value;
        }
    }
    protected final function update() : bool
    {
        $sql = "UPDATE `{$table}` SET ";
        $vars = get_object_vars($this);
        next($vars);
        next($vars);
        $primary = key($vars);
        foreach ($vars as $key => $value) {
            if (empty(self::$typeHint[$key])) {
                continue;
            }
            $clause = "`{$key}` = ";
            if (empty($value)) {
                $clause .= 'NULL, ';
            } else {
                if (self::$typeHint[$key] == 'int') {
                    $clause .= "{$value}, ";
                } else {
                    $clause .= "'{$value}', ";
                }
            }
            $sql .= $clause;
        }
        $sql .= "WHERE `{$primary}` = {$vars[$primary]}";
        global $db;
        return $db->query($sql);
    }
}