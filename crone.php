<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 10.11.2018
 * Time: 20:03
 */

$crone_key = 'GDbMReJxpQ8EV67dBtCfHTpKNnXY3LtCK3';

$date = new DateTime(null, new DateTimeZone('Europe/Berlin'));
$timeNow = $date->getTimestamp();
$dateTimeNow = $date->format('Y-m-d H:i:s');

$deleteTime = new DateTime(null, new DateTimeZone('Europe/Berlin'));
$deleteTime->modify('-3 day');
$dateTimeMinus3Days = $deleteTime->format('Y-m-d H:i:s');

require 'app/mail/PHPMailer/src/Exception.php';
require 'app/mail/PHPMailer/src/PHPMailer.php';
require 'app/mail/PHPMailer/src/SMTP.php';

include 'app/require_once/database.php';
include 'app/require_once/config.php';
include 'app/notifications/sendMail.php';

require_once("./libraries/TeamSpeak3/TeamSpeak3.php");

if(isset($_GET['key']) || isset($_POST['key'])){
    if(!empty($_GET['key']) || !empty($_POST['key'])){
        if($_GET['key'] == $crone_key || $_POST['key'] == $crone_key){


//--------------------------------------------------------------------------//
//echo $timeNow;

            $getRadioBots = $odb->prepare("SELECT * FROM `radiobots` WHERE `expire_at` < :dateTimeNow AND `state` = 'ACTIVE' OR `expire_at` < :dateTimeNow AND `state` = 'NEED_INSTALL'");
            $getRadioBots->execute(array(":dateTimeNow" => $dateTimeNow));
            if ($getRadioBots->rowCount() != 0) {
                while ($row = $getRadioBots->fetch(PDO::FETCH_ASSOC)) {

                    //------------------------------------------------------------------------------------------------//
                    if(!empty($row['bot_id']) || !is_null($row['bot_id'])) {
                        $getHostsystemInfos = $odb->prepare("SELECT * FROM `radiobot_hosts` WHERE `id` = :id");
                        $getHostsystemInfos->execute(array(":id" => $row['location']));
                        $hostsystemInfos = $getHostsystemInfos->fetch(PDO::FETCH_ASSOC);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $row['bot_id'] . "/(/bot/disconnect");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                        $headers = array();
                        $headers[] = 'Accept: application/json';
                        $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $result = curl_exec($ch);
                        curl_close($ch);

                        $SQL = $odb->prepare("UPDATE `radiobots` SET `bot_id`=NULL WHERE `id` = :id");
                        $SQL->execute(array(":id" => $row['id']));
                    }
                    //------------------------------------------------------------------------------------------------//

                    $SQL = $odb->prepare("UPDATE `radiobots` SET `state`='SUSPENDED' WHERE `id` = :id");
                    $SQL->execute(array(":id" => $row['id']));

                    include 'app/mail/mail_templates/suspend_radiobot.php';
                    sendMail($user->getEmail($odb, $row['user_id']), $user->getName($odb, $row['user_id']), $mailContent, $mailSubject, $emailAltBody, '', '');


                }
            }

            $getSuspendedRadioBots = $odb->prepare("SELECT * FROM `radiobots` WHERE `expire_at` < :dateTimeMinusDays AND `state` = 'SUSPENDED'");
            $getSuspendedRadioBots->execute(array(":dateTimeMinusDays" => $dateTimeMinus3Days));
            if ($getSuspendedRadioBots->rowCount() != 0) {
                while ($row = $getSuspendedRadioBots->fetch(PDO::FETCH_ASSOC)) {

                    //------------------------------------------------------------------------------------------------//
                    if(!empty($row['template_name'])){

                        $template_name = 'bot_'.$row['template_name'].'.toml';

                        //------------------------------------------------------------------------------------------------//
                        if(!empty($row['bot_id']) || !is_null($row['bot_id'])) {
                            $getHostsystemInfos = $odb->prepare("SELECT * FROM `radiobot_hosts` WHERE `id` = :id");
                            $getHostsystemInfos->execute(array(":id" => $row['location']));
                            $hostsystemInfos = $getHostsystemInfos->fetch(PDO::FETCH_ASSOC);

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "http://" . $hostsystemInfos['node_ip'] . ":" . $hostsystemInfos['port'] . "/api/bot/use/" . $row['bot_id'] . "/(/bot/disconnect");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                            $headers = array();
                            $headers[] = 'Accept: application/json';
                            $headers[] = 'Authorization: Basic ' . base64_encode($hostsystemInfos["username"] . ':' . $hostsystemInfos["token"]);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            $result = curl_exec($ch);
                            curl_close($ch);

                            $SQL = $odb->prepare("UPDATE `radiobots` SET `bot_id`=NULL WHERE `id` = :id");
                            $SQL->execute(array(":id" => $row['id']));
                        }
                        //------------------------------------------------------------------------------------------------//

                        $getHostsystemInfos = $odb->prepare("SELECT * FROM `radiobot_hosts` WHERE `id` = :id");
                        $getHostsystemInfos->execute(array(":id" => $row['location']));
                        $hostsystemInfos = $getHostsystemInfos->fetch(PDO::FETCH_ASSOC);

                        require_once('Net/SSH2.php');
                        $ssh = new Net_SSH2($hostsystemInfos['node_ip'], $hostsystemInfos['node_port']);
                        if (!$ssh->login($hostsystemInfos['node_user'], $hostsystemInfos['node_password'])) {

                            $SQL = $odb->prepare("UPDATE `radiobots` SET `state`='DELETED',`deleted_at` = :deleted_at WHERE `id` = :id");
                            $SQL->execute(array(":id" => $row['id'], ":deleted_at" => $dateTimeNow));

                        } else {

                            $ssh->exec('rm /home/radiobot/Bots/'.$template_name);

                            $SQL = $odb->prepare("UPDATE `radiobots` SET `state`='DELETED',`deleted_at` = :deleted_at WHERE `id` = :id");
                            $SQL->execute(array(":id" => $row['id'], ":deleted_at" => $dateTimeNow));

                        }
                    }
                    //------------------------------------------------------------------------------------------------//

                }
            }

//--------------------------------------------------------------------------//

            $getSuspendedTS3 = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `expire_at` < :now_time AND `suspended` IS NULL");
            $getSuspendedTS3->execute(array(":now_time" => $dateTimeNow));
            if ($getSuspendedTS3->rowCount() != 0) {
                while ($getInfo = $getSuspendedTS3->fetch(PDO::FETCH_ASSOC)) {

                    echo $getInfo['id'];

                    $updateRadioBots = $odb->prepare("UPDATE `teamspeaks` SET `suspended`='1' WHERE `id` = :id");
                    $updateRadioBots->execute(array(":id" => $getInfo['id']));

                    $ts3->stopServer($odb, $getInfo['node_id'],$getInfo['teamspeak_port'],$getInfo['sid']);

                    $SQLGetOwnerInfo = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
                    $SQLGetOwnerInfo->execute(array(":id" => $getInfo['user_id']));
                    $ownerInfo = $SQLGetOwnerInfo->fetch(PDO::FETCH_ASSOC);

                    include 'app/mail/mail_templates/suspend_teamspeak.php';
                    sendMail($ownerInfo['email'], $ownerInfo['username'], $mailContent, $mailSubject, $emailAltBody, '', '');
					//die();
                }
            }

            $suspendTS3 = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `suspended` = 1 AND `expire_at` < :now_time AND `deleted_at` IS NULL;");
            $suspendTS3->execute(array(":now_time" => $dateTimeMinus3Days));
            if ($suspendTS3->rowCount() != 0) {
                while ($getInfo = $suspendTS3 -> fetch(PDO::FETCH_ASSOC)) {

                    $ts3->stopServer($odb, $getInfo['node_id'],$getInfo['teamspeak_port'],$getInfo['sid']);
                    sleep(2);
                    $ts3->deleteServer($odb,$getInfo['node_id'],$getInfo['sid']);

                    $deleteSuspended = $odb->prepare("UPDATE `teamspeaks` SET `deleted_at` = :timeNow WHERE `id` = :id");
                    $deleteSuspended->execute(array(":id" => $getInfo['id'], ":timeNow" => $dateTimeNow));
					//die();
                }
            }
			
			echo 'Cronejob done.';

        }
    }
}