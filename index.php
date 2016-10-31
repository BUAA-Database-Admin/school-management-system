<?php
require_once 'include/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['user_id'])) {
        die('-1');
    }
    $login = Login::newInstance('user_id', $db->real_escape_string($_POST['user_id']));
    if (empty($login)) {
        die('1');
    }
    if ($login->fails > 0 && (new DateTime($login->last_fail))->diff(new DateTime())->days >= 1) {
        $login->fails = 0;
        $login->last_fail = null;
        $login->update('fails', 'last_fail');
    }
    if ($login->fails == 10) {
        die('3');
    }
    if (empty($_POST['password'])) {
        die("{$login->salt}");
    }
    if (hash_hmac('md5', $login->password, $_COOKIE['key']) != $_POST['password']) {
        $login->fails++;
        $login->update('fails');
        die('2');
    }
    $_SESSION['user_id'] = $login->user_id;
    $login->fails = 0;
    $login->last_fail = null;
    $login->update('fails', 'last_fail');
    die('0');
} elseif (isset($_SESSION['user_id'])) {
    include 'include/helloworld.html';
} else {
    setcookie('key', bin2hex(random_bytes(8)));
    include 'include/login.html';
}
