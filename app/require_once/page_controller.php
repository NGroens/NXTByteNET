<?php
/**
 * Created by PhpStorm.
 * User: sylbe
 * Date: 11.06.2018
 * Time: 20:14
 */

if($user->LoggedIn() && $userInfo['status'] == 'BANNED' || $user->LoggedIn() && $userInfo['status'] == 'PENDING' || $user->LoggedIn() && $userInfo['status'] == 'DISABLED') {
    header('Location: '.$url.'logout');
}

if($user->LoggedIn()){
    if(strpos($currPage, 'auth_') !== false){
        header('Location: '.$url.'dashboard');
    }
}

if(strpos($currPage, 'back_') !== false && !$user->LoggedIn()){
    header('Location: '.$url.'login');
}

if(strpos($currPage, 'front_') !== false){
    include_once 'resources/additional/front/head.php';
    include_once 'resources/additional/front/header.php';
} else {
    include_once 'resources/additional/head.php';
    include_once 'app/notifications/sendAlert.php';
    include_once 'app/notifications/sendPush.php';
}

if(strpos($currPage, 'back_') !== false){
    include_once 'resources/additional/navbar.php';
    include_once 'resources/additional/sidebar.php';
}