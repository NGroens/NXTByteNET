<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 11.11.2018
 * Time: 02:05
 */

//require_once("./libraries/TeamSpeak3/TeamSpeak3.php");

class ts3{

    function getStatus($odb, $node_id, $ts_port){

        try{
            $SQL = $odb -> prepare("SELECT * FROM `teamspeak_hosts` WHERE `id` = :id");
            $SQL -> execute(array(":id" => $node_id));
            $nodeInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

            $uri = "serverquery://".$nodeInfos['login_name'].":".$nodeInfos['login_passwort']."@".$nodeInfos['login_ip'].":".$nodeInfos['login_port']."/?server_port=".$ts_port;
            $ts3_VirtualServer = TeamSpeak3::factory($uri);

            return 'ONLINE';

            $ts3_VirtualServer->serverDeselect();

        }catch(TeamSpeak3_Exception $e){
            return 'OFFLINE';
        }

    }

    function startServer($odb, $node_id, $ts_port, $sid){

        if($this->getStatus($odb, $node_id, $ts_port) == 'OFFLINE'){

            $SQL = $odb -> prepare("SELECT * FROM `teamspeak_hosts` WHERE `id` = :id");
            $SQL -> execute(array(":id" => $node_id));
            $nodeInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

            $ts3_ServerInstance = TeamSpeak3::factory("serverquery://".$nodeInfos['login_name'].":".$nodeInfos['login_passwort']."@".$nodeInfos['login_ip'].":".$nodeInfos['login_port']."/");

            $ts3_ServerInstance->serverStart($sid);

        }

    }

    function stopServer($odb, $node_id, $ts_port, $sid){

        if($this->getStatus($odb, $node_id, $ts_port) == 'ONLINE'){

            sleep(2);

            $SQL = $odb -> prepare("SELECT * FROM `teamspeak_hosts` WHERE `id` = :id");
            $SQL -> execute(array(":id" => $node_id));
            $nodeInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

            $ts3_ServerInstance = TeamSpeak3::factory("serverquery://".$nodeInfos['login_name'].":".$nodeInfos['login_passwort']."@".$nodeInfos['login_ip'].":".$nodeInfos['login_port']."/");

            $ts3_ServerInstance->serverStop($sid);

        }

    }

    function createServer($odb, $node_id, $max_slots, $server_port){

        $SQL = $odb -> prepare("SELECT * FROM `teamspeak_hosts` WHERE `id` = :id");
        $SQL -> execute(array(":id" => $node_id));
        $nodeInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

        $ts3_ServerInstance = TeamSpeak3::factory("serverquery://".$nodeInfos['login_name'].":".$nodeInfos['login_passwort']."@".$nodeInfos['login_ip'].":".$nodeInfos['login_port']."/");

        $new_sid = $ts3_ServerInstance->serverCreate(array(
            "virtualserver_name" => "Teamspeak hosted by NXTByte.net",
            "virtualserver_maxclients" => $max_slots,
            "virtualserver_port" => $server_port,
        ));

        return $new_sid;

    }

    function deleteServer($odb, $node_id, $sid){

        $SQL = $odb -> prepare("SELECT * FROM `teamspeak_hosts` WHERE `id` = :id");
        $SQL -> execute(array(":id" => $node_id));
        $nodeInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

        $ts3_ServerInstance = TeamSpeak3::factory("serverquery://".$nodeInfos['login_name'].":".$nodeInfos['login_passwort']."@".$nodeInfos['login_ip'].":".$nodeInfos['login_port']."/");

        $ts3_ServerInstance->serverDelete($sid);

    }

}