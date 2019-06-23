<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 10.11.2018
 * Time: 23:50
 */

$server_id = $_GET['id'];

$SQLGetServerInfos = $odb -> prepare("SELECT * FROM `radiobots` WHERE `id` = :id");
$SQLGetServerInfos -> execute(array(":id" => $server_id));
$serverInfos = $SQLGetServerInfos -> fetch(PDO::FETCH_ASSOC);

$price = $site->getPriceFromProduct($odb, 'VOICEBOT');

if($serverInfos['state'] == 'NEED_INSTALL'){
    $status_name = 'Warte auf Installation';
    $suspended = FALSE;
    $isInstalled = FALSE;
} elseif($serverInfos['state'] == 'ACTIVE'){
    $status_name = 'Aktiv';
    $suspended = FALSE;
    $isInstalled = TRUE;
} elseif($serverInfos['state'] == ''){
    $status_name = '---';
    $suspended = FALSE;
    $isInstalled = TRUE;
} elseif($serverInfos['state'] == 'SUSPENDED'){
    $status_name = 'Gesperrt';
    $suspended = TRUE;
    $isInstalled = TRUE;
}

if(isset($_POST['renewService'])){
    if(isset($_POST['duration']) && !empty($_POST['duration'])){
        if($order->validateInterval($_POST['duration'])){

            $price = round($price * ($_POST['duration'] / 30), 2);

            if($user->getMoney($odb, $_SESSION['id']) >= $price){

                $date = new DateTime($serverInfos['expire_at'], new DateTimeZone('Europe/Berlin'));
                $date->modify('+' . $_POST['duration'] . ' day');
                $expire_at = $date->format('Y-m-d H:i:s');

                $updateBot = $odb->prepare("UPDATE `radiobots` SET `expire_at` = :expire_at,`state` = 'ACTIVE' WHERE `template_name` = :template_name");
                $updateBot->execute(array(":expire_at" => $expire_at, ":template_name" => $serverInfos['template_name']));

                $user->removeMoney($odb, $price, $_SESSION['id']);
                $order->addOrder($odb,$_SESSION['id'],'RENEW','-'.$price,'MusikBot verlängerung.');
                echo sendSuccess('Dein MusikBot wurde erfolgreich verlängert. ');
                header('refresh:3;url='.$url.'musikbot/'.$server_id);

            } else {
                echo sendError('Du hast leider nicht genug Guthaben.');
            }
        } else {
            echo sendError('Bitte wähle eine gültige Laufzeit aus.');
        }
    } else {
        echo sendError( 'Bitte wähle eine gültige Laufzeit aus.');
    }
}