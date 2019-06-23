<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 10.11.2018
 * Time: 22:07
 */

class order{

    function addOrder($odb, $user_id, $art, $price, $desc){
        $SQL = $odb->prepare("INSERT INTO `user_transactions`(`user_id`, `art`, `amount`, `description`) VALUES (:user_id,:art,:amount,:description)");
        $SQL->execute(array(":user_id" => $user_id, ":art" => $art, ":amount" => $price, ":description" => $desc, ));
    }

    function validateInterval($interval){

        if($interval == 1 || $interval == 3 || $interval == 7 || $interval == 10 || $interval == 14 || $interval == 30 || $interval == 60 || $interval == 90 || $interval == 180 || $interval == 365){
            return TRUE;
        } else {
            return FALSE;
        }

    }

    function getIntervalFactor($interval){

        $IF = $interval / 30;
        return $IF;

    }

    function isTS3PortAviable($odb, $node_id, $port){

        $SQL = $odb->prepare("SELECT * FROM `teamspeaks` WHERE `node_id` = :node_id AND `teamspeak_port` = :port AND `deleted_at` IS NULL");
        $SQL->execute(array(":node_id" => $node_id, ":port" => $port));
        if($SQL->rowCount() == 0){
            return TRUE;
        } else {
            return FALSE;
        }


    }

}