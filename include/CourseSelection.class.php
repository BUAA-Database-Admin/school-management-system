<?php
/**
 * Class CourseSelection
 *
 * @author EternalPhane
 */

require_once __DIR__ . '/config.php';

class CourseSelection extends BaseClass
{
    protected static $typeHint;
    protected $user_id;
    protected $course_id;
    protected $grade;

    use Updatable;
    use Insertable;

    protected static function initTypeHint()
    {
        static::$typeHint['user_id'] = 'int nn';
        static::$typeHint['course_id'] = 'int nn';
        static::$typeHint['grade'] = 'int';
    }
}
