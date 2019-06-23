<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 16:46
 */

if(isset($_POST['changeStreamSettings'])) {

    if (isset($_POST['song_url']) && !empty($_POST['song_url'])) {

        if (is_numeric($_POST['song_url']) || is_int($_POST['song_url'])) {
            $getStreamInfos = $odb->prepare("SELECT * FROM `radiobot_webradio_list` WHERE `id` = :id");
            $getStreamInfos->execute(array(":id" => $_POST['song_url']));
            $streamInfos = $getStreamInfos->fetch(PDO::FETCH_ASSOC);

            $streamurl = $streamInfos['url'];
        } else {
            $streamurl = $_POST['song_url'];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/play/" . rawurlencode($streamurl));
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

        echo sendSuccess('Der Stream wird nun geladen');
        header('refresh:3;url='.$url.'musikbot/'.$server_id);

    }

}