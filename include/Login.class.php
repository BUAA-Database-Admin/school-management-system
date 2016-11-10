<?php
/**
 * Class Login
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Login extends BaseClass
{
    protected static $typeHint;
    protected $user_id;
    protected $password;
    protected $salt;
    protected $fails;
    protected $last_fail;

    use Updatable;
    use Insertable;

    protected static function initTypeHint()
    {
        static::$typeHint['user_id'] = 'int nn';
        static::$typeHint['password'] = 'string nn';
        static::$typeHint['salt'] = 'string nn';
        static::$typeHint['fails'] = 'int';
        static::$typeHint['last_fail'] = 'string';
    }
}
