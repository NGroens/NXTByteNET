<?php
if (isset($_POST["register"])) {

    $erro_msg = "";
    if (empty($_POST['user_name'])) {
        $erro_msg = "Bitte gebe einen Benutzernamen an.";
    } elseif (empty($_POST['user_password']) || empty($_POST['user_password_confirm'])) {
        $erro_msg = "Bitte gebe ein Passwort an.";
    } elseif ($_POST['user_password'] !== $_POST['user_password_confirm']) {
        $erro_msg = "Die angegebenen Passwörter stimmen nicht überein.";
    } elseif (strlen($_POST['user_password']) < 6) {
        $erro_msg = "Das angegebene Passwort muss aus Sicherheitsgründen länger als 6 Zeichen sein.";
    } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
        $erro_msg = "Dein Benutzername muss zwichen 2 und 64 Zeichen lang sein.";
    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
        $erro_msg = "Dein Benutzername darf keine Sonderzeichen enthalten";
    } elseif (empty($_POST['user_email'])) {
        $erro_msg = "Die Email darf keine Sonderzeichen enthalten";
    } elseif (strlen($_POST['user_email']) > 64) {
        $erro_msg = "Die Email darf nicht länger als 64 Zeichen sein";
    } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
        $erro_msg = "Die angegebene Email ist keine Email";
    } elseif (!empty($_POST['user_name'])
        && strlen($_POST['user_name']) <= 64
        && strlen($_POST['user_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
        && !empty($_POST['user_email'])
        && strlen($_POST['user_email']) <= 64
        && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
        && !empty($_POST['user_password'])
        && !empty($_POST['user_password_confirm'])
        && ($_POST['user_password'] === $_POST['user_password_confirm'])
    ) {

        if ($serverSettings['register'] == 1) {
            $user_name = $_POST['user_name'];
            $user_email = $_POST['user_email'];
            $user_password = $_POST['user_password'];

            $cost = 10;
            $hash = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => $cost]);

            $checkUsername = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username OR `email` = :email");
            $checkUsername->execute(array(':username' => $user_name, ':email' => $user_email));
            $countUsername = $checkUsername->fetchColumn(0);

            if (!($countUsername == 0)) {
                $erro_msg = "Ein Account mit diesem Namen oder E-Mail existiert bereits.";
            } else {

                if(isset($_COOKIE["usercheck"])){ $erro_msg = "Du hast bereits einen Account."; }else{

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

                    $insertUser = $odb->prepare("INSERT INTO `users`(`username`, `email`, `password`, `role`, `status`, `flagged`, `amount`, `verify_code`) VALUES (:username,:email,:password,:role,:status,:flagged,:amount,:verify_code)");
                    $insertUser->execute(array(":username" => $user_name, ":email" => $user_email, ":password" => $hash, ":role" => 'USER', ":status" => 'PENDING', ":flagged" => 'NO', ":amount" => '0.00', ":verify_code" => $verify_code));
                    setcookie("usercheck", $user_name, time() + (10 * 365 * 24 * 60 * 60));

                    //$insertUser = "1";

                    if ($insertUser) {

                        if(isset($_COOKIE['affiliate_id']) && !empty($_COOKIE['affiliate_id'])){
                            $SQL = $odb->prepare("INSERT INTO `affiliates`(`email`, `affiliate_id`, `amount`) VALUES (:email,:affiliate_id,:amount)");
                            $SQL->execute(array(":email" => $user_email, ":affiliate_id" => $_COOKIE['affiliate_id'], ":amount" => '0.00'));
                        }

                        if(!($serverSettings['start_amount'] == NULL)){
                            $SQL = $odb->prepare("UPDATE `users` SET `bonus_amount` = :bonus_amount WHERE `username` = :username");
                            $SQL->execute(array(":bonus_amount" => $serverSettings['start_amount'], ":username" => $user_name));
                        }

                        include 'app/mail/mail_templates/activate_account.php';

                        sendMail($user_email,$user_name,$mailContent,$mailSubject,$emailAltBody,'','');

                        echo sendSuccess('Erfolgreich','Bitte bestätige nun deine E-Mail');
                        //header('Location: '.$url.'login');
                        //header('refresh:5;url='.$url.'login');

                    } else {
                        $erro_msg = "Could not create user (Bitte melden Sie dies einem Administrator)";
                    }
                }
            }
        } else {
            $erro_msg = "Aktuell ist die Registration deaktiviert";
        }
    } else {
        $erro_msg = "Ein technisches Problem ist aufgetreten. Bitte versuche es später erneut!";
    }
}