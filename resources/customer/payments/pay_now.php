<?php
$currPage = "back_Guthaben";
include 'app/require_once/page_controller.php';

if($_GET['payment'] == 'done'){
    echo sendSuccess('Zahlung erfolgreich.');
}

?>
<script src="https://js.stripe.com/v3/"></script>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <?php

        include 'app/functions/payment/stripe/manage_payment.php';

        $psc = false;
        $paypal = false;
        $creditcard = false;

        $SQL = $odb->prepare("SELECT * FROM `topup_actions` WHERE `expire_at` IS NOT NULL");
        $SQL->execute();
        if ($SQL->rowCount() != 0) {
            while ($row = $SQL->fetch(PDO::FETCH_ASSOC)) {

                if($row['method'] == 'PAYSAFECARD'){
                    $psc = true;
                    $psc_date = $row['expire_at'];
                    $psc_percent = explode('.', $row['percent']);
                    $psc_percent = $psc_percent[1];
                }

                if($row['method'] == 'PAYPAL'){
                    $paypal = true;
                    $paypal_date = $row['expire_at'];
                    $paypal_percent = explode('.', $row['percent']);
                    $paypal_percent = $paypal_percent[1];
                }

                if($row['method'] == 'CREDITCARD') {
                    $creditcard = true;
                    $creditcard_date = $row['expire_at'];
                    $creditcard_percent = explode('.', $row['percent']);
                    $creditcard_percent = $creditcard_percent[1];
                }

            }
        }

        if($psc && $paypal && $creditcard){
            $message = ('<center>Lade bis zum '.$site->formatDateWithoutTime($psc_date).' Guthaben auf und wir schenken dir '.$psc_percent.'% Guthaben.</center>');
        } elseif($psc && $paypal){
            $message = ('<center>Lade mit paysafecard oder Paypal bis zum '.$site->formatDateWithoutTime($psc_date).' Guthaben auf und wir schenken dir '.$psc_percent.'% Guthaben.</center>');
        } elseif($psc && $creditcard){
            $message = ('<center>Lade mit paysafecard oder Kreditkarte bis zum '.$site->formatDateWithoutTime($psc_date).' Guthaben auf und wir schenken dir '.$psc_percent.'% Guthaben.</center>');
        } elseif($paypal && $creditcard){
            $message = ('<center>Lade mit PayPal oder Kreditkarte bis zum '.$site->formatDateWithoutTime($paypal_date).' Guthaben auf und wir schenken dir '.$paypal_percent.'% Guthaben.</center>');
        } elseif($paypal){
            $message = ('<center>Lade mit PayPal bis zum '.$site->formatDateWithoutTime($paypal_date).' Guthaben auf und wir schenken dir '.$paypal_percent.'% Guthaben.</center>');
        } elseif($psc){
            $message = ('<center>Lade mit paysafecard bis zum '.$site->formatDateWithoutTime($psc_date).' Guthaben auf und wir schenken dir '.$psc_percent.'% Guthaben.</center>');
        } elseif($creditcard){
            $message = ('<center>Lade mit Kreditkarte bis zum '.$site->formatDateWithoutTime($creditcard_date).' Guthaben auf und wir schenken dir '.$creditcard_percent.'% Guthaben.</center>');
        } else {
            $message = null;
        }

        if(!empty($message)){
            echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
        }

        ?>

        <div class="row">

            <div class="col-md-6">

                <?php

                $min_payment = '1';
                $max_payment = '300';

                include 'app/functions/payment/boltapi/paysafecard/manage_payment.php';
                //include 'app/functions/payment/boltapi/creditcard/manage_payment.php';

                if($_POST['payment_method'] == 'PAYPAL'){
                    if($_POST['amount'] >= $min_payment && $_POST['amount'] <= $max_payment && is_numeric($_POST['amount'])) {
                        include 'app/functions/payment/paypal/manage_payment.php';
                    } else {
                        echo sendError('Bitte gebe einen Betrag ein der größer als '.$min_payment.' oder kleiner als '.$max_payment.' ist.');
                    }
                }

                ?>

                <div class="card">
                    <div class="card-body">

                        <h4 class="text-center">Guthaben aufladen</h4>

                        <form method="post">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="feature-box">
                                    <input type="radio" name="payment_method" value="PAYSAFECARD" id="paysafecard" checked> <label for="paysafecard"><img src="<?php echo $picUrl; ?>payments/paysafecard.png" style="width: auto;max-height: 50px;margin-right: 25px;margin-left: 5px;"></label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="feature-box">
                                    <input type="radio" name="payment_method" value="PAYPAL" id="paypal"> <label for="paypal"><img src="<?php echo $picUrl; ?>payments/paypal.png" style="width: auto;max-height: 40px;margin-right: 25px;margin-left: 5px;"></label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="feature-box">
                                    <input type="radio" name="payment_method" value="CREDITCARD" id="creditcard"> <label for="creditcard"><img src="<?php echo $picUrl; ?>payments/creditcard.png" style="width: auto;max-height: 50px;margin-right: 25px;margin-left: 5px;"></label>
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <center>Betrag:</center>

                                <div class="input-group input-group-merge mb-3">
                                    <input type="text" class="form-control form-control-prepended" name="amount" placeholder="1.00">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-euro-sign"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <br>

                        <center>
                            <small>
                                <b>Hinweis:</b><br> Kein Abo. Der Betrag wird nur einmalig fällig, es entstehen keine weiteren Kosten. Keine Kündigung notwendig!
                                Mit dieser Zahlung wird nur das Guthaben des Kundenkontos aufgeladen. Guthaben kann nicht wieder ausgezahlt werden.
                            </small>
                        </center>

                        <br>

                        <button type="submit" name="payNow" class="btn btn-primary btn-block">Guthaben aufladen</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <?php

                if(isset($_POST['sendMoney'])){
                    if(isset($_POST['username']) && !empty($_POST['username']) && !($_POST['username'] == $_SESSION['username'])){
                        if($_POST['amount'] && !empty($_POST['amount'])){

                            $SQL = $odb->prepare("SELECT * FROM `users` WHERE `username` = :username");
                            $SQL->execute(array(":username" => $_POST['username']));
                            if($SQL->rowCount() == 1){

                                if($user->getNormMoney($odb, $_SESSION['id']) >= $_POST['amount']){

                                    function generateVerifyCode($length = 15) {
                                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                        $charactersLength = strlen($characters);
                                        $randomString = '';
                                        for ($i = 0; $i < $length; $i++) {
                                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                                        }
                                        return $randomString;
                                    }

                                    $verify_code = generateVerifyCode();

                                    include 'app/mail/mail_templates/confirm_money.php';

                                    sendMail($userInfo['email'],$userInfo['username'],$mailContent,$mailSubject,$emailAltBody,'','');

                                    $SQL = $odb->prepare("INSERT INTO `transfer_money`(`sender_name`, `receiver_name`, `amount`,`key`) VALUES (:sender_name,:receiver_name,:amount,:key)");
                                    $SQL->execute(array(":sender_name" => $userInfo['username'], ":receiver_name" => $_POST['username'], ":amount" => $_POST['amount'], ":key" => $verify_code));

                                    $message = ('Wir haben dir eine Mail gesendet bitte bestätige diese um das Geld zu senden.');

                                } else {
                                    echo sendError('Du hast leider nicht genügend Guthaben');
                                }

                            } else {
                                echo sendError('Diesen Benutzer gibt es nicht.');
                            }

                        }
                    } else {
                        echo sendError('Du kannst dir nicht selber Guthaben spenden.');
                    }
                }

                if(isset($_COOKIE['confirm_money'])){
                    echo sendSuccess('Die Spende war erfolgreich');
                }

                if(isset($_COOKIE['confirm_money_2'])){
                    echo sendError('Die Spende konnte nicht bestätigt werden');
                }

                ?>

                <div class="card">
                    <div class="card-body">

                        <h4 class="text-center">Guthaben Spenden</h4>

                        <center>
                            Du hast aktuell <b><?php echo $user->getNormMoney($odb, $_SESSION['id']); ?>€</b> Guthaben welches du versenden kannst.
                        </center>

                        <br>

                        <form method="post">
                            <label>Benutzername:</label>
                            <input name="username" class="form-control" placeholder="Benutzername" required>
                            <br>
                            <label>Betrag:</label>
                            <input name="amount" class="form-control" placeholder="1.00" required>
                            <br>

                            <div style="margin-bottom: 32px;"></div>

                            <button type="submit" name="sendMoney" class="btn btn-block btn-primary">Spenden</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php

                if(isset($_POST['checkCode'])){
                    if(isset($_POST['code']) && !empty($_POST['code'])){

                        $SQL = $odb->prepare("SELECT * FROM `bonus_codes` WHERE `code` = :code");
                        $SQL->execute(array(":code" => $_POST['code']));
                        if($SQL->rowCount() == 1){

                            $SQL = $odb->prepare("SELECT * FROM `bonus_codes` WHERE `code` = :code");
                            $SQL->execute(array(":code" => $_POST['code']));
                            $codeInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

                            if($codeInfos['deleted_at'] == NULL){
                                $user->addBonusMoney($odb,$codeInfos['amount'],$_SESSION['id']);
                                $user->addTransaction($odb, $_SESSION['id'],'intern','DONE',$codeInfos['amount'],'Gutscheincode',$_POST['code']);
                                $SQL = $odb->prepare("UPDATE `bonus_codes` SET `deleted_at` = :deleted_at WHERE `code` = :code");
                                $SQL->execute(array(":code" => $_POST['code'], ":deleted_at" => $dateTimeNow));
                                echo sendSuccess('Gutschein eingelöst');
                            } else {
                                echo sendError('Dieser Code wurde bereits eingelöst.');
                            }

                        } else {
                            echo sendError('Diesen Code gibt es nicht');
                        }

                    }
                }

                ?>


                <div class="card">
                    <div class="card-body">

                        <h4 class="text-center">Gutschein einlösen</h4>

                        <form method="post">
                            <label>Code:</label>
                            <input name="code" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                            <br>
                            <button type="submit" name="checkCode" class="btn btn-block btn-primary">Einlösen</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

