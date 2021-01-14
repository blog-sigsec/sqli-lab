<?php

define('DB_SERV', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DB_NAME', 'sqli_patched');

$db = mysqli_connect(DB_SERV, DB_USER, DB_PASS, DB_NAME);
if (!$db) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
