<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 12.11.2018
 * Time: 17:23
 */

if(isset($_POST['safeProfile'])){
    if(empty($_POST['vorname'])){ $vorname = NULL; } else { $vorname = $_POST['vorname']; }
    if(empty($_POST['nachname'])){ $nachname = NULL; } else { $nachname = $_POST['nachname']; }
    if(empty($_POST['strasse'])){ $strasse = NULL; } else { $strasse = $_POST['strasse']; }
    if(empty($_POST['postleitzahl'])){ $postleitzahl = NULL; } else { $postleitzahl = $_POST['postleitzahl']; }
    if(empty($_POST['stadt'])){ $stadt = NULL; } else { $stadt = $_POST['stadt']; }
    if(empty($_POST['land'])){ $land = NULL; } else { $land = $_POST['land']; }

    if(empty($_POST['vorname']) || empty($_POST['nachname']) || empty($_POST['strasse']) || empty($_POST['postleitzahl']) ||empty($_POST['stadt']) || empty($_POST['land'])){
        echo sendError('Bitte fülle alle Felder aus');
    } else {
        $SQL = $odb->prepare("UPDATE `users` SET `vorname`=:vorname,`nachname`=:nachname,`strasse`=:strasse,`postleitzahl`=:postleitzahl,`stadt`=:stadt,`land`=:land WHERE `id` = :user_id");
        $SQL->execute(array(":vorname" => $vorname, ":nachname" => $nachname, ":strasse" => $strasse, ":postleitzahl" => $postleitzahl, ":stadt" => $stadt, ":land" => $land, ":user_id" => $_SESSION['id']));

        echo sendSuccess('Dein Profil wurde gespeichert');
        header('refresh:3;url='.$url.'profil');
    }

}

if(isset($_POST['safeEmail'])){
    if(isset($_POST['order'])){ $order = '1'; } else { $order = '0'; }
    if(isset($_POST['money'])){ $money = '1'; } else { $money = '0'; }
    if(isset($_POST['support'])){ $support = '1'; } else { $support = '0'; }

    $SQL = $odb->prepare("UPDATE `users` SET `msg_order`=:order,`msg_money`=:money,`msg_support`=:support WHERE `id` = :user_id");
    $SQL->execute(array(":order" => $order, ":money" => $money, ":support" => $support, ":user_id" => $_SESSION['id']));

    echo sendSuccess('Die Einstellungen wurden gespeichert');
    header('refresh:3;url='.$url.'profil');

}