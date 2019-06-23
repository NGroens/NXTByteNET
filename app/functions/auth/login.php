<?php
if (isset($_POST["login"])) {
    $erro_msg = "";

    if (empty($_POST['user_name'])) {
        $erro_msg = "Bitte gebe einen Benutzernamen an!";
    } elseif (empty($_POST['user_password'])) {
        $erro_msg = "Bitte gebe ein Passwort an!";
    } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
        $erro_msg = "Der Benutzername muss zwichen 2 und 64 Zeichen lang sein!";
    } elseif (empty($_POST['user_name']) || empty($_POST['user_password'])){

    } elseif (preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name']) || filter_var($_POST['user_name'], FILTER_VALIDATE_EMAIL)) {

        if ($serverSettings['login'] == 1){

            $user_name = $_POST['user_name'];
            $user_password = $_POST['user_password'];

            $SQLCheckLogin = $odb->prepare("SELECT * FROM `users` WHERE `username` = :user_name OR `email` = :user_mail");
            $SQLCheckLogin->execute(array(':user_name' => $user_name, ':user_mail' => $user_name));
            $notLoggedUserInfo = $SQLCheckLogin->fetch(PDO::FETCH_ASSOC);

            if ($SQLCheckLogin->rowCount() == 1) {

                $loginState = FALSE;

                if(password_verify($user_password, $notLoggedUserInfo['password'])) {
                    $loginState = TRUE;
                } else {
                    $loginState = FALSE;
                }

                if($loginState == TRUE){

                    $SQLGetInfo = $odb->prepare("SELECT * FROM `users` WHERE `username` = :user_name OR `email` = :user_mail");
                    $SQLGetInfo->execute(array(':user_name' => $user_name, ':user_mail' => $user_name));
                    $userInfo = $SQLGetInfo->fetch(PDO::FETCH_ASSOC);

                    if ($userInfo['status'] == 'PENDING') {
                        $erro_msg = "Du hast deine E-Mail noch nicht bestätigt!";
                    } elseif ($userInfo['status'] == 'BANNED') {
                        $erro_msg = "Dein Account ist gesperrt!";
                    } elseif ($userInfo['status'] == 'ACTIVE') {

                        $_SESSION['username'] = $userInfo['username'];
                        $_SESSION['id'] = $userInfo['id'];
                        $_SESSION['email'] = $userInfo['email'];

                        header('Location: ' . $url . 'dashboard');

                    } else {
                        $erro_msg = "Unable to get Account State (Bitte melden Sie dies einem Administrator)!";
                    }

                } else {
                    $erro_msg = "Benutzername oder Passwort ist falsch!";
                }

            } else {
                $erro_msg = "Es konnte kein Benutzer mit diesem Namen gefunden werden!";
            }

        } else {
            $erro_msg = "Aktuell ist der Login deaktiviert!";
        }
    } else {
        $erro_msg = "Bitte geben Sie einen gültigen Benutzernamen / E-Mail an!";
    }
}