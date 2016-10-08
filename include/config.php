<?php

define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'database_admin_lab');
$db = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($db->connect_error) {
    header("HTTP/1.1 500 Internal Server Error");
    die("MySQL connect error ({$db->connect_errno}).<br>" . mb_convert_encoding($db->connect_error, 'UTF-8', 'GBK'));
    # goto database error page
}