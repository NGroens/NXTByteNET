<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 06.12.2018
 * Time: 10:35
 */

$id = $_GET['id'];
$clicker_ip = $user->getRealIpAddr();

if(!empty($id)){

    $SQL = $odb->prepare("SELECT * FROM `users` WHERE `affiliate_id` = :affiliate_id");
    $SQL->execute(array(':affiliate_id' => $id));
    $affiliateInfos = $SQL->fetch(PDO::FETCH_ASSOC);

    $SQL = $odb->prepare("SELECT * FROM `affiliate_clicks` WHERE `affiliate_id` = :affiliate_id AND `clicker_ip` = :clicker_ip");
    $SQL->execute(array(':affiliate_id' => $id, ":clicker_ip" => $clicker_ip));
    if($SQL->rowCount() == 0){
        $SQL = $odb->prepare("INSERT INTO `affiliate_clicks`(`affiliate_id`, `clicker_ip`) VALUES (:affiliate_id,:clicker_ip)");
        $SQL->execute(array(':affiliate_id' => $id, ":clicker_ip" => $clicker_ip));
    }

    setcookie("affiliate_id", $id, time() + (10 * 365 * 24 * 60 * 60));
	header('Location: '.$url);

} else {
    header('Location: '.$url);
}