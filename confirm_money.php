<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'app/require_once/database.php';
include 'app/require_once/config.php';

ob_start();
session_start();

$key = $_GET['key'];

if(isset($key) && !empty($key)){

    $SQLCheckKey = $odb -> prepare("SELECT COUNT(*) FROM `transfer_money` WHERE `key` = :key");
    $SQLCheckKey -> execute(array(':key' => $key));
    $countKey = $SQLCheckKey -> fetchColumn(0);
    if ($countKey == 1){

        $SQL = $odb->prepare("SELECT * FROM `transfer_money` WHERE `key` = :key");
        $SQL->execute(array(":key" => $_GET['key']));
        $keyInfos = $SQL->fetch(PDO::FETCH_ASSOC);

        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $SQL->execute(array(":username" => $keyInfos['sender_name']));
        $senderInfos = $SQL->fetch(PDO::FETCH_ASSOC);

        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `username` = :username");
        $SQL->execute(array(":username" => $keyInfos['receiver_name']));
        $receiverInfos = $SQL->fetch(PDO::FETCH_ASSOC);

        $newSenderMoney = $senderInfos['amount'] - $keyInfos['amount'];
        $removeMoney = $odb->prepare("UPDATE `users` SET `amount`=:amount WHERE `username` = :username");
        $removeMoney->execute(array(":amount" => $newSenderMoney, ":username" => $senderInfos['username']));

        $newReceiverMoney = $keyInfos['amount'] + $receiverInfos['amount'];
        $removeMoney = $odb->prepare("UPDATE `users` SET `amount`=:amount WHERE `username` = :username");
        $removeMoney->execute(array(":amount" => $newReceiverMoney, ":username" => $receiverInfos['username']));

        $SQL = $odb->prepare("DELETE FROM `transfer_money` WHERE `key` = :key");
        $SQL->execute(array(":key" => $_GET['key']));

        $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'DONE',:amount,:desc,:tid)");
        $SQL->execute(array(":user_id" => $senderInfos['id'], ":gateway" => 'intern', ":amount" => '-'.$keyInfos['amount'], ":desc" => 'Spende', ":tid" => 'INTERNE SPENDE'));

        $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'DONE',:amount,:desc,:tid)");
        $SQL->execute(array(":user_id" => $receiverInfos['id'], ":gateway" => 'intern', ":amount" => $keyInfos['amount'], ":desc" => 'Spende', ":tid" => 'INTERNE SPENDE'));

        setcookie("confirm_money", 'unused', time() + 5);

        header('Location: '.$url.'guthaben/aufladen');
    } else {
        setcookie("confirm_money_2", 'unused', time() + 5);
        header('Location: '.$url.'guthaben/aufladen');
    }

}

?>