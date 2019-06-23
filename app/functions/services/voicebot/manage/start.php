<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 15:07
 */

if(isset($_POST['sendStart'])){

    if(!(is_null($botInfos['bot_id']))){
        echo sendError('Fehler', 'Dein Bot ist läuft bereits.');
    } else {

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

            $getBotIDCount = $odb->prepare("SELECT * FROM `radiobots` WHERE `bot_id` = :bot_id");
            $getBotIDCount->execute(array(":bot_id" => $bot_id));
            if ($getBotIDCount->rowCount() == 0) {

                $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_id` = :bot_id WHERE `template_name` = :template_name");
                $updateBot->execute(array(":bot_id" => $bot_id, ":template_name" => $botInfos['template_name']));

                sleep(2);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $bot_id . "/(/bot/name/" . rawurlencode($botInfos['bot_name']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                curl_close($ch);

                echo sendSuccess('Bot wurde erfolgreich gestartet.');

                sleep(2);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $bot_id . "/(/settings/set/connect.name/" . rawurlencode($botInfos['bot_name']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                curl_close($ch);

                header('refresh:3;url='.$url.'musikbot/'.$server_id);

            } else {

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $bot_id . "/(/bot/disconnect");
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

                //$res = json_decode($result);

                $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_id` = NULL WHERE `bot_id` = :bot_id");
                $updateBot->execute(array(":bot_id" => $bot_id));

                echo sendError( 'Es ist ein unbekannter Fehler aufgetreten.');
            }

        }

    }


}