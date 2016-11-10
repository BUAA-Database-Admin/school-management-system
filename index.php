<?php
require_once 'include/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (is_null($_SESSION['user_id'])) {
        $login = Login::newInstance(array('user_id' => $db->real_escape_string($_POST['user_id'])));
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
        if (isset($_GET['admin'])) {
            $admin = Admin::newInstance(array('user_id' => $login->user_id));
            if (empty($admin)) {
                die('-1');
            }
            $_SESSION['admin'] = '';
        }
        $_SESSION['user_id'] = $login->user_id;
        $login->fails = 0;
        $login->last_fail = null;
        $login->update('fails', 'last_fail');
        die('0');
    } else {
        if (empty($_POST['method'])) {
            die('-1');
        }
        $method = explode('-', $_POST['method']);
        for ($i = 1; $i < sizeof($method); $i++) {
            $method[$i] = ucfirst($method[$i]);
        }
        $method = implode('', $method);
        if (isset($_SESSION['admin'])) {
            $user = Admin::newInstance(array('user_id' => $_SESSION['user_id']));
        } else {
            $user = User::newInstance(array('id' => $_SESSION['user_id']));
        }
        if (empty($user)) {
            die('1');
        }
        $class = $user->role;
        if (isset($_SESSION['admin'])) {
            $class .= 'Admin';
        }
        $user = new $class($user);
        if (isset($_POST[$_POST['method']])) {
            $args = $_POST[$_POST['method']];
        } else {
            $args = $_POST;
            unset($args['method']);
        }
        $result = $user->$method($args);
        if (is_bool($result)) {
            die($result ? '0' : '1');
        } else {
            die(json_encode($result));
        }
    }
} elseif (isset($_SESSION['user_id'])) {
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: /index.php');
        die();
    }
    if (isset($_SESSION['admin'])) {
        $admin = Admin::newInstance(array('user_id' => $_SESSION['user_id']));
    } else {
        $user = User::newInstance(array('id' => $_SESSION['user_id']));
    }
    include 'include/home.php';
} else {
    setcookie('key', bin2hex(random_bytes(8)));
    if (isset($_GET['admin'])) {
        include 'include/login-admin.html';
    } else {
        include 'include/login.html';
    }
}
