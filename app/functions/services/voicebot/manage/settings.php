<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 15:00
 */

$isError = false;

if(isset($_POST['saveCFG'])) {

    /*
     * Change server addr
     */
    if($botInfos['server_addr'] == $_POST['teamspeak_ip']){ } else {

        if (empty($_POST['teamspeak_ip'])) {
            $teamspeak_ip = '127.0.0.1:9987';
        } else {
            $teamspeak_ip = $_POST['teamspeak_ip'];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/settings/bot/set/" . $botInfos['template_name'] . "/connect.address/" . $teamspeak_ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($result);

        if ($res->ErrorCode) {

            echo sendError($res->ErrorMessage,'Fehler (Server-Addr)');

        } else {

            $updateBot = $odb->prepare("UPDATE `radiobots` SET `server_addr` = :server_addr WHERE `template_name` = :template_name");
            $updateBot->execute(array(":server_addr" => $teamspeak_ip, ":template_name" => $botInfos['template_name']));

        }

    }

    /*
     * Change botname
     */
    if(empty($_POST['bot_name'])){
        if(!isset($_POST['quick_connect'])) {
            echo sendError('Bitte gebe einen gültigen Namen an.');
        }
    } else {

        if($_POST['bot_name'] == $botInfos['bot_name']){ } else {

            if(isset($botInfos['bot_id'])) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/bot/name/" . rawurlencode($_POST['bot_name']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                curl_close($ch);

                $resu = json_decode($result);

                if (empty($resu->ErrorCode)) {

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/settings/set/connect.name/" . rawurlencode($_POST['bot_name']));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    $headers = array();
                    $headers[] = 'Accept: application/json';
                    $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $resu = json_decode($result);

                    if (empty($resu->ErrorCode)) {
                        $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_name` = :bot_name WHERE `template_name` = :template_name");
                        $updateBot->execute(array(":bot_name" => $_POST['bot_name'], ":template_name" => $botInfos['template_name']));
                    } else {
                        echo sendError($resu->ErrorMessage,'Fehler (Botname)');
                    }

                    //echo sendSuccess('Erfolgreich', 'Der neue Botname wurde gespeichert und wird nach einem Restart aktiv.');
                    //header('refresh:3;url='.$url.'radiobot/'.$server_id);

                } else {
                    echo sendError($resu->ErrorMessage, 'Fehler (Botname)');
                }

            } else {
                $isError = true;
                echo sendError('Bitte starte zuerst den Bot');
            }

        }

    }

    /*
     * Change server password
     */
    if(isset($_POST['ts3_server_password']) && !empty($_POST['ts3_server_password']) && $_POST['ts3_server_password'] != $botInfos['server_password']){

//        echo sendError('Fehler (Server-PW)', $_POST['ts3_server_password']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/settings/bot/set/".$botInfos['template_name']."/connect.server_password.pw/".rawurlencode($_POST['ts3_server_password'].""));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close ($ch);

        $res = json_decode($result);

//       echo sendError('Fehler (Server-PW)', $res->ErrorName);

        if($res->ErrorCode){

            echo sendError($res->ErrorName, 'Fehler (Server-PW)');

        } else {

//            echo sendSuccess('Erfolgreich', 'Server Passwort gesetzt');

            $updateBot = $odb->prepare("UPDATE `radiobots` SET `server_password` = :server_password WHERE `template_name` = :template_name");
            $updateBot->execute(array(":server_password" => $_POST['ts3_server_password'], ":template_name" => $botInfos['template_name']));

        }

    } else {
        $updateBot = $odb->prepare("UPDATE `radiobots` SET `server_password` = :server_password WHERE `template_name` = :template_name");
        $updateBot->execute(array(":server_password" => NULL, ":template_name" => $botInfos['template_name']));
    }

    /*
     * Change channel id
     */

    if(isset($_POST['channel_id']) && $_POST['channel_id'] != $botInfos['default_channel']){
//    if($botInfos['default_channel'] == $_POST['channel_id']){ } else {

//        echo sendError('Fehler (Channel-ID)', 'DEBUG 1');

//        if(isset($_POST['channel_id']) && !empty($_POST['channel_id'])) {

            if(empty($_POST['channel_id'])){
                $updateBot = $odb->prepare("UPDATE `radiobots` SET `default_channel` = NULL WHERE `template_name` = :template_name");
                $updateBot->execute(array(":template_name" => $botInfos['template_name']));
            } else {

                if (isset($botInfos['bot_id'])) {
                    //TODO
                    // instant change channel
                }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/settings/bot/set/" . $botInfos['template_name'] . "/connect.channel/%2F" . $_POST['channel_id'] . "");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                curl_close($ch);

                $res = json_decode($result);

                if ($res->ErrorCode) {

                    echo sendError($res->ErrorMessage, 'Fehler (Channel-ID)');

                } else {

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/bot/move/" . $_POST['channel_id'] . "/" . rawurlencode($botInfos['channel_password']));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    $headers = array();
                    $headers[] = 'Accept: application/json';
                    $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $updateBot = $odb->prepare("UPDATE `radiobots` SET `default_channel` = :channel_id WHERE `template_name` = :template_name");
                    $updateBot->execute(array(":channel_id" => $_POST['channel_id'], ":template_name" => $botInfos['template_name']));

                }

            }
//        }

    } else {

    }

    /*
     * Change channel password
     */
    if(isset($_POST['channel_password']) && !empty($_POST['channel_password']) && $botInfos['default_channel'] != $_POST['channel_password']){

        if(empty($_POST['channel_password'])){
            $channel_password = NULL;
        } else {
            $channel_password = $_POST['channel_password'];
        }

        if(empty($botInfos['default_channel'])){
            if(isset($_POST['channel_id'])){

                $channel_id = $_POST['channel_id'];

            } else {
                echo sendError( 'Bitte gebe eine Channel-ID ein.');
            }
        } else {
            $channel_id = $botInfos['default_channel'];
        }

        if(empty($botInfos['bot_id'])){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/bot/connect/template/".$botInfos['template_name']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close ($ch);

        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/bot/use/".$botInfos['bot_id']."/(/bot/move/".$channel_id."/".rawurlencode($_POST['channel_password']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close ($ch);

        $res = json_decode($result);

        if($res->ErrorCode){

            echo sendError($res->ErrorMessage, 'Fehler (Channel-PW)');

        }

    }

    if($isError == false){
        echo sendSuccess('Die Einstellungen wurden gespeichert.');
    }
    header('refresh:3;url='.$url.'musikbot/'.$server_id);

}