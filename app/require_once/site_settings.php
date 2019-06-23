<?php

$SQLGetSettings = $odb -> prepare("SELECT * FROM `settings`");
$SQLGetSettings -> execute();
$serverSettings = $SQLGetSettings -> fetch(PDO::FETCH_ASSOC);

if($serverSettings['maintenance'] == 1){
    error_reporting(E_ALL);
}

if($user->LoggedIn()){
    $userChecker = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
    $userChecker -> execute(array(":id" => $_SESSION['id']));
    $userInfo = $userChecker -> fetch(PDO::FETCH_ASSOC);
}

function protect($string) {
    $protection = htmlspecialchars(trim($string), ENT_QUOTES);
    return $protection;
}

function nl2br2($string) {
    $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
    return $string;
}