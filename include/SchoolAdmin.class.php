<?php
/**
 * Class SchoolAdmin
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class SchoolAdmin extends Admin
{
    public function addCourse(array $course) : bool
    {
        return Course::insert($course);
    }

    public function addDepartment(array $dept) : bool
    {
        return Department::insert($dept);
    }
}
