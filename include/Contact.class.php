<?php

/**
 * Class Contact
 *
 * @author EternalPhane
 */
require_once 'BaseClass.class.php';
class Contact extends \BaseClass
{
    protected $user_id;
    protected $email;
    protected $telephone;
    protected $mobile;
    public static function init()
    {
        self::$typeHint['user_id'] = 'int';
        self::$typeHint['email'] = 'string';
        self::$typeHint['teltphone'] = 'string';
        self::$typeHint['mobile'] = 'string';
    }
    public function __construct(array $arr_both)
    {
        parent::__construct($arr_both);
        if (empty($arr_both['user_id'])) {
            throw new \Exception("user_id can't be null!");
        }
    }
}