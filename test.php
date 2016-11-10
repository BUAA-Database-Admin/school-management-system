<?php
require_once 'include/config.php';
$user = User::newInstance(array('id' => '14211065'));
$user->joinContact();
var_dump($user);
var_dump($tmp = serialize($user));
var_dump(unserialize($tmp));
$salt = bin2hex(random_bytes(4));
var_dump($salt);
var_dump(md5(md5('root') . md5($salt)));
