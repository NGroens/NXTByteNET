<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 10.11.2018
 * Time: 21:55
 */

class site{

    function getPriceFromProduct($odb, $product_name){

        $SQL = $odb->prepare("SELECT * FROM `product_prices` WHERE `product_name` = :product_name");
        $SQL->execute(array(':product_name' => $product_name));
        $productInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

        return $productInfos['price'];

    }

    function getProductsFromCustomer($odb, $user_id){

        $SQLgetTS3 = $odb->prepare("SELECT * FROM `teamspeaks` WHERE `user_id` = :user_id AND `deleted_at` IS NULL");
        $SQLgetTS3->execute(array(':user_id' => $user_id));
        $teamspeaks = $SQLgetTS3->rowCount();

        $SQLgetVoiceBot = $odb->prepare("SELECT * FROM `radiobots` WHERE `user_id` = :user_id AND `deleted_at` IS NULL");
        $SQLgetVoiceBot->execute(array(':user_id' => $user_id));
        $voicebots = $SQLgetVoiceBot->rowCount();

        return $teamspeaks + $voicebots;

    }

    function getOpenTicketsFromCustomer($odb, $user_id){

        $SQLgetTickets = $odb->prepare("SELECT * FROM `tickets` WHERE `user_id` = :user_id AND `status` = 'OPEN'");
        $SQLgetTickets->execute(array(':user_id' => $user_id));
        $tickets = $SQLgetTickets->rowCount();

        return $tickets;

    }

    function getMontlyCostsFromCustomer($odb, $user_id){

        $costs = '0.00';

        $SQL = $odb->prepare("SELECT * FROM `product_prices` WHERE `product_name` = :product_name");
        $SQL->execute(array(':product_name' => 'TEAMSPEAK'));
        $productInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

        $SQLSelectServers = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `user_id` = :user_id AND `deleted_at` IS NULL");
        $SQLSelectServers->execute(array(":user_id" => $user_id));
        if ($SQLSelectServers->rowCount() != 0) {
            while ($row = $SQLSelectServers->fetch(PDO::FETCH_ASSOC)) {

                $slotPrice = $row['slots'] * $productInfos['price'];

                $costs = $slotPrice + $costs;

            }
        }

        $SQLSelectServers = $odb -> prepare("SELECT * FROM `radiobots` WHERE `user_id` = :user_id AND `deleted_at` IS NULL");
        $SQLSelectServers->execute(array(":user_id" => $user_id));
        if ($SQLSelectServers->rowCount() != 0) {
            while ($row = $SQLSelectServers->fetch(PDO::FETCH_ASSOC)) {

                $costs = $row['price'] + $costs;

            }
        }

        return $costs;

    }

    function userHaveValidProfile($odb, $user_id){

        $SQL = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $userInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

        if($userInfos['vorname'] == NULL){
            return FALSE;
        } else {
            return TRUE;
        }

    }

    function formatDate($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.Y H:i:s');
    }

    function formatDateWithoutTime($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.Y');
    }

    function getDiffInDays($dateTime){
        $datetime1 = new DateTime(null, new DateTimeZone('Europe/Berlin'));
        $datetime2 = new DateTime($dateTime, new DateTimeZone('Europe/Berlin'));
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%a');
    }

}