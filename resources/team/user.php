<?php
$currPage = "back_Team";
include 'app/require_once/page_controller.php';

$user_id = $_GET['id'];

if(!($role->isAdmin($odb, $_SESSION['id']))){
    header('Location: '.$url.'logout');
}

if(isset($_POST['giveMoney'])){
    if(isset($_POST['amount']) && !empty($_POST['amount'])){

        $amount = $_POST['amount'];

        if(empty($_POST['desc'])){
            $desc = 'Kein Grund angegeben';
        } else {
            $desc = $_POST['desc'];
        }

        $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'DONE',:amount,:desc,:tid)");
        $SQL->execute(array(":user_id" => $user_id, ":gateway" => 'intern', ":amount" => $_POST['amount'], ":desc" => $desc, ":tid" => 'INTERN - '.$_SESSION['username']));

        $user->addMoney($odb, $_POST['amount'], $user_id);

        echo sendSuccess('Erfolgreich','Guthaben hinzugefügt');

    }
}

if(isset($_POST['removeMoney'])){
    if(isset($_POST['amount']) && !empty($_POST['amount'])){

        $amount = $_POST['amount'];

        if(empty($_POST['desc'])){
            $desc = 'Kein Grund angegeben';
        } else {
            $desc = $_POST['desc'];
        }

        $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'DONE',:amount,:desc,:tid)");
        $SQL->execute(array(":user_id" => $user_id, ":gateway" => 'intern', ":amount" => '-'.$_POST['amount'], ":desc" => $desc, ":tid" => 'INTERN - '.$_SESSION['username']));

        $user->removeMoney($odb, $_POST['amount'], $user_id);

        echo sendSuccess('Erfolgreich','Guthaben abgezogen');

    }
}

?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?> - Benutzerverwaltung von <?= $user->getName($odb, $user_id); ?></h1>
    </div>

    <div class="page-content container-fluid">
        <div class="row">

            <div class="col-md-4">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <h4>Guthaben hinzufügen</h4>

                        <form method="post">
                            <label>Betrag:</label>
                            <input name="amount" class="form-control" value="1.00">
                            <br>
                            <label>Beschreibung</label>
                            <input name="desc" class="form-control">
                            <br>
                            <button type="submit" name="giveMoney" class="btn btn-primary" style="float: right;">Hinzufügen</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <h4>Guthaben abziehen</h4>

                        <form method="post">
                            <label>Betrag:</label>
                            <input name="amount" class="form-control" value="1.00">
                            <br>
                            <label>Beschreibung:</label>
                            <input name="desc" class="form-control">
                            <br>
                            <button type="submit" name="removeMoney" class="btn btn-primary" style="float: right;">Entfernen</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <?php

                        if(isset($_POST['changeState'])){
                            if($_POST['status'] == 'PENDING'){

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

                                include 'app/mail/mail_templates/activate_account.php';
                                sendMail($user->getEmail($odb, $user_id),$user->getName($odb, $user_id),$mailContent,$mailSubject,$emailAltBody,'','');

                                $SQL = $odb->prepare("UPDATE `users` SET `verify_code` = :verify_code WHERE `id` = :id");
                                $SQL->execute(array(":verify_code" => $verify_code, ":id" => $user_id));

                            }

                            $SQL = $odb->prepare("UPDATE `users` SET `status` = :status WHERE `id` = :id");
                            $SQL->execute(array(":status" => $_POST['status'], ":id" => $user_id));

                            echo sendSuccess('Der Status wurde geändert');

                        }

                        ?>

                        <h4>Benutzer Status ändern</h4>

                        <form method="post">
                            <label>Status:</label>
                            <select class="form-control" name="status">
                                <option value="PENDING" <?php if($user->getState($odb, $user_id) == 'PENDING'){ echo 'selected'; } ?>>Unbestätigt</option>
                                <option value="ACTIVE" <?php if($user->getState($odb, $user_id) == 'ACTIVE'){ echo 'selected'; } ?>>Aktiv</option>
                                <option value="BANNED" <?php if($user->getState($odb, $user_id) == 'BANNED'){ echo 'selected'; } ?>>Gesperrt</option>
                            </select>
                            <br>
                            <button type="submit" name="changeState" class="btn btn-primary" style="float: right;">Ändern</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>