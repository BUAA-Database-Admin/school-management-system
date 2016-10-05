<?php

define('DB_SERVER', 'localhost:3036');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'database_admin_lab');
$db = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($db->connect_error) {
    # goto database error page
    //die('MySQL connect error (' . $db->connect_errno . ').' . $db->connect_error);
}