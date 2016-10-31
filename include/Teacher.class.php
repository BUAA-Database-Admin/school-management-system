<?php
/**
 * Class Teacher
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class Teacher extends User
{
    public function modifyGrade(int $user_id, int $course_id, int $grade) : bool
    {
        $cs = CourseSelection::newInstance(array(
            'user_id' => $user_id,
            'course_id' => $course_id
        ));
        $cs->grade = $grade;
        return $cs->update();
    }
}
