<?php
/**
 * Class Admin
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Admin extends BaseClass
{
    protected static $typeHint;
    protected $user_id;

    use Updatable;

    protected static function initTypeHint()
    {
        static::$typeHint['user_id'] = 'int nn';
    }
}
