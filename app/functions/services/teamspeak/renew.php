<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 12.11.2018
 * Time: 16:53
 */


$server_id = $_GET['id'];

$SQLGetServerInfos = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `id` = :id");
$SQLGetServerInfos -> execute(array(":id" => $server_id));
$serverInfos = $SQLGetServerInfos -> fetch(PDO::FETCH_ASSOC);

if(!($serverInfos['deleted_at'] == NULL)){
    header('Location: '.$url.'teamspeak/order');
}

$price = $serverInfos['slots'] * $site->getPriceFromProduct($odb, 'TEAMSPEAK');

if(is_null($serverInfos['suspended'])){
    $suspended = FALSE;
    $status_name = 'Aktiv';
} else {
    $suspended = TRUE;
    $status_name = 'Abgelaufen';
}

if(isset($_POST['renewService'])){
    if(isset($_POST['duration']) && !empty($_POST['duration'])){
        if($order->validateInterval($_POST['duration'])){

            $price = round($price * ($_POST['duration'] / 30), 2);

            if($user->getMoney($odb, $_SESSION['id']) >= $price){

                $date = new DateTime($serverInfos['expire_at'], new DateTimeZone('Europe/Berlin'));
                $date->getTimestamp();
                $date->modify('+'.$_POST['duration'].' day');
                $new_date = $date->format('Y-m-d H:i:s');

                $SQLUpdateBot = $odb->prepare("UPDATE `teamspeaks` SET `expire_at`=:expire_at,`suspended` = NULL WHERE `id` = :service_id");
                $SQLUpdateBot->execute(array(":service_id" => $server_id, ":expire_at" => $new_date));
                $user->removeMoney($odb, $price, $_SESSION['id']);
                $order->addOrder($odb,$_SESSION['id'],'RENEW','-'.$price,'Teamspeak verlängerung.');
                echo sendSuccess('Dein Teamspeak wurde erfolgreich verlängert. ');
                header('refresh:3;url='.$url.'teamspeak/'.$server_id);

            } else {
                echo sendError('Du hast leider nicht genug Guthaben.');
            }
        } else {
            echo sendError('Bitte wähle eine gültige Laufzeit aus.');
        }
    } else {
        echo sendError('Bitte wähle eine gültige Laufzeit aus.');
    }
}