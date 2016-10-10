<?php

/**
 * Class Contact
 *
 * @author EternalPhane
 */
require_once __DIR__ . '/config.php';
class Contact extends \BaseClass
{
    protected static $typeHint;
    protected $user_id;
    protected $email;
    protected $telephone;
    protected $mobile;
    protected static function initTypeHint()
    {
        static::$typeHint['user_id'] = 'int nn';
        static::$typeHint['email'] = 'string';
        static::$typeHint['teltphone'] = 'string';
        static::$typeHint['mobile'] = 'string';
    }
}