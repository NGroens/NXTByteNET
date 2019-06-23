<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 01.11.2018
 * Time: 01:35
 */

class user{

    function LoggedIn(){
        if (isset($_SESSION['username'], $_SESSION['id']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function getName($odb, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);
        if(isset($userData['username'])){
            return $userData['username'];
        } else {
            return 'Could not get Username';
        }
    }

    function getState($odb, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(":id" => $user_id));
        $userData = $SQL->fetch(PDO::FETCH_ASSOC);

        return $userData['status'];
    }

    function getUserIDFromAffiliateID($odb, $affiliate_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `affiliate_id` = :affiliate_id");
        $SQL->execute(array(':affiliate_id' => $affiliate_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);
        if(isset($userData['id'])){
            return $userData['id'];
        }
    }

    function getEmail($odb, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);
        if(isset($userData['email'])){
            return $userData['email'];
        } else {
            return 'Could not get E-Mail';
        }
    }

    function getRole($odb){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $_SESSION['id']));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);
        if($userData['role'] == 'ADMIN'){
            return 'Administrator';
        } elseif($userData['role'] == 'SUPPORT') {
            return 'Supporter';
        } elseif($userData['role'] == 'USER') {
            return 'Kunde';
        } else {
            return 'Could not get Role';
        }
    }

    function addMoney($odb, $money, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);

        $newUserMoney = $userData['amount'] + $money;
        $updateUserMoney = $odb->prepare("UPDATE `users` SET `amount`=:newUserMoney WHERE `id` = :user_id");
        $updateUserMoney->execute(array(":newUserMoney" => $newUserMoney, ":user_id" => $user_id));
    }

    function removeMoney($odb, $price, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);

        $newUserMoney = $userData['amount'] - $price;
        $updateUserMoney = $odb->prepare("UPDATE `users` SET `amount`=:newUserMoney WHERE `id` = :user_id");
        $updateUserMoney->execute(array(":newUserMoney" => $newUserMoney, ":user_id" => $user_id));
    }

    function addBonusMoney($odb, $money, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);

        $newUserMoney = $userData['bonus_amount'] + $money;
        $updateUserMoney = $odb->prepare("UPDATE `users` SET `bonus_amount`=:newUserMoney WHERE `id` = :user_id");
        $updateUserMoney->execute(array(":newUserMoney" => $newUserMoney, ":user_id" => $user_id));
    }


    function getMoney($odb, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);

        $amount = $userData['amount']+$userData['bonus_amount'];

        return $amount;
    }

    function getNormMoney($odb, $user_id){
        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userData = $SQL -> fetch(PDO::FETCH_ASSOC);

        $amount = $userData['amount'];

        return $amount;
    }

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function addTransaction($odb, $user_id, $gateway, $state, $amount, $desc, $tid){
        $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,:state,:amount,:desc,:tid)");
        $SQL->execute(array(':user_id' => $user_id, ':gateway' => $gateway, ':state' => $state, ':amount' => $amount, ':desc' => $desc, ':tid' => $tid));
    }

}