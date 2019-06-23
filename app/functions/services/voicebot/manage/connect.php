<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 14:36
 */

if(isset($_POST['quickConnect'])){
    if(isset($_POST['teamspeak_id']) && !empty($_POST['teamspeak_id'])){

        $SQLGetTSInfos = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `id` = :id");
        $SQLGetTSInfos -> execute(array(":id" => $_POST['teamspeak_id']));
        $tsInfos = $SQLGetTSInfos -> fetch(PDO::FETCH_ASSOC);

        if($tsInfos['user_id'] == $_SESSION['id']){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/settings/bot/set/".$botInfos['template_name']."/connect.address/".$tsInfos['teamspeak_ip'].':'.$tsInfos['teamspeak_port']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close ($ch);


            $res = json_decode($result);

            if(empty($res->ErrorCode)){

                $updateBot = $odb->prepare("UPDATE `radiobots` SET `server_addr` = :server_addr WHERE `template_name` = :template_name");
                $updateBot->execute(array(":server_addr" => $_POST['server_addr'], ":template_name" => $_POST['template_name']));

                echo sendSuccess('Der Musikbot wurde mit deinem Teamspeak verbunden!');
//              header('refresh:3;url='.$url.'radiobot/'.$server_id);

            } else {
                echo sendError('Es ist ein unbekannter Fehler aufgetreten.');
            }


        } else {
            echo sendError('Darauf hast du keinen Zugriff!');
        }

    } else {
        echo sendError('Es wurde keine Teamspeak-IP gefunden.');
    }
}