<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 16:51
 */

if(isset($_POST['changeStreamSettings'])){

    if(isset($_POST['volume']) && !empty($_POST['volume'])){

        if($_POST['volume'] >= 1 && $_POST['volume'] <= 100){
            if($_POST['volume'] != $botInfos['volume']){

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/bot/use/".$botInfos['bot_id']."/(/volume/".$_POST['volume']);
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

                    $isError = true;
                    echo sendError('Bitte versuche es später erneut');

                } else {

    //                $updateBot = $odb->prepare("UPDATE `radiobots` SET `volume` = :volume WHERE `template_name` = :template_name");
    //                $updateBot->execute(array(":volume" => $_POST['volume'], ":template_name" => $botInfos['template_name']));

                    echo sendSuccess('Erfolgreich', 'Die Lautstärke wurde geändert');
                    header('refresh:3;url=' . $url . 'musikbot/' . $server_id);
                }
            }

        } else {
            $isError = true;
            echo sendError('Bitte gebe einen Wert zwichen 1 und 100 ein.');
        }

    }

}