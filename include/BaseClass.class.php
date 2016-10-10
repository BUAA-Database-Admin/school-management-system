<?php

/**
 * Class BaseClass
 *
 * Base class for all other custom classes.
 *
 * @author EternalPhane
 */
require_once __DIR__ . '/config.php';
abstract class BaseClass
{
    protected static $typeHint;
    protected static abstract function initTypeHint();
    public static final function init()
    {
        if (get_called_class() == __CLASS__ || isset(static::$typeHint)) {
            return;
        }
        static::initTypeHint();
        foreach (static::$typeHint as &$value) {
            $value = explode(' ', $value);
        }
    }
    public static final function newInstance(string $key, string $value)
    {
        $class = get_called_class();
        if (property_exists($class, $key)) {
            $table = strtolower($class);
            $sql = "SELECT * FROM `{$table}` WHERE `{$key}` = ";
            if (static::$typeHint[$key][0] == 'int') {
                $sql .= $value;
            } else {
                $sql .= "'{$value}'";
            }
            global $db;
            $result = $db->query($sql);
            if ($result == false || $result->num_rows == 0) {
                return null;
            }
            return new $class($result->fetch_array());
        }
        return null;
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
            if (is_null($value) && static::$typeHint[$name][1] == 'nn') {
                throw new \Exception("{$name} can't be null!", 1);
            }
            $this->{$name} = $value;
            if (isset($value)) {
                settype($this->{$name}, static::$typeHint[$name][0]);
            }
        }
    }
    protected function __construct(array $arr)
    {
        foreach (static::$typeHint as $key => $value) {
            $this->__set($key, $arr[$key]);
        }
    }
    public final function update(string ...$fields) : bool
    {
        if (sizeof($fields)) {
            return $this->updateFields($fields);
        }
        return $this->updateFields(array_keys(static::$typeHint));
    }
    private final function updateFields($arr) : bool
    {
        $table = strtolower(get_called_class());
        $sql = "UPDATE `{$table}` SET ";
        foreach ($arr as $value) {
            if (is_null(static::$typeHint[$value])) {
                continue;
            }
            $clause = "`{$value}` = ";
            if (is_null($this->{$value})) {
                $clause .= 'NULL, ';
            } elseif (static::$typeHint[$value][0] == 'int') {
                $clause .= "{$this->{$value}}, ";
            } else {
                $clause .= "'{$this->{$value}}', ";
            }
            $sql .= $clause;
        }
        reset(static::$typeHint);
        $primary = key(static::$typeHint);
        $sql .= "WHERE `{$primary}` = {$this->{$primary}}";
        global $db;
        return $db->query($sql);
    }
}