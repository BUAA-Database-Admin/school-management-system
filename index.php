<?php

require_once 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stu_number = $db->real_escape_string($_POST['stu_number']);
    $password = $_POST['password'];
    $sql = <<<SQL
SELECT * FROM `login`, `student`
WHERE `login`.`sid` = {$stu_number}
SQL;
    $result = $db->query($sql);
    if ($result == false || $result->num_rows == 0) {
        # show student number error
    }
    $stu = $result->fetch_object();
    if (!is_null($stu->last_failure) && (new \DateTime($stu->last_failure))->diff(new \DateTime())->days >= 1) {
        $sql = <<<SQL
UPDATE `login`
SET `failure_times` = 0, `last_failure` = NULL
WHERE `sid` = {$stu_number}
SQL;
        $db->query($sql);
    }
    if ($password != $stu->password) {
        if ($stu->failure_times < 10) {
            $sql = <<<SQL
UPDATE `login`
SET `failure_times` = `failure_times` + 1
WHERE `sid` = {$stu_number}
SQL;
            $db->query($sql);
        } else {
            # show try-too-many-time error
        }
        # show password error
    }
    $_SESSION['stu_name'] = $stu->sname;
    # goto index page
} elseif (isset($_SESSION['stu_name'])) {
    # goto index page
} else {
    include 'include/login.html';
}