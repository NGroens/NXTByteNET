<?php
$currPage = "back_Mein Account";
include 'app/require_once/page_controller.php';
?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?> | KD-Nr: <?= $_SESSION['id']; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <?php

        include 'app/functions/profile/settings.php';

        if(isset($_POST['changePasswd'])){
            if(isset($_POST['old_passwd']) && !empty($_POST['old_passwd'])){
                if(isset($_POST['new_passwd']) && !empty($_POST['new_passwd'])){
                    if(isset($_POST['new_passwd_repeat']) && !empty($_POST['new_passwd_repeat'])){

                        $SQLCheckLogin = $odb->prepare("SELECT * FROM `users` WHERE `username` = :user_name OR `email` = :user_mail");
                        $SQLCheckLogin->execute(array(':user_name' => $_SESSION['username'], ':user_mail' => $_SESSION['email']));
                        $notLoggedUserInfo = $SQLCheckLogin->fetch(PDO::FETCH_ASSOC);

                        $loginState = FALSE;

                        if(password_verify($_POST['old_passwd'], $notLoggedUserInfo['password'])) {
                            $loginState = TRUE;
                        } else {
                            $loginState = FALSE;
                        }

                        if($loginState == TRUE){

                            if($_POST['new_passwd'] == $_POST['new_passwd_repeat']){

                                $cost = 10;
                                $hash = password_hash($_POST['new_passwd'], PASSWORD_BCRYPT, ['cost' => $cost]);

                                $SQL = $odb->prepare("UPDATE `users` SET `password` = :password WHERE `id` = :id");
                                $SQL->execute(array(':password' => $hash, ':id' => $_SESSION['id']));

                                echo sendSuccess('Dein Passwort wurde geändert');

                                include 'app/mail/mail_templates/password_changed.php';
                                sendMail($_SESSION['email'], $_SESSION['username'], $mailContent, $mailSubject, $emailAltBody, '', '');

                            } else {
                                echo sendError('Die eingegebenen Passwörter stimmen nicht überein');
                            }

                        } else {
                            echo sendError('Dein aktuelles Passwort stimmt nicht');
                        }

                    }
                }
            }
        }

        if(isset($_POST['createAffiliateID'])){
            if(isset($_POST['affiliate_id']) && !empty($_POST['affiliate_id'])){
                if(is_null($userInfo['affiliate_id'])){
                    if(ctype_alnum($_POST['affiliate_id'])){

                        $SQL = $odb->prepare("UPDATE `users` SET `affiliate_id` = :affiliate_id WHERE `id` = :id");
                        $SQL->execute(array(':affiliate_id' => $_POST['affiliate_id'], ':id' => $_SESSION['id']));

                        echo sendSuccess('Dein Affiliate Link wurde erstellt');
                        header('refresh:3;url='.$url.'profil');
                    } else {
                        echo sendError('Dein Affiliate Link enthält ungültige Zeichen.');
                    }
                } else {
                    echo sendError('Du hast bereits einen Affiliate Link.');
                }
            } else {
                echo sendError('Bitte gebe einen Affiliate Link an.');
            }
        }

        $SQL = $odb->prepare("SELECT * FROM `affiliate_clicks` WHERE `affiliate_id` = :affiliate_id");
        $SQL->execute(array(':affiliate_id' => $userInfo['affiliate_id']));
        $affliate_clicks = $SQL->rowCount();

        $SQL = $odb->prepare("SELECT * FROM `affiliates` WHERE `affiliate_id` = :affiliate_id");
        $SQL->execute(array(':affiliate_id' => $userInfo['affiliate_id']));
        $affliate_registers = $SQL->rowCount();

        ?>

        <div class="row" data-plugin="matchHeight" data-by-row="true">

            <div class="col-md-6">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <form method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Vorname:</label>
                                    <input name="vorname" class="form-control" value="<?php echo $userInfo['vorname']; ?>" type="text">
                                </div>

                                <div class="col-md-6">
                                    <label>Nachname:</label>
                                    <input name="nachname" class="form-control" value="<?php echo $userInfo['nachname']; ?>" type="text">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Straße:</label>
                                    <input name="strasse" class="form-control" value="<?php echo $userInfo['strasse']; ?>" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label>Postleitzahl:</label>
                                    <input name="postleitzahl" class="form-control" value="<?php echo $userInfo['postleitzahl']; ?>" type="number">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Stadt:</label>
                                    <input name="stadt" class="form-control" value="<?php echo $userInfo['stadt']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label>Land:</label>
                                    <input name="land" class="form-control" value="<?php echo $userInfo['land']; ?>">
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="safeProfile" style="float: right;" class="btn btn-primary">Speichern</button>
                        </form>

                    </div>
                </div>

                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <h3 class="text-center">Wie funktioniert das Affiliate System?</h3>
                        <br>
                        Schicke deinen eigenen Affiliate Link an Freunde oder Familie und erhalte nach jeder Registrierung die einen Mindestbetrag von 5.00 Euro auflädt 1.00 Euro geschenkt.

                        <br>
                        <br>
                        <hr>

                        <div id="productOptionsData" class="text-center">
                            <div class="row no-space">

                                <div class="col-md-4">
                                    <div class="counter">
                                        <div class="counter-label">Geworbene Kunden</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related green-600">+</span>
                                            <span class="counter-number"><?php echo $affliate_registers; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="counter">
                                        <div class="counter-label">Guthaben erhalten</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related green-600">+</span>
                                            <span class="counter-number"><?php echo number_format($affliate_registers * 1, 2); ?>€</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="counter">
                                        <div class="counter-label">Klicks auf deinen Link</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related green-600">+</span>
                                            <span class="counter-number"><?php echo $affliate_clicks; ?></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>
                        <br>

                        <?php if(is_null($userInfo['affiliate_id'])){ ?>
                            <form method="post">
                                <label>Affiliate Link erstellen <span style="color: red;">*</span></label>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $url; ?>a/</span>
                                    </div>
                                    <input type="text" name="affiliate_id" maxlength="30" class="form-control" placeholder="Dein Affiliate Link">
                                </div>

                                <br>
                                <button type="submit" name="createAffiliateID" style="float: right;" class="btn btn-primary">Erstellen</button>
                            </form>

                            <br>
                            <small><span style="color: red;">*</span> Hinweis: Der Affiliate Link kann nicht mehr geändert werden.</small>
                        <?php } else { ?>
                            <h4 class="text-center">Dein Affiliate Link lautet:</h4>
                            <input class="form-control" disabled value="<?php echo $url; ?>a/<?php echo $userInfo['affiliate_id']; ?>">
                        <?php } ?>


                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <p>Hier kannst du einstellen welche E-Mails du bekommst und welche nicht</p>

                        <form method="post">

                            <label for="order"><input type="checkbox" <?php if($userInfo['msg_order'] == 1){ echo 'checked'; } ?> name="order" id="order"> Bestellung</label><br>
                            <label for="money"><input type="checkbox" <?php if($userInfo['msg_money'] == 1){ echo 'checked'; } ?> name="money" id="money"> Guthaben aufladung</label><br>
                            <label for="support"><input type="checkbox" <?php if($userInfo['msg_support'] == 1){ echo 'checked'; } ?> name="support" id="support"> Support</label>

                            <br>
                            <button type="submit" name="safeEmail" style="float: right;" class="btn btn-primary">Speichern</button>
                        </form>

                    </div>
                </div>

                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <form method="post">

                            <label>Aktuelles Passwort</label>
                            <input name="old_passwd" class="form-control" type="password" required="required">
                            <br>
                            <label>Neues Passwort</label>
                            <input name="new_passwd" class="form-control" type="password" required="required">
                            <br>
                            <label>Neues Passwort wiederholen</label>
                            <input name="new_passwd_repeat" class="form-control" type="password" required="required">

                            <br>
                            <button type="submit" name="changePasswd" style="float: right;" class="btn btn-primary">Ändern</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>