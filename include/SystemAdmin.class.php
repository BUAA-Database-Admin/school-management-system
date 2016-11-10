<?php
/**
 * Class SystemAdmin
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class SystemAdmin extends Admin
{
    public function __construct(Admin $admin)
    {
        $this->user_id = $admin->user_id;
        $this->role = $admin->role;
    }

    public function addTeacher(array $teacher) : bool
    {
        $teacher['role'] = 'Teacher';
        return $this->addUser($teacher);
    }

    public function addStudent(array $student) : bool
    {
        $student['role'] = 'Student';
        return $this->addUser($student);
    }

    private function addUser(array $user) : bool
    {
        $contact['user_id'] = $user['id'];
        $login['user_id'] = $user['id'];
        $login['salt'] = bin2hex(random_bytes(4));
        $login['password'] = md5($user['password'] . md5($login['salt']));
        unset($user['password']);
        return User::insert($user) && Contact::insert($contact) && Login::insert($login);
    }
}
