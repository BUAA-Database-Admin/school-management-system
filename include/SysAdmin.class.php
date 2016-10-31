<?php
/**
 * Class SysAdmin
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class SysAdmin extends Admin
{
    public function addTeacher(array $teacher) : bool
    {
        $teacher['role'] = 'Teacher';
        return addUser($teacher);
    }

    public function addStudent(array $student) : bool
    {
        $student['role'] = 'Student';
        return addUser($student);
    }

    private function addUser(array $user) : bool
    {
        $login['user_id'] = $user['id'];
        $login['salt'] = bin2hex(mcrypt_create_iv(4));
        $login['password'] = md5($user['password'] . $login['salt']);
        unset($user['password']);
        return User::insert($user) && Login::insert($login);
    }
}
