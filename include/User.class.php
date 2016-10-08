<?php

/**
 * Class User
 *
 * @author EternalPhane
 */
require_once 'BaseClass.class.php';
require_once 'Contact.class.php';
class User extends \BaseClass
{
    protected $id;
    protected $name;
    protected $age;
    protected $sex;
    protected $dept_id;
    protected $contact;
    public static function init()
    {
        self::$typeHint['id'] = 'int';
        self::$typeHint['name'] = 'string';
        self::$typeHint['age'] = 'int';
        self::$typeHint['sex'] = 'string';
        self::$typeHint['dept_id'] = 'int';
    }
    public function __construct(array $arr_both)
    {
        parent::__construct($arr_both);
        $this->contact = new \Contact(array('user_id' => $this->id));
        foreach (get_object_vars($this) as $key => $value) {
            if (empty($value)) {
                throw new \Exception("{$key} can't be null!");
            }
        }
    }
    public function modifyPersonalInfo(array $arr_both)
    {
        foreach ($arr_both as $key => $value) {
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
}