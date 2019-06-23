<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 14:34
 */

$server_id = $_GET['id'];

$SQLGetServerInfos = $odb -> prepare("SELECT * FROM `radiobots` WHERE `id` = :id");
$SQLGetServerInfos -> execute(array(":id" => $server_id));
$botInfos = $SQLGetServerInfos -> fetch(PDO::FETCH_ASSOC);

// get hostsystem infos
$getHostsystemInfos = $odb->prepare("SELECT * FROM `radiobot_hosts` WHERE `id` = :id");
$getHostsystemInfos -> execute(array(":id" => $botInfos['location']));
$hostsystemInfos = $getHostsystemInfos -> fetch(PDO::FETCH_ASSOC);

if(!($_SESSION['id'] == $botInfos['user_id'])){
    header('Location: '.$url.'radiobots');
}

if($botInfos['state'] == 'NEED_INSTALL'){
    $status_name = 'Warte auf Installation';
    $suspended = FALSE;
    $isInstalled = FALSE;
} elseif($botInfos['state'] == 'ACTIVE'){
    $status_name = 'Aktiv';
    $suspended = FALSE;
    $isInstalled = TRUE;
} elseif($botInfos['state'] == ''){
    $status_name = '---';
    $suspended = FALSE;
    $isInstalled = TRUE;
} elseif($botInfos['state'] == 'SUSPENDED'){
    $status_name = 'Gesperrt';
    $suspended = TRUE;
    $isInstalled = TRUE;
}

include_once 'connect.php';
include_once 'install.php';
include_once 'restart.php';
include_once 'settings.php';
include_once 'start.php';
include_once 'stop.php';
include_once 'play.php';
include_once 'volume.php';

if(is_null($botInfos['bot_id'])){
   $server_status = 'OFFLINE';
   if($botInfos['state'] == 'NEED_INSTALL'){
       $server_status = 'NEED_INSTALL';
   }
} else {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/bot/use/".$botInfos['bot_id']."/(/info");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close ($ch);

    $res_ult = json_decode($result);
    $res_ult = json_encode($res_ult->Value, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);

    $song_name = $res_ult;
    $song_name = str_replace('[B]> ','',$song_name);
    $song_name = str_replace('\n', '', $song_name);
    $song_name = str_replace('"', '', $song_name);
    $song_name = str_replace("\/", '/', $song_name);

    if($song_name == 'There is nothing on right now...'){
        $song_name = 'Aktuell wird nichts gespielt...';
    }

    $server_status = 'ONLINE';

}