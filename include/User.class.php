<?php
/**
 * Class User
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class User extends BaseClass
{
    protected static $typeHint;
    protected $id;
    protected $name;
    protected $age;
    protected $sex;
    protected $dept_id;

    use Updatable;
    use Insertable;

    protected static function initTypeHint()
    {
        static::$typeHint['id'] = 'int nn';
        static::$typeHint['name'] = 'string nn';
        static::$typeHint['age'] = 'int nn';
        static::$typeHint['sex'] = 'string nn';
        static::$typeHint['dept_id'] = 'int nn';
    }

    public function joinContact()
    {
        $this->contact = Contact::newInstance('user_id', $this->id);
    }

    public function modifyPersonalInfo(array $arr) : bool
    {
        foreach ($arr as $key => $value) {
            if (property_exists('User', $key)) {
                $this->{$key} = $value;
            } else {
                if (!isset($this->contact)) {
                    joinContact();
                }
                $this->contact->{$key} = $value;
            }
        }
        return $this->update() && $this->contact->update();
    }

    public function viewCourceInfo(int $course_id) : Course
    {
        return Course::newInstance('id', $course_id);
    }
}
