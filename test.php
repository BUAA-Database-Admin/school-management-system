<?php

spl_autoload_register(function ($class) {
    $file = "include/{$class}.class.php";
    if (file_exists($file)) {
        require_once $file;
        if (is_callable("{$class}::init")) {
            $class::{'init'}();
        }
    }
});
$user = new \User(array('id' => '14211065', 'name' => 'yjf', 'age' => '20', 'sex' => 'Male', 'dept_id' => '21'));
var_dump($user);