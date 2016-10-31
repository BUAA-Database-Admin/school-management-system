<?php
/**
 * Class Department
 *
 * Base class for all other custom classes.
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Department extends BaseClass
{
    protected static $typeHint;
    protected $id;
    protected $name;

    use Updatable;
    use Insertable;

    protected static function initTypeHint()
    {
        static::$typeHint['id'] = 'int nn';
        static::$typeHint['name'] = 'string nn';
    }
}
