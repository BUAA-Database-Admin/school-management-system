<?php

require_once 'include/config.php';
$user = \User::newInstance('id', '14211065');
var_dump($user);
var_dump($tmp = serialize($user));
var_dump(unserialize($tmp));
var_dump(md5(md5('yu820780') . md5('978515a4')));