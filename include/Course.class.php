<?php

/**
 * Class Course
 *
 * @author EternalPhane
 */
require_once 'BaseClass.class.php';
class Course extends \BaseClass
{
    protected $id;
    protected $name;
    protected $credit;
    public static function init()
    {
        self::$typeHint['id'] = 'int';
        self::$typeHint['name'] = 'string';
        self::$typeHint['credit'] = 'int';
    }
    public function __construct($arr_both)
    {
        parent::__construct($arr_both);
        foreach (get_object_vars($this) as $key => $value) {
            if (empty($value)) {
                throw new \Exception("{$key} can't be null!");
            }
        }
    }
}