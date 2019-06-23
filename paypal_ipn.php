<?php

require 'app/mail/PHPMailer/src/Exception.php';
require 'app/mail/PHPMailer/src/PHPMailer.php';
require 'app/mail/PHPMailer/src/SMTP.php';

include 'app/require_once/database.php';
include 'app/require_once/config.php';
include 'app/notifications/sendMail.php';
include 'app/notifications/sendPush.php';

ob_start();
session_start();

$paypalConfig = [
    'email' => $paypalEmail,
    'return_url' => $url.'guthaben/aufladen/erfolgreich',
    'cancel_url' => $url.'guthaben/aufladen',
    'notify_url' => $url.'paypal_ipn.php'
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

require 'app/functions/payment/paypal/functions.php';


if (isset($_POST["txn_id"]) && isset($_POST["txn_type"])) {

    $data = [
        'item_name' => $_POST['item_name'],
        'item_number' => $_POST['item_number'],
        'payment_status' => $_POST['payment_status'],
        'payment_amount' => $_POST['mc_gross'],
        'payment_currency' => $_POST['mc_currency'],
        'txn_id' => $_POST['txn_id'],
        'receiver_email' => $_POST['receiver_email'],
        'payer_email' => $_POST['payer_email'],
        'custom' => $_POST['custom'],
    ];

    if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {

        $user_id = $data['custom'];

        /*
         * topup system
         */
        $paypal = false;

        $SQL = $odb->prepare("SELECT * FROM `topup_actions` WHERE `expire_at` IS NOT NULL");
        $SQL->execute();
        if ($SQL->rowCount() != 0) {
            while ($row = $SQL->fetch(PDO::FETCH_ASSOC)) {

                if($row['method'] == 'PAYPAL'){
                    $paypal = true;
                    $percent = $row['percent'];
                }

            }
        }

        $money = $data['payment_amount'];
        if($paypal){
            $money = $money * $percent;
        }
        /*
         * topup system end
         */

        $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'DONE',:amount,'Guthabenaufladung mit paypal',:tid)");
        $SQL->execute(array(":user_id" => $user_id, ":gateway" => 'paypal', ":amount" => $money, ":tid" => $data['txn_id']));

        $user->addMoney($odb, $money, $user_id);
		
		$getCustomer = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $getCustomer->execute(array(":id" => $user_id));
        $customerDetails = $getCustomer->fetch(PDO::FETCH_ASSOC);

		sendPush($pushoverUserKey,'Neue Guthabenaufladung','Soeben wurden '.$money.'€ von '.$customerDetails['username'].' aufgeladen');


    }
}