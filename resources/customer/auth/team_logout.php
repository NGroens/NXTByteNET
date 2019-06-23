<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 22.11.2018
 * Time: 21:44
 */

if(isset($_COOKIE['support_login'])){
    $username = $_COOKIE['support_login'];

    $getUserInfos = $odb -> prepare("SELECT * FROM `users` WHERE `username` = :username");
    $getUserInfos -> execute(array(":username" => $username));
    $userInfos = $getUserInfos -> fetch(PDO::FETCH_ASSOC);

    $_SESSION['username'] = $userInfos['username'];
    $_SESSION['id'] = $userInfos['id'];
    $_SESSION['email'] = $userInfos['email'];

    unset($_COOKIE['support_login']);
    setcookie('support_login', null, -1, '/');

    header('Location: ' . $url.'team/users');
} else {
    header('Location: ' . $url.'dashboard');
}