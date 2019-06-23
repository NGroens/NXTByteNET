<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 10.11.2018
 * Time: 21:38
 */

//
//$server_id = $_GET['id'];
//
//$SQLGetServerInfos = $odb -> prepare("SELECT * FROM `radiobots` WHERE `id` = :id");
//$SQLGetServerInfos -> execute(array(":id" => $server_id));
//$serverInfos = $SQLGetServerInfos -> fetch(PDO::FETCH_ASSOC);
//
//// get hostsystem infos
//$getHostsystemInfos = $odb->prepare("SELECT * FROM `radiobot_hosts` WHERE `id` = :id");
//$getHostsystemInfos -> execute(array(":id" => $serverInfos['location']));
//$hostsystemInfos = $getHostsystemInfos -> fetch(PDO::FETCH_ASSOC);
//
//$SQLGetServerInfos = $odb -> prepare("SELECT * FROM `radiobots` WHERE `id` = :id");
//$SQLGetServerInfos -> execute(array(":id" => $server_id));
//$botInfos = $SQLGetServerInfos -> fetch(PDO::FETCH_ASSOC);
//
//$bot = new \TS3AB\Ts3AudioBot($hostsystemInfos['node_ip'], $hostsystemInfos['port']);
//$bot->basicAuth($hostsystemInfos['basicAuth']);
//
//if($serverInfos['state'] == 'NEED_INSTALL'){
//    $status_name = 'Warte auf Installation';
//    $suspended = FALSE;
//    $isInstalled = FALSE;
//} elseif($serverInfos['state'] == 'ACTIVE'){
//    $status_name = 'Aktiv';
//    $suspended = FALSE;
//    $isInstalled = TRUE;
//} elseif($serverInfos['state'] == ''){
//    $status_name = '---';
//    $suspended = FALSE;
//    $isInstalled = TRUE;
//} elseif($serverInfos['state'] == 'SUSPENDED'){
//    $status_name = 'Gesperrt';
//    $suspended = TRUE;
//    $isInstalled = TRUE;
//}
//
//if($serverInfos['status'] == 'NEED_INSTALL'){
//    $isInstalled = FALSE;
//} else {
//    $isInstalled = TRUE;
//}
//
//if(is_null($serverInfos['suspended'])){
//    $suspended = FALSE;
//} else {
//    $suspended = TRUE;
//}
//
//if(!($_SESSION['id'] == $serverInfos['user_id'])){
//    header('Location: '.$url.'radiobots');
//}
//
////if($serverInfos['location'] == 1){
////    $location_name = 'NBG';
////}
//
//if(isset($_POST['quickConnect'])){
//    if(isset($_POST['teamspeak_id']) && !empty($_POST['teamspeak_id'])){
//
//        $SQLGetTSInfos = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `id` = :id");
//        $SQLGetTSInfos -> execute(array(":id" => $_POST['teamspeak_id']));
//        $tsInfos = $SQLGetTSInfos -> fetch(PDO::FETCH_ASSOC);
//
//        if($tsInfos['user_id'] == $_SESSION['id']){
//
////            $fields = array(
////                'changeTeamspeak' => NULL,
////                'teamspeak_ip' => $tsInfos['teamspeak_ip'], //Teamspeak IP
////                'teamspeak_port' => $tsInfos['teamspeak_port'], //Teamspeak Port
////                'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////                'api_key' => $DNodeAPIKey, //Ihr API Key
////            );
////
////            $ch = curl_init();
////
////            curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////            curl_setopt($ch, CURLOPT_POST, 1);
////            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////            $output = curl_exec($ch);
////
////            curl_close ($ch);
////
////            $output = json_decode($output);
////
////            if($output->status == "success" || $output->status == '"success"'){
////
////                $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `teamspeak_ip` = :data WHERE `id` = :serverID");
////                $updateBotData->execute(array(":data" => $tsInfos['teamspeak_ip'], ":serverID" => $server_id));
////                $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `teamspeak_port` = :data WHERE `id` = :serverID");
////                $updateBotData->execute(array(":data" => $tsInfos['teamspeak_port'], ":serverID" => $server_id));
////
////                echo sendSuccess('Erfolgreich', 'Der Musikbot wurde mit deinem Teamspeak verbunden!');
////                header('refresh:3;url='.$url.'radiobot/'.$server_id);
////
////            } else {
////                echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////            }
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/settings/bot/set/".$botInfos['template_name']."/connect.address/".$tsInfos['teamspeak_ip'].':'.$tsInfos['teamspeak_port']);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//            $headers = array();
//            $headers[] = 'Accept: application/json';
//            $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//            $result = curl_exec($ch);
//            curl_close ($ch);
//
//
//            $res = json_decode($result);
//
//            if(empty($res->ErrorCode)){
//
//                $updateBot = $odb->prepare("UPDATE `radiobots` SET `server_addr` = :server_addr WHERE `template_name` = :template_name");
//                $updateBot->execute(array(":server_addr" => $_POST['server_addr'], ":template_name" => $_POST['template_name']));
//
//                echo sendSuccess('Erfolgreich', 'Der Musikbot wurde mit deinem Teamspeak verbunden!');
////                header('refresh:3;url='.$url.'radiobot/'.$server_id);
//
//            } else {
//                echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
//            }
//
//        }
//
//    }
//}
//
//if(isset($_POST['installServer'])){
////    $fields = array(
////        'installBot' => NULL,
////        'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////        'api_key' => $DNodeAPIKey, //Ihr API Key
////    );
////
////    $ch = curl_init();
////
////    curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////    curl_setopt($ch, CURLOPT_POST, 1);
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////    $output = curl_exec($ch);
////    curl_close ($ch);
////    //echo $output;
////    $output = json_decode($output);
////
////    if($output->status == "success" || $output->status == '"success"'){
////
////        $updateBotData = $odb -> prepare("UPDATE `ts3_radiobots` SET `status` = 'OFFLINE' WHERE `id` = :serverID");
////        $updateBotData->execute(array(":serverID" => $server_id));
////        echo sendSuccess('Erfolgreich', 'Dein Bot wird nun installiert!');
////        header('refresh:3;url='.$url.'radiobot/'.$server_id);
////
////    } else {
////        echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////    }
//
//    require_once('Net/SSH2.php');
//    $ssh = new Net_SSH2($hostsystemInfos['node_ip'], $hostsystemInfos['node_port']);
//    if (!$ssh->login($hostsystemInfos['node_user'], $hostsystemInfos['node_password'])) {
//
//        echo sendError('Fehler', 'Das Hostsystem ist nicht erreichbar!');
//
//    } else {
//        // copy bot template
//        $ssh->exec('cp -R /home/template/rename_me_now.toml /home/radiobot/Bots/');
//
//        // rename bot template
//        $ssh->exec('mv /home/radiobot/Bots/rename_me_now.toml /home/radiobot/Bots/bot_' . $_POST['template_name'] . '.toml');
//
//        // update database
//        $updateBot = $odb->prepare("UPDATE `radiobots` SET `state` = :state WHERE `template_name` = :template_name");
//        $updateBot->execute(array(":state" => 'ACTIVE', ":template_name" => $botInfos['template_name']));
//
//        // get new information
//        $getBotInfos = $odb->prepare("SELECT * FROM `radiobots` WHERE `template_name` = :template_name AND `user_id` = :user_id");
//        $getBotInfos -> execute(array(":template_name" => $_POST['template_name'], ":user_id" => $userInfos['id']));
//        $botInfos = $getBotInfos->fetch(PDO::FETCH_ASSOC);
//
//        echo sendSuccess('Erfolgreich', 'Dein Bot wird nun installiert!');
//        header('refresh:3;url='.$url.'radiobot/'.$server_id);
//    }
//
//}
//
//if(isset($_POST['saveCFG'])){
//
//    if(empty($_POST['teamspeak_ip'])){
//        $teamspeak_ip = '127.0.0.1:9987';
//    } else {
//        $teamspeak_ip = $_POST['teamspeak_ip'];
//    }
//
////    $fields = array(
////        'changeTeamspeak' => NULL,
////        'teamspeak_ip' => $teamspeak_ip, //Teamspeak IP
////        'teamspeak_port' => $teamspeak_port, //Teamspeak Port
////        'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////        'api_key' => $DNodeAPIKey, //Ihr API Key
////    );
////
////    $ch = curl_init();
////
////    curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////    curl_setopt($ch, CURLOPT_POST, 1);
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////    $output = curl_exec($ch);
//////echo $output;
////    curl_close ($ch);
////
////    $output = json_decode($output);
////
////    if($output->status == "success" || $output->status == '"success"'){
////
////        $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `teamspeak_ip` = :data WHERE `id` = :serverID");
////        $updateBotData->execute(array(":data" => $teamspeak_ip, ":serverID" => $server_id));
////        $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `teamspeak_port` = :data WHERE `id` = :serverID");
////        $updateBotData->execute(array(":data" => $teamspeak_port, ":serverID" => $server_id));
////
////        //echo sendSuccess('Erfolgreich', 'Die Teamspeak IP wurde gespeichert und ist nach einem Neustart aktiv!');
////        //header('refresh:3;url='.$url.'radiobot/'.$server_id);
////
////    } else {
////        echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////    }
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/settings/bot/set/".$botInfos['template_name']."/connect.address/".$teamspeak_ip);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//    $headers = array();
//    $headers[] = 'Accept: application/json';
//    $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    $result = curl_exec($ch);
//    curl_close ($ch);
//
//    $res = json_decode($result);
//
//    if(empty($res->ErrorCode)){
//
//        $updateBot = $odb->prepare("UPDATE `radiobots` SET `server_addr` = :server_addr WHERE `template_name` = :template_name");
//        $updateBot->execute(array(":server_addr" => $_POST['teamspeak_ip'], ":template_name" => $_POST['template_name']));
//
//        //echo sendSuccess('Erfolgreich', 'Die Teamspeak IP wurde gespeichert und ist nach einem Neustart aktiv!');
//        //header('refresh:3;url='.$url.'radiobot/'.$server_id);
//
//    } else {
//        echo sendError('Fehler', 'Der Server ist nicht erreichbar.');
//    }
//
//    if(empty($_POST['bot_name'])){
//        echo sendError('Fehler','Bitte gebe einen gültigen Namen an.');
//    } else {
//
//        if($_POST['bot_name'] == $botInfos['bot_name']){
//
//            //TODO
//            // nothing
//
//        } else {
//
////        $fields = array(
////            'changeBotName' => NULL,
////            'bot_name' => $_POST['bot_name'], //Botname
////            'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////            'api_key' => $DNodeAPIKey, //Ihr API Key
////        );
////
////        $ch = curl_init();
////
////        curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////        curl_setopt($ch, CURLOPT_POST, 1);
////        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////        $output = curl_exec($ch);
////
////        curl_close ($ch);
////
////        $output = json_decode($output);
////
////        if($output->status == "success" || $output->status == '"success"'){
////            $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `bot_name` = :data WHERE `id` = :serverID");
////            $updateBotData->execute(array(":data" => $_POST['bot_name'], ":serverID" => $server_id));
////            //echo sendSuccess('Erfolgreich', 'Der neue Botname wurde gespeichert und wird nach einem Restart aktiv.');
////            //header('refresh:3;url='.$url.'radiobot/'.$server_id);
////        } else {
////            echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////        }
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/bot/name/" . rawurlencode($_POST['bot_name']));
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//            $headers = array();
//            $headers[] = 'Accept: application/json';
//            $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//            $result = curl_exec($ch);
//            curl_close($ch);
//
//            $resu = json_decode($result);
//
//            if (empty($resu->ErrorCode)) {
//
//                $ch = curl_init();
//                curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/settings/set/connect.name/" . rawurlencode($_POST['bot_name']));
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//                $headers = array();
//                $headers[] = 'Accept: application/json';
//                $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
//                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//                $result = curl_exec($ch);
//                curl_close($ch);
//
//                $resu = json_decode($result);
//
//                if (empty($resu->ErrorCode)) {
//                    $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_name` = :bot_name WHERE `template_name` = :template_name");
//                    $updateBot->execute(array(":bot_name" => $_POST['bot_name'], ":template_name" => $botInfos['template_name']));
//                } else {
//                    echo sendError('Fehler', $resu->ErrorMessage);
//                }
//
//                //echo sendSuccess('Erfolgreich', 'Der neue Botname wurde gespeichert und wird nach einem Restart aktiv.');
//                //header('refresh:3;url='.$url.'radiobot/'.$server_id);
//
//            } else {
//                echo sendError('Fehler', $resu->ErrorMessage);
//            }
//
//        }
//
//    }
//
////    $fields = array(
////        'changeBitrate' => NULL,
////        'bitrate' => $_POST['bitrate'], //32, 48, 64, 92 ist möglich
////        'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////        'api_key' => $DNodeAPIKey, //Ihr API Key
////    );
////
////    $ch = curl_init();
////
////    curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////    curl_setopt($ch, CURLOPT_POST, 1);
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////    $output = curl_exec($ch);
////
////    curl_close ($ch);
////
////    $output = json_decode($output);
////
////    if($output->status == "success" || $output->status == '"success"'){
////        $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `bitrate` = :data WHERE `id` = :serverID");
////        $updateBotData->execute(array(":data" => $_POST['bitrate'], ":serverID" => $server_id));
////        //echo sendSuccess('Erfolgreich', 'Die neue Bitrate wurde gespeichert und wird nach einem Restart aktiv.');
////        //header('refresh:3;url='.$url.'radiobot/'.$server_id);
////    } else {
////        echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////    }
//
//    if(empty($_POST['ts3_server_password'])){ } else {
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/settings/bot/set/".$botInfos['template_name']."/connect.server_password/".rawurlencode($_POST['ts3_server_password']));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        $headers = array();
//        $headers[] = 'Accept: application/json';
//        $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        $result2 = curl_exec($ch);
//        curl_close ($ch);
//
//        $ress2 = json_decode($result2);
//
//        if(empty($ress2->ErrorCode)){
//
//            $updateBot = $odb->prepare("UPDATE `radiobots` SET `server_password` = :server_password WHERE `template_name` = :template_name");
//            $updateBot->execute(array(":server_password" => $_POST['ts3_server_password'], ":template_name" => $botInfos['template_name']));
//
//        } else {
//            echo sendError('Fehler', $ress2->ErrorMessage);
//        }
//
//    }
//
//    if(!empty($_POST['channel_id'])){
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/settings/bot/set/".$botInfos['template_name']."/connect.channel/%2F".$_POST['channel_id']."");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        $headers = array();
//        $headers[] = 'Accept: application/json';
//        $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        $result = curl_exec($ch);
//        curl_close ($ch);
//
//        $res = json_decode($result);
//
//        if(empty($res->ErrorCode)){
//
//            $updateBot = $odb->prepare("UPDATE `radiobots` SET `default_channel` = :channel_id WHERE `template_name` = :template_name");
//            $updateBot->execute(array(":channel_id" => $channel_id, ":template_name" => $botInfos['template_name']));
//
//        } else {
//            echo sendError('Fehler', $res->ErrorMessage);
//        }
//
//    }
//
//    if(isset($_POST['channel_password']) && !empty($_POST['channel_password'])){
//
//        if(!isset($_POST['channel_password']) || empty($_POST['channel_password'])){
//            $channel_password = NULL;
//        } else {
//            $channel_password = $_POST['channel_password'];
//        }
//
//        if(empty($botInfos['default_channel'])){
//            if(isset($_POST['channel_id'])){
//
//                $channel_id = $_POST['channel_id'];
//
//            } else {
//                echo sendError('Fehler', 'Bitte gebe eine Channel-ID ein.');
//            }
//        } else {
//            $channel_id = $botInfos['default_channel'];
//        }
//
//        if(empty($botInfos['bot_id'])){
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/bot/connect/template/".$botInfos['template_name']);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//            $headers = array();
//            $headers[] = 'Accept: application/json';
//            $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//            $result = curl_exec($ch);
//            curl_close ($ch);
//
////            $updateBotData = $odb->prepare("UPDATE `radiobots` SET `status` = 'ONLINE' WHERE `id` = :serverID");
////            $updateBotData->execute(array(":serverID" => $server_id));
//
//        }
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "http://".$hostsystemInfos['node_ip'].":".$hostsystemInfos['port']."/api/bot/use/".$botInfos['bot_id']."/(/bot/move/".$channel_id."/".rawurlencode($_POST['channel_password']));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        $headers = array();
//        $headers[] = 'Accept: application/json';
//        $headers[] = 'Authorization: Basic '.base64_encode($hostsystemInfos["username"].':'.$hostsystemInfos["token"]);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        $result = curl_exec($ch);
//        curl_close ($ch);
//
//        $res = json_decode($result);
//
//        if(empty($res->ErrorCode)){
//
//            //TODO
//            // nothing
//
//        } else {
//            echo sendError('Fehler', $res->ErrorMessage);
//        }
//
//    }
//
//    echo sendSuccess('Erfolgreich', 'Die einstellungen wurden gespeichert.');
//    header('refresh:3;url='.$url.'radiobot/'.$server_id);
//
//}
//
////if(isset($_POST['changeRights'])){
////    //---------------------------------------------------------//
////
////    if(empty($_POST['group_id'])){
////        $group_id = '999999';
////    } else {
////        $group_id = $_POST['group_id'];
////    }
////
////    if(empty($_POST['admin_id'])){
////        $admin_id = '999999';
////    } else {
////        $admin_id = $_POST['admin_id'];
////    }
////
////    $fields = array(
////        'setAdminID' => NULL,
////        'group_id' => $group_id, //Gruppen ID vom Teamspeak Rang
////        'admin_id' => $admin_id, //Teamspeak User Identität
////        'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////        'api_key' => $DNodeAPIKey, //Ihr API Key
////    );
////
////    $ch = curl_init();
////
////    curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////    curl_setopt($ch, CURLOPT_POST, 1);
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////    $output = curl_exec($ch);
//////echo $output;
////    curl_close ($ch);
////
////    $output = json_decode($output);
////
////    if($output->status == "success" || $output->status == '"success"'){
////
////        $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `group_id`=:group_id WHERE `id` = :serverID");
////        $updateBotData->execute(array(":group_id" => $group_id, ":serverID" => $server_id));
////
////        $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `admin_id`=:admin_id WHERE `id` = :serverID");
////        $updateBotData->execute(array(":admin_id" => $admin_id, ":serverID" => $server_id));
////
////        echo sendSuccess('Erfolgreich', 'Die Rechte wurden gespeichert und sind nach einem Neustart aktiv!');
////        header('refresh:3;url='.$url.'radiobot/'.$server_id);
////
////    } else {
////        echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////    }
////
////    //---------------------------------------------------------//
////}
//
//if(isset($_POST['sendStart'])){
////    $fields = array(
////        'startBot' => NULL,
////        'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////        'api_key' => $DNodeAPIKey, //Ihr API Key
////    );
////
////    $ch = curl_init();
////
////    curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////    curl_setopt($ch, CURLOPT_POST, 1);
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////    $output = curl_exec($ch);
////
////    curl_close ($ch);
////
////    $output = json_decode($output);
////
////    if($output->status == "success" || $output->status == '"success"'){
////        $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `status` = 'ONLINE' WHERE `id` = :serverID");
////        $updateBotData->execute(array(":serverID" => $server_id));
////        echo sendSuccess('Erfolgreich', 'Dein Bot wurde gestartet.');
////        header('refresh:3;url='.$url.'radiobot/'.$server_id);
////    } else {
////        echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////    }
//
//    if(!(is_null($botInfos['bot_id']))){
//        echo sendError('Fehler', 'Dein Bot ist läuft bereits.');
//    } else {
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/connect/template/" . $botInfos['template_name']);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//        $headers = array();
//        $headers[] = 'Accept: application/json';
//        $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        $result = curl_exec($ch);
//        curl_close($ch);
//
//        $res = json_decode($result);
//
//        if (isset($res->Id)) {
//
//            $bot_id = $res->Id;
//
//            $getBotIDCount = $odb->prepare("SELECT * FROM `radiobots` WHERE `bot_id` = :bot_id");
//            $getBotIDCount->execute(array(":bot_id" => $bot_id));
//            if ($getBotIDCount->rowCount() == 0) {
//
//                $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_id` = :bot_id WHERE `template_name` = :template_name");
//                $updateBot->execute(array(":bot_id" => $bot_id, ":template_name" => $_POST['template_name']));
//
////                $updateBotData = $odb->prepare("UPDATE `radiobots` SET `status` = 'ONLINE' WHERE `id` = :serverID");
////                $updateBotData->execute(array(":serverID" => $server_id));
//
//            } else {
//
//                $ch = curl_init();
//                curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $bot_id . "/(/bot/disconnect");
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//                $headers = array();
//                $headers[] = 'Accept: application/json';
//                $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
//                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//                $result = curl_exec($ch);
//                curl_close($ch);
//
//                //$res = json_decode($result);
//
//                $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_id` = NULL WHERE `bot_id` = :bot_id");
//                $updateBot->execute(array(":bot_id" => $bot_id));
//
//                echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
//            }
//
//        }
//
//    }
//}
//
//if(isset($_POST['sendStop'])){
////    $fields = array(
////        'stopBot' => NULL,
////        'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////        'api_key' => $DNodeAPIKey, //Ihr API Key
////    );
////
////    $ch = curl_init();
////
////    curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////    curl_setopt($ch, CURLOPT_POST, 1);
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////    $output = curl_exec($ch);
////
////    curl_close ($ch);
////
////    $output = json_decode($output);
////
////    if($output->status == "success" || $output->status == '"success"'){
////        $updateBotData = $odb->prepare("UPDATE `ts3_radiobots` SET `status` = 'OFFLINE' WHERE `id` = :serverID");
////        $updateBotData->execute(array(":serverID" => $server_id));
////        echo sendSuccess('Erfolgreich', 'Dein Bot wurde gestoppt.');
////        header('refresh:3;url='.$url.'radiobot/'.$server_id);
////    } else {
////        echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////    }
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/bot/disconnect");
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//    $headers = array();
//    $headers[] = 'Accept: application/json';
//    $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    $result = curl_exec($ch);
//    curl_close($ch);
//
//    $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_id` = NULL WHERE `template_name` = :template_name");
//    $updateBot->execute(array(":template_name" => $_POST['template_name']));
//
////    $updateBotData = $odb->prepare("UPDATE `radiobots` SET `status` = 'OFFLINE' WHERE `id` = :serverID");
////    $updateBotData->execute(array(":serverID" => $server_id));
//
//    echo sendSuccess('Erfolgreich', 'Dein Bot wurde gestoppt.');
//    header('refresh:3;url='.$url.'radiobot/'.$server_id);
//
//}
//
//if(isset($_POST['sendRestart'])){
////    $fields = array(
////        'stopBot' => NULL,
////        'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////        'api_key' => $DNodeAPIKey, //Ihr API Key
////    );
////
////    $ch = curl_init();
////
////    curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////    curl_setopt($ch, CURLOPT_POST, 1);
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////    $output = curl_exec($ch);
////
////    curl_close ($ch);
////
////    $output = json_decode($output);
////
////    if($output->status == "success" || $output->status == '"success"'){
////
////        sleep(5);
////
////        $fields = array(
////            'startBot' => NULL,
////            'bot_id' => $serverInfos['service_id'], //Die ServiceID Ihres Radiobots
////            'api_key' => $DNodeAPIKey, //Ihr API Key
////        );
////
////        $ch = curl_init();
////
////        curl_setopt($ch, CURLOPT_URL,"https://mein.digitalnode.de/api/v1/radiobot/manage");
////        curl_setopt($ch, CURLOPT_POST, 1);
////        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
////        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////
////        $output = curl_exec($ch);
////
////        curl_close ($ch);
////
////        $output = json_decode($output);
////
////        if($output->status == "success" || $output->status == '"success"'){
////
////            echo sendSuccess('Erfolgreich', 'Dein Bot wurde neugestartet.');
////            header('refresh:3;url='.$url.'radiobot/'.$server_id);
////
////        } else {
////            echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////        }
////
////    } else {
////        echo sendError('Fehler', 'Es ist ein unbekannter Fehler aufgetreten.');
////    }
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $botInfos['bot_id'] . "/(/bot/disconnect");
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//    $headers = array();
//    $headers[] = 'Accept: application/json';
//    $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    $result = curl_exec($ch);
//    curl_close($ch);
//
//    $res = json_decode($result);
//
//    sleep(4);
//
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/connect/template/" . $botInfos['template_name']);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//    $headers = array();
//    $headers[] = 'Accept: application/json';
//    $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    $result = curl_exec($ch);
//    curl_close($ch);
//
//    $res = json_decode($result);
//
//    if (isset($res->Id)) {
//
//        $bot_id = $res->Id;
//
//        $updateBot = $odb->prepare("UPDATE `radiobots` SET `bot_id` = :bot_id WHERE `template_name` = :template_name");
//        $updateBot->execute(array(":bot_id" => $bot_id, ":template_name" => $_POST['template_name']));
//
//        echo sendSuccess('Erfolgreich', 'Dein Bot wurde neugestartet.');
//        header('refresh:3;url='.$url.'radiobot/'.$server_id);
//
//    }
//
//}