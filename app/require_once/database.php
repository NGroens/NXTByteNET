<?php
date_default_timezone_set("Europe/Berlin");

define('DB_HOST', 'localhost');
define('DB_NAME', 'nxtbyte_v2');
define('DB_USERNAME', 'nxtby_v2');
define('DB_PASSWORD', 'pw');

try {
    $odb = new PDO('mysql:host=' . DB_HOST . ';charset=utf8;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
    echo 'Maintenance work. We will be back for you shortly!';
}