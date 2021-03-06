<?php
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'database_admin_lab');
$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($db->connect_error) {
    header("HTTP/1.1 500 Internal Server Error");
    die("MySQL connect error ({$db->connect_errno}).<br>" . mb_convert_encoding($db->connect_error, 'UTF-8', 'GBK'));
    # goto database error page
}
spl_autoload_register(function ($class) {
    $file = __DIR__ . "/{$class}.class.php";
    if (file_exists($file)) {
        require_once $file;
        if (is_callable("{$class}::init")) {
            $class::{'init'}();
        }
    }
});
spl_autoload_register(function ($trait) {
    $file = __DIR__ . "/{$trait}.trait.php";
    if (file_exists($file)) {
        require_once $file;
    }
});
