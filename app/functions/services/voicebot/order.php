<?php
/**
 * Created by PhpStorm.
 * User: Sylvano P
 * Date: 10.11.2018
 * Time: 22:05
 */

$orderSuccess = false;

if(isset($_POST['orderService'])){
    if($site->userHaveValidProfile($odb, $_SESSION['id'])) {
        if (isset($_POST['bot_name']) && !empty($_POST['bot_name'])) {
            if (isset($_POST['duration']) && !empty($_POST['duration'])) {
                if ($order->validateInterval($_POST['duration'])) {
                    if (isset($_POST['agb'])) {
                        if (isset($_POST['wiederruf'])) {

                            $price = $site->getPriceFromProduct($odb, 'VOICEBOT') * ($_POST['duration'] / 30);

                            if ($user->getMoney($odb, $_SESSION['id']) >= $price) {

                                // expire date
                                $date = new DateTime(null, new DateTimeZone('Europe/Berlin'));
                                $date->modify('+' . $_POST['duration'] . ' day');
                                $expire_at = $date->format('Y-m-d H:i:s');

                                // template_name
                                function generateRandomString($length = 12){
                                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                    $charactersLength = strlen($characters);
                                    $randomString = '';
                                    for ($i = 0; $i < $length; $i++) {
                                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                                    }
                                    return $randomString;
                                }
                                $template_name = $_SESSION['id'].'_'.generateRandomString();

                                // insert to db
                                $SQL = $odb->prepare("INSERT INTO `radiobots`(`user_id`, `bot_name`, `location`, `state`, `template_name`, `price`, `expire_at`) VALUES (:user_id, :bot_name, :location ,:state ,:template_name ,:price ,:expire_at)");
                                $SQL->execute(array(":user_id" => $_SESSION['id'], ":bot_name" => $_POST['bot_name'], ":location" => '1', ":state" => 'NEED_INSTALL', ":template_name" => $template_name, ":price" => $site->getPriceFromProduct($odb, 'VOICEBOT'), ":expire_at" => $expire_at));

                                if ($userInfo['msg_order'] == 1) {
                                    include 'app/mail/mail_templates/order_voicebot.php';
                                    sendMail($userInfo['email'], $userInfo['username'], $mailContent, $mailSubject, $emailAltBody, '', '');
                                }

                                $user->removeMoney($odb, $price, $_SESSION['id']);
                                $order->addOrder($odb, $_SESSION['id'], 'ORDER', '-' . $price, 'MusikBot bestellung.');
//                                echo sendSuccess('Erfolgreich', 'Dein MusikBot wird nun eingerichtet.');
//                                header('refresh:3;url=' . $url . 'radiobots');

                                $orderSuccess = true;

                            } else {
                                echo sendError('Du hast leider nicht genug Guthaben.');
                            }

                        } else {
                            echo sendError('Du musst dein Wiederrufsrecht akzeptieren.');
                        }
                    } else {
                        echo sendError( 'Du musst die AGB akzeptieren.');
                    }
                } else {
                    echo sendError('Bitte wähle eine Gültige Laufzeit aus.');
                }
            } else {
                echo sendError('Bitte wähle eine Gültige Laufzeit aus.');
            }
        } else {
            echo sendError('Bitte gebe einen Botnamen an.');
        }
    } else {
        echo sendError( 'Bitte fülle erst dein Profil aus.');
        header('refresh:3;url=' . $url . 'profil');
    }
}