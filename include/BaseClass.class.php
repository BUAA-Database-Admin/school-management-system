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
        return self::newInstances($arr)[0];
    }

    final public static function newInstances($arr)
    {
        $class = get_called_class();
        $table = strtolower(preg_replace(['/([a-z])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $class));
        $sql = "SELECT * FROM `{$table}`";
        if (isset($arr)) {
            $sql .= ' WHERE ';
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
        }
        global $db;
        $results = $db->query($sql);
        if ($results == false || $results->num_rows == 0) {
            return null;
        }
        while ($result = $results->fetch_array()) {
            $instances[] = new $class($result);
        }
        return $instances;
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
            if (empty($value) && static::$typeHint[$name][1] == 'nn') {
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
        foreach ($arr as $key => $value) {
            if (property_exists(get_class($this), $key)) {
                $this->{$key} = $value;
                if (isset(static::$typeHint[$key])) {
                    settype($this->{$key}, static::$typeHint[$key][0]);
                }
            }
        }
    }
}
