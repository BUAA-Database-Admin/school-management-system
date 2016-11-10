<?php
/**
 * Class Student
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Student extends User
{
    protected $cs_list;

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

    public function joinCourseSelections()
    {
        $cs_list = CourseSelection::newInstances(array('user_id' => $this->id));
        foreach ($cs_list as $cs) {
            $this->cs_list[$cs->course_id] = $cs;
        }
    }

    public function selectCourses(array $courses) : bool
    {
        $result = true;
        foreach ($courses as $course) {
            $result = $result && CourseSelection::insert(array(
                'user_id' => $this->id,
                'course_id' => $course
            ));
            if (!$result) {
                break;
            }
        }
        return $result;
    }

    public function checkGrade(int $course_id)
    {
        if (empty($this->cs_list)) {
            $this->joinCourseSelections();
        }
        $cs = $this->cs_list[$course_id];
        if (empty($cs)) {
            return null;
        }
        return $cs->grade;
    }
}
