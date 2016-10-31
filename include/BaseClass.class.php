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

    abstract protected static function initTypeHint();

    final public static function init()
    {
        if (get_called_class() == __CLASS__ || isset(static::$typeHint)) {
            return;
        }
        static::initTypeHint();
        foreach (static::$typeHint as &$value) {
            $value = explode(' ', $value);
        }
    }

    final public static function newInstance(array $arr)
    {
        $class = get_called_class();
        $table = strtolower($class);
        $sql = "SELECT * FROM `{$table}` WHERE ";
        $clauses = array();
        foreach ($arr as $key => $value) {
            if (!property_exists($class, $key)) {
                return null;
            }
            $clause = "`{$key}` = ";
            if (static::$typeHint[$key][0] == 'int') {
                $clause .= $value;
            } else {
                $clause .= "'{$value}'";
            }
            $clauses[] = $clause;
        }
        $sql .= implode(' AND ', $clauses);
        global $db;
        $result = $db->query($sql);
        if ($result == false || $result->num_rows == 0) {
            return null;
        }
        return new $class($result->fetch_array());
    }

    final public function __get(string $name)
    {
        if (property_exists(get_class($this), $name)) {
            return $this->{$name};
        }
    }

    final public function __set(string $name, $value)
    {
        if (isset(static::$typeHint[$name])) {
            if (is_null($value) && static::$typeHint[$name][1] == 'nn') {
                throw new Exception("{$name} can't be null!", 1);
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
}
