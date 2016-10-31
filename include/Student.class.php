<?php
/**
 * Class Student
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Student extends User
{
    public function selectCourse(int $course_id) : bool
    {
        return CourseSelection::insert(array(
            'user_id' => $this->id,
            'course_id' => $course_id
        ));
    }

    public function checkGrade(int $course_id) : int
    {
        $cs = CourseSelection::newInstance(array(
            'user_id' => $this->id,
            'course_id' => $course_id
        ));
        return $cs->grade;
    }
}
