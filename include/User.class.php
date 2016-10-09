<?php

/**
 * Class User
 *
 * @author EternalPhane
 */
require_once __DIR__ . '/config.php';
class User extends \BaseClass
{
    protected static $typeHint;
    protected $id;
    protected $name;
    protected $age;
    protected $sex;
    protected $dept_id;
    protected $contact;
    public function modifyPersonalInfo(array $arr)
    {
        foreach ($arr as $key => $value) {
            if (property_exists('User', $key)) {
                $this->{$key} = $value;
            } else {
                $this->contact->{$key} = $value;
            }
        }
        $this->update();
    }
    public function viewCourceInfo(string $cource)
    {
        # code...
    }
    protected static function initTypeHint()
    {
        static::$typeHint['id'] = 'int nn';
        static::$typeHint['name'] = 'string nn';
        static::$typeHint['age'] = 'int nn';
        static::$typeHint['sex'] = 'string nn';
        static::$typeHint['dept_id'] = 'int nn';
    }
    protected function __construct(array $arr)
    {
        parent::__construct($arr);
        $this->contact = \Contact::newInstance('user_id', $this->id);
    }
}