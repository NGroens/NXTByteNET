<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 15:08
 */

if(isset($_POST['sendRestart'])){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/bot/disconnect");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($result);

    sleep(4);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/connect/template/" . $botInfos['template_name']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($result);

    if (isset($res->Id)) {

        $bot_id = $res->Id;

        $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_id` = :bot_id WHERE `template_name` = :template_name");
        $updateBot->execute(array(":bot_id" => $bot_id, ":template_name" => $botInfos['template_name']));

        echo sendSuccess('Dein Bot wurde neugestartet.');
        header('refresh:3;url='.$url.'musikbot/'.$server_id);

    }

}