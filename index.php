<?php

require_once 'include/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stu_number = $db->real_escape_string($_POST['stu_number']);
    $password = $_POST['password'];
    $sql = <<<SQL
SELECT `failure_times`, `last_failure` FROM `login`
WHERE `sid` = {$stu_number}
SQL;
    $result = $db->query($sql);
    if ($result == false || $result->num_rows == 0) {
        die("1");
    }
    $stu = $result->fetch_object();
    if ($stu->failure_times >= 10) {
        die("3");
    }
    if (!is_null($stu->last_failure) && (new \DateTime($stu->last_failure))->diff(new \DateTime())->days >= 1) {
        $stu->failure_times = 0;
        $sql = <<<SQL
UPDATE `login`
SET `failure_times` = 0, `last_failure` = NULL
WHERE `sid` = {$stu_number}
SQL;
        $db->query($sql);
    }
    $sql = <<<SQL
SELECT `sname` FROM `login`, `student`
WHERE `login`.`sid` = {$stu_number} AND `password` = '{$password}'
SQL;
    $result = $db->query($sql);
    if ($result == false || $result->num_rows == 0) {
        $sql = <<<SQL
UPDATE `login`
SET `failure_times` = `failure_times` + 1
WHERE `sid` = {$stu_number}
SQL;
        $db->query($sql);
        die("2");
    }
    $stu = $result->fetch_object();
    $_SESSION['stu_name'] = $stu->sname;
    die("0");
} elseif (isset($_SESSION['stu_name'])) {
    include 'include/helloworld.html';
} else {
    include 'include/login.html';
}