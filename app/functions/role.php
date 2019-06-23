<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 01.11.2018
 * Time: 01:35
 */

class role{

    function isInTeam($odb, $user_id)
    {
        $SQL = $odb->prepare("SELECT `role` FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $role = $SQL->fetchColumn(0);
        if ($role == 'ADMIN' || $role == 'SUPPORT') {
            return true;
        } else {
            return false;
        }
    }

    function isAdmin($odb, $user_id)
    {
        $SQL = $odb->prepare("SELECT `role` FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $role = $SQL->fetchColumn(0);
        if ($role == 'ADMIN') {
            return true;
        } else {
            return false;
        }
    }

    function isSup($odb, $user_id)
    {
        $SQL = $odb->prepare("SELECT `role` FROM `users` WHERE `id` = :id");
        $SQL->execute(array(':id' => $user_id));
        $role = $SQL->fetchColumn(0);
        if ($role == 'SUPPORT') {
            return true;
        } else {
            return false;
        }
    }

}