<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 11.11.2018
 * Time: 16:38
 */

$orderSuccess = false;

if(isset($_POST['orderService'])){
    if($site->userHaveValidProfile($odb, $_SESSION['id'])) {
        if (isset($_POST['slot_count']) && !empty($_POST['slot_count']) && $_POST['slot_count'] <= 1000 && $_POST['slot_count'] >= 10) {
            if (isset($_POST['duration']) && !empty($_POST['duration'])) {
                if ($order->validateInterval($_POST['duration'])) {
                    if (isset($_POST['agb'])) {
                        if (isset($_POST['wiederruf'])) {

                            $price = ($_POST['slot_count'] * $site->getPriceFromProduct($odb, 'TEAMSPEAK')) * ($_POST['duration'] / 30);

                            if (round($user->getMoney($odb, $_SESSION['id']),2) >= round($price,2)) {

                                $node_id = '1';
                                $getNodeInfos = $odb->prepare("SELECT * FROM `teamspeak_hosts` WHERE `id` = :id");
                                $getNodeInfos->execute(array(":id" => $node_id));
                                $nodeInfos = $getNodeInfos->fetch(PDO::FETCH_ASSOC);

                                $port = rand(9000, 12000);
                                if ($order->isTS3PortAviable($odb, $node_id, $port)) {

                                    $sid_converter = json_encode($ts3->createServer($odb, $node_id, $_POST['slot_count'], $port));
                                    $get_sid = json_decode($sid_converter);
                                    $sid = $get_sid->sid;

                                    $date = new DateTime(null, new DateTimeZone('Europe/Berlin'));
                                    $date->getTimestamp();
                                    $date->modify('+' . $_POST['duration'] . ' day');
                                    $new_date = $date->format('Y-m-d H:i:s');

                                    if ($userInfo['msg_order'] == 1) {
                                        include 'app/mail/mail_templates/order_teamspeak.php';
                                        sendMail($userInfo['email'], $userInfo['username'], $mailContent, $mailSubject, $emailAltBody, '', '');
                                    }

                                    $SQLInsertBot = $odb->prepare("INSERT INTO `teamspeaks`(`slots`, `user_id`, `node_id`, `teamspeak_ip`, `teamspeak_port`, `sid`, `expire_at`) VALUES (:slots,:user_id,:node_id,:teamspeak_ip,:teamspeak_port,:sid,:expire_at)");
                                    $SQLInsertBot->execute(array(":slots" => $_POST['slot_count'], ":user_id" => $_SESSION['id'], ":node_id" => $node_id, ":teamspeak_ip" => $nodeInfos['login_ip'], ":teamspeak_port" => $port, ":sid" => $sid, ":expire_at" => $new_date));
                                    $user->removeMoney($odb, $price, $_SESSION['id']);
                                    $order->addOrder($odb, $_SESSION['id'], 'ORDER', '-' . $price, 'Teamspeak bestellung.');

                                    $orderSuccess = true;

//                                    echo sendSuccess('Erfolgreich', 'Dein Teamspeak wird nun eingerichtet.');
//                                    header('refresh:3;url=' . $url . 'teamspeaks');

                                } else {
                                    echo sendError('Bitte führe die Bestellung erneut aus.');
                                }

                            } else {
                                echo sendError('Du hast leider nicht genug Guthaben.');
                            }

                        } else {
                            echo sendError( 'Du musst dein Wiederrufsrecht akzeptieren.');
                        }
                    } else {
                        echo sendError('Du musst die AGB akzeptieren.');
                    }
                } else {
                    echo sendError( 'Bitte wähle eine Gültige Laufzeit aus.');
                }
            } else {
                echo sendError( 'Bitte wähle eine Gültige Laufzeit aus.');
            }
        } else {
            echo sendError('Bitte gebe eine gültige Zahl zwichen 10 und 1000 an an.');
        }
    } else {
        echo sendError('Bitte fülle erst dein Profil aus.');
        header('refresh:3;url=' . $url . 'profil');
    }
}