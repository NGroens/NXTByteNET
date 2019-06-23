<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 11.11.2018
 * Time: 20:23
 */

$server_id = $_GET['id'];

$SQLGetServerInfos = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `id` = :id");
$SQLGetServerInfos -> execute(array(":id" => $server_id));
$serverInfos = $SQLGetServerInfos -> fetch(PDO::FETCH_ASSOC);

if(!($serverInfos['deleted_at'] == NULL)){
    header('Location: '.$url.'teamspeak/order');
}

include 'ts3_functions.php';

if($serverStatus == 'ONLINE'){
    $status_msg = 'Online';
} else {
    $status_msg = 'Offline';
}

if(is_null($serverInfos['suspended'])){
    $suspended = FALSE;
} else {
    $suspended = TRUE;
}

if(!($_SESSION['id'] == $serverInfos['user_id'])){
    header('Location: '.$url.'service/list');
}

if($serverStatus == 'ONLINE'){
    $connection_info = getInfos($ts3_query);
    $version = getVersion($ts3_query);
}

if(isset($_POST['sendStop'])){
    $ts3->stopServer($odb, $serverInfos['node_id'],$serverInfos['teamspeak_port'],$serverInfos['sid']);
    $serverStatus = 'OFFLINE';
    echo sendSuccess('Dein Teamspeak wurde gestoppt');
    header('refresh:3;url='.$url.'teamspeak/'.$server_id);
}

if(isset($_POST['sendStart'])){
    $ts3->startServer($odb, $serverInfos['node_id'],$serverInfos['teamspeak_port'],$serverInfos['sid']);
    //$serverStatus = 'ONLINE';
    echo sendSuccess('Dein Teamspeak wurde gestartet');
    header('refresh:3;url='.$url.'teamspeak/'.$server_id);
}

if(isset($_POST['createToken'])){
    if(isset($_POST['group']) && !empty($_POST['group'])){
        createToken($ts3_query,$_POST['group'],$_POST['description'], $serverStatus);
        echo sendSuccess('Der Token wurde erfolgreich angelegt');
    }
}

if(isset($_POST['deleteToken']) && !empty($_POST['deleteToken'])){
    deleteToken($ts3_query, $_POST['deleteToken'], $serverStatus);
    echo sendSuccess('Der Token wurde gelöscht');
}