<?php
/**
 * Class Course
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Course extends BaseClass
{
    protected static $typeHint;
    protected $id;
    protected $name;
    protected $credit;
    protected $user_id;

    use Updatable;
    use Insertable;

    protected static function initTypeHint()
    {
        static::$typeHint['id'] = 'int nn';
        static::$typeHint['name'] = 'string nn';
        static::$typeHint['credit'] = 'int nn';
        static::$typeHint['user_id'] = 'int nn';
    }
}
