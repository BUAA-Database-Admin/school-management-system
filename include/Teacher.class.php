<?php
/**
 * Class Teacher
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Teacher extends User
{
    protected $courses;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->age = $user->age;
        $this->sex = $user->sex;
        $this->dept_id = $user->dept_id;
        $this->role = $user->role;
        if (isset($user->contact)) {
            $this->contact = $user->contact;
        }
    }

    public function joinCourses()
    {
        foreach (Course::newInstances(array('user_id' => $this->id)) as $course) {
            $this->courses[$course->id] = $course;
        }
    }

    public function modifyGrades(array $arrs) : bool
    {
        if (empty($this->courses)) {
            $this->joinCourses();
        }
        $result = true;
        foreach ($arrs as $arr) {
            if (!in_array($arr['course_id'], array_keys($this->courses))) {
                return false;
            }
            $cs = CourseSelection::newInstance(array(
                'user_id' => $arr['user_id'],
                'course_id' => $arr['course_id']
            ));
            if (empty($cs)) {
                return false;
            }
            $cs->grade = $arr['grade'];
            $result = $result && $cs->update();
            if (!$result) {
                break;
            }
        }
        return $result;
    }
}
