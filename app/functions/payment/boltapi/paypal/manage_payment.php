<?php

if(isset($_POST['payNow'])){
    if($_POST['payment_method'] == 'PAYPAL'){
        if($_POST['amount'] >= 3 && $_POST['amount'] <= $max_payment && is_numeric($_POST['amount'])){

            $fields = array(
                'startPayment' => NULL,
                'payment_method' => 'paypal',
                'payment_type' => 'json',
                'amount' => $_POST['amount'],
                'success_url' => $url.'guthaben/aufladen/erfolgreich',
                'failure_url' => $url.'guthaben/aufladen',
            );

            $headers = array();
            $headers[] = "X-Api-Key: ".$boltlayerAPIKey;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://boltlayer.com/api/v1/payment/create");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $output = curl_exec($ch);

            curl_close ($ch);

            $response = json_decode($output);
            var_dump($response);

            $tid = $response->data->tid;

            $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'PENDING',:amount,'Guthabenaufladung mit paypal',:tid)");
            $SQL->execute(array(":user_id" => $_SESSION['id'], ":gateway" => 'paypal', ":amount" => $_POST['amount'], ":tid" => $tid));

            header('Location: '.$response->data->paymentlink);

        } else {
            echo sendError('Bitte gebe einen Betrag ein der größer als 3 oder kleiner als '.$max_payment.' ist.');
        }
    }
}

$SQLSelectServers = $odb -> prepare("SELECT * FROM `transactions` WHERE `user_id` = :user_id AND `state` = 'PENDING' AND `gateway` = 'paypal' OR `user_id` = :user_id AND `state` = 'PENDING' AND `gateway` = 'creditcard'");
$SQLSelectServers->execute(array(":user_id" => $_SESSION['id']));
if ($SQLSelectServers->rowCount() != 0) {
    while ($row = $SQLSelectServers -> fetch(PDO::FETCH_ASSOC)){

        $fields = array(
            'checkPayment' => NULL,
            'tid' => $row['tid'],
        );

        $headers = array();
        $headers[] = "X-Api-Key: ".$boltlayerAPIKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://boltlayer.com/api/v1/payment/check");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        curl_close ($ch);

        $response = json_decode($output);

        $status = $response->data->state;

        $SQL = $odb -> prepare("SELECT * FROM `transactions` WHERE `id` = :id");
        $SQL -> execute(array(":id" => $row['id']));
        $paymentInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

        if($status == 'SUCCESS'){

            $SQL = $odb -> prepare("UPDATE `transactions` SET `state` = 'DONE' WHERE `id` = :id");
            $SQL -> execute(array(":id" => $row['id']));

            $user->addMoney($odb,$paymentInfos['amount'],$paymentInfos['user_id']);

            include 'app/mail/mail_templates/amount_added.php';
            sendMail($_SESSION['email'], $_SESSION['username'], $mailContent, $mailSubject, $emailAltBody, '', '');

            echo sendSuccess('Guthaben aufgeladen');

            //TODO
            sendPush($pushoverUserKey,'Neue Guthabenaufladung','Soeben wurden '.$paymentInfos['amount'].'€ von '.$user->getName($odb, $_SESSION['id']).' aufgeladen');


            $SQL = $odb -> prepare("SELECT * FROM `affiliates` WHERE `email` = :email AND `deleted_at` IS NULL;");
            $SQL -> execute(array(":email" => $userInfo['email']));
            if($SQL->rowCount() == 1){
                $SQL = $odb -> prepare("SELECT * FROM `affiliates` WHERE `email` = :email AND `deleted_at` IS NULL;");
                $SQL -> execute(array(":email" => $userInfo['email']));
                $affiliateInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

                $newAffiliateAmount = $affiliateInfos['amount']+$paymentInfos['amount'];
                if($newAffiliateAmount >= 5){
                    if(is_null($affiliateInfos['deleted_at'])) {
                        $SQL = $odb->prepare("UPDATE `affiliates` SET `amount` = :amount AND `deleted_at` = :deleted_at WHERE `email` = :email");
                        $SQL->execute(array(":amount" => $newAffiliateAmount, ":deleted_at" => $dateTimeNow, ":email" => $userInfo['email']));

                        $user->addBonusMoney($odb, '1.00', $user->getUserIDFromAffiliateID($odb, $affiliateInfos['affiliate_id']));

                        $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'DONE',:amount,'Affiliate Zahlung',:tid)");
                        $SQL->execute(array(":user_id" => $user->getUserIDFromAffiliateID($odb, $affiliateInfos['affiliate_id']), ":gateway" => 'intern', ":amount" => '1.00', ":tid" => 'Affiliate Payment'));
                    }
                } else {
                    $SQL = $odb -> prepare("UPDATE `affiliates` SET `amount` = :amount WHERE `email` = :email");
                    $SQL -> execute(array(":amount" => $newAffiliateAmount, ":email" => $userInfo['email']));
                }
            }

        }

    }
}