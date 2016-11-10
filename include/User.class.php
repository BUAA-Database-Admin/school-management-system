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
    protected $role;
    protected $contact;
    protected $login;

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
        $this->contact = Contact::newInstance(array('user_id' => $this->id));
    }

    public function joinLogin()
    {
        $this->login = Login::newInstance(array('user_id' => $this->id));
    }

    public function modifyPersonalInfo(array $arr) : bool
    {
        if (empty($this->contact)) {
            $this->joinContact();
        }
        if (empty($this->login)) {
            $this->joinLogin();
        }
        foreach ($arr as $key => $value) {
            if (property_exists('User', $key)) {
                $this->{$key} = $value;
            } elseif (property_exists('Contact', $key)) {
                $this->contact->{$key} = $value;
            } elseif ($key == 'password') {
                $this->login->password = md5($value . md5($this->login->salt));
            }
        }
        return $this->update() && $this->contact->update() && $this->login->update();
    }

    public function viewCourseInfo(int $course_id) : array
    {
        $course = Course::newInstance(array('id' => $course_id));
        if (empty($course)) {
            return array();
        }
        $result['id'] = $course->id;
        $result['name'] = $course->name;
        $teacher = User::newInstance(array('id' => $course->user_id));
        $result['teacher'] = $teacher->name;
        $result['credit'] = $course->credit;
        return $result;
    }
}
