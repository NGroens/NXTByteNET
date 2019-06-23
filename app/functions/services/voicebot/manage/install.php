<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 16.03.2019
 * Time: 14:59
 */

if(isset($_POST['installServer'])){

    require_once('Net/SSH2.php');
    $ssh = new Net_SSH2($hostsystemInfos['node_ip'], $hostsystemInfos['node_port']);
    if (!$ssh->login($hostsystemInfos['node_user'], $hostsystemInfos['node_password'])) {

        echo sendError('Das Hostsystem ist nicht erreichbar!');

    } else {
        // copy bot template
        $ssh->exec('cp -R /home/template/rename_me_now.toml /home/radiobot/Bots/');

        // rename bot template
        $ssh->exec('mv /home/radiobot/Bots/rename_me_now.toml /home/radiobot/Bots/bot_' . $botInfos['template_name'] . '.toml');

//        // get new information
//        $getBotInfos = $odb->prepare("SELECT * FROM `radiobots` WHERE `template_name` = :template_name AND `user_id` = :user_id");
//        $getBotInfos -> execute(array(":template_name" => $_POST['template_name'], ":user_id" => $userInfos['id']));
//        $botInfos = $getBotInfos->fetch(PDO::FETCH_ASSOC);

        // update database
        $updateBot = $odb->prepare("UPDATE `radiobots` SET `state` = :state WHERE `template_name` = :template_name");
        $updateBot->execute(array(":state" => 'ACTIVE', ":template_name" => $botInfos['template_name']));


        echo sendSuccess( 'Dein Bot wird nun installiert!');
        header('refresh:3;url='.$url.'musikbot/'.$server_id);
    }

}