<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 07.03.2019
 * Time: 22:38
 */

require_once('vendor/autoload.php');

$date = new DateTime(null, new DateTimeZone('Europe/Berlin'));
$timeNow = $date->getTimestamp();
$dateTimeNow = $date->format('Y-m-d H:i:s');

require_once 'app/mail/PHPMailer/src/Exception.php';
require_once 'app/mail/PHPMailer/src/PHPMailer.php';
require_once 'app/mail/PHPMailer/src/SMTP.php';

include_once 'app/require_once/database.php';
include_once 'app/require_once/config.php';
include_once 'app/notifications/sendMail.php';
include_once 'app/require_once/site_settings.php';

\Stripe\Stripe::setApiKey("sk_live_YvGJjwI9ak1hS0eRub4sP77g00yl967NWN");
$endpoint_secret = 'whsec_U2V7fUadNbexSSRb1lRJOoRUpNUTlTWq';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400); // PHP 5.4 or greater
    exit();
} catch(\Stripe\Error\SignatureVerification $e) {
    // Invalid signature
    http_response_code(400); // PHP 5.4 or greater
    exit();
}

if ($event->type == "checkout.session.completed") {

    //$payment_id = $event->id;
    $payment_id = $event->data->object->id;

    //---------------------------------------//
    /*
     *                Payment OK
     *        Here you can save the Payment
     * process your actions here (i.e. send confirmation email etc.)
     */
    //---------------------------------------//

    $getPayment = $odb -> prepare("SELECT * FROM `transactions` WHERE `tid` = :tid");
    $getPayment->execute(array(":tid" => $payment_id));
    if($getPayment->rowCount() == 1) {

        $updatePayment = $odb->prepare("UPDATE `transactions` SET `state` = 'DONE' WHERE `tid` = :tid");
        $updatePayment->execute(array(":tid" => $payment_id));

        $getPayment = $odb->prepare("SELECT * FROM `transactions` WHERE `tid` = :tid");
        $getPayment->execute(array(":tid" => $payment_id));
        $paymentDetails = $getPayment->fetch(PDO::FETCH_ASSOC);

        $getCustomer = $odb->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $getCustomer->execute(array(":id" => $paymentDetails['user_id']));
        $customerDetails = $getCustomer->fetch(PDO::FETCH_ASSOC);

        /*
        * topup system
        */
        $psc = false;

        $SQL = $odb->prepare("SELECT * FROM `topup_actions` WHERE `expire_at` IS NOT NULL");
        $SQL->execute();
        if ($SQL->rowCount() != 0) {
            while ($row = $SQL->fetch(PDO::FETCH_ASSOC)) {

                if($row['method'] == 'PAYSAFECARD'){
                    $psc = true;
                    $percent = $row['percent'];
                }

            }
        }

        $money = $paymentDetails['amount'];
        if($psc){
            $money = $money * $percent;
        }
        /*
         * topup system end
         */

        $user->addMoney($odb, $money, $customerDetails['id']);

        /*
         * Check for open Affiliate content
         */

        include 'app/mail/mail_templates/amount_added.php';
        sendMail($customerDetails['email'], $customerDetails['username'], $mailContent, $mailSubject, $emailAltBody, '', '');

        //TODO
        sendPush($pushoverUserKey,'Neue Guthabenaufladung','Soeben wurden '.$paymentDetails['amount'].'€ von '.$customerDetails['username'].' aufgeladen');


        $SQL = $odb->prepare("SELECT * FROM `affiliates` WHERE `email` = :email AND `deleted_at` IS NULL;");
        $SQL->execute(array(":email" => $customerDetails['email']));
        if($SQL->rowCount() == 1){
            $SQL = $odb -> prepare("SELECT * FROM `affiliates` WHERE `email` = :email AND `deleted_at` IS NULL;");
            $SQL -> execute(array(":email" => $customerDetails['email']));
            $affiliateInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

            $newAffiliateAmount = $affiliateInfos['amount']+$paymentDetails['amount'];
            if($newAffiliateAmount >= 5){
                if(is_null($affiliateInfos['deleted_at'])) {
                    $SQL = $odb->prepare("UPDATE `affiliates` SET `amount` = :amount AND `deleted_at` = :deleted_at WHERE `email` = :email");
                    $SQL->execute(array(":amount" => $newAffiliateAmount, ":deleted_at" => $dateTimeNow, ":email" => $customerDetails['email']));

                    $user->addBonusMoney($odb, '1.00', $user->getUserIDFromAffiliateID($odb, $affiliateInfos['affiliate_id']));

                    $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'DONE',:amount,'Affiliate Zahlung',:tid)");
                    $SQL->execute(array(":user_id" => $user->getUserIDFromAffiliateID($odb, $affiliateInfos['affiliate_id']), ":gateway" => 'intern', ":amount" => '1.00', ":tid" => 'Affiliate Payment'));
                }
            } else {
                $SQL = $odb -> prepare("UPDATE `affiliates` SET `amount` = :amount WHERE `email` = :email");
                $SQL -> execute(array(":amount" => $newAffiliateAmount, ":email" => $customerDetails['email']));
            }
        }

    }
}

// Do something with $event

http_response_code(200); // PHP 5.4 or greater