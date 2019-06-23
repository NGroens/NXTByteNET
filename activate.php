<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'app/require_once/database.php';
include 'app/require_once/config.php';

ob_start();
session_start();

$key = $_GET['key'];

if(isset($key) && !empty($key)){

    $SQLCheckKey = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `verify_code` = :key");
    $SQLCheckKey -> execute(array(':key' => $key));
    $countKey = $SQLCheckKey -> fetchColumn(0);
    if ($countKey == 1){
        $updateUser = $odb->prepare("UPDATE `users` SET `status`=:status,`verify_code`=:newKey WHERE `verify_code` = :key");
        $updateUser->execute(array(":key" => $key, ":status" => 'ACTIVE', ":newKey" => NULL));
        setcookie("email_success", 'unused', time() + 5);
        header('Location: '.$url.'login');
    } else {
        //Move to main page
        //Unbekannter fehler
        setcookie("email_error1", 'unused', time() + 5);
        header('Location: '.$url.'login');
    }

} else {
    //Move to main page
    //Key not found
    setcookie("email_error2", 'unused', time() + 5);
    header('Location: '.$url.'login');
}

?>