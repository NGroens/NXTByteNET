<?php
$currPage = "back_Team";
include 'app/require_once/page_controller.php';

$user_id = $_GET['id'];

if(!($role->isAdmin($odb, $_SESSION['id']))){
    header('Location: '.$url.'logout');
}

function generateChar1($length = 4) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateChar2($length = 4) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateChar3($length = 4) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$code = generateChar1().'-'.generateChar2().'-'.generateChar3();

if(isset($_POST['setAmount'])){
    if(isset($_POST['amount']) && !empty($_POST['amount'])){
        $amount = $_POST['amount'];
    } else {
        $amount = NULL;
    }

    $SQL = $odb->prepare("UPDATE `settings` SET `start_amount` = :start_amount");
    $SQL->execute(array(":start_amount" => $amount));

    echo sendSuccess('Startguthaben bearbeitet');
    header('refresh:3;url='.$url.'team/settings');
}

if(isset($_POST['createCoupon'])){
    if(isset($_POST['amount']) && !empty($_POST['amount'])){
        if(isset($_POST['code']) && !empty($_POST['code'])){

            $SQL = $odb->prepare("INSERT INTO `bonus_codes`(`code`, `amount`) VALUES (:code,:amount)");
            $SQL->execute(array(":code" => $_POST['code'], ":amount" => $_POST['amount']));

            echo sendSuccess('Code erstellt');
            header('refresh:3;url='.$url.'team/settings/rabatt');
        }
    }
}

?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <ul class="nav-quick nav-quick-bordered row">
            <li class="nav-item col-md-3">
                <a class="nav-link" href="<?php echo $url; ?>team/settings" <?php if(empty($_GET['menu'])){ echo 'style="color: #1e88e5;"'; } ?>>
                    <i class="icon wb-settings" aria-hidden="true"></i>
                    Allgemeine Einstellungen
                </a>
            </li>
            <li class="nav-item col-md-3">
                <a class="nav-link" href="<?php echo $url; ?>team/settings/rabatt" <?php if($_GET['menu'] == 'rabatt'){ echo 'style="color: #1e88e5;"'; } ?>>
                    <i class="icon fas fa-ticket-alt" aria-hidden="true"></i>
                    Gutschein / Rabbatt
                </a>
            </li>
            <li class="nav-item col-md-3">
                <a class="nav-link" href="<?php echo $url; ?>team/settings/news" <?php if($_GET['menu'] == 'news'){ echo 'style="color: #1e88e5;"'; } ?>>
                    <i class="icon fa-newspaper" aria-hidden="true"></i>
                    News
                </a>
            </li>
            <li class="nav-item col-md-3">
                <a class="nav-link" href="<?php echo $url; ?>team/settings/radiolist" <?php if($_GET['menu'] == 'radiolist'){ echo 'style="color: #1e88e5;"'; } ?>>
                    <i class="icon fas fa-broadcast-tower" aria-hidden="true"></i>
                    Webradiolist
                </a>
            </li>
        </ul>

        <div class="row">

            <?php if(empty($_GET['menu'])){ ?>
                <div class="col-md-4">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">

                            <?php

                            if(isset($_POST['updateLoginSettings'])){

                                $SQL = $odb -> prepare("UPDATE `settings` SET `login` = :login, `register` = :register");
                                $SQL->execute(array(":login" => $_POST['login'], ":register" => $_POST['register']));

                                echo sendSuccess('Die einstellungen wurden gespeichert');
                                header('refresh:3;url='.$url.'team/settings');
                            }

                            ?>

                            <h4>Login / Register bearbeiten</h4>
                            <form method="post">
                                <label>Login:</label>
                                <select class="form-control" name="login">
                                    <option value="1" <?php if($serverSettings['login'] == 1){ echo 'selected'; } ?>>Aktiviert</option>
                                    <option value="0" <?php if($serverSettings['login'] == 0){ echo 'selected'; } ?>>Deaktiviert</option>
                                </select>
                                <br>
                                <label>Register:</label>
                                <select class="form-control" name="register">
                                    <option value="1" <?php if($serverSettings['register'] == 1){ echo 'selected'; } ?>>Aktiviert</option>
                                    <option value="0" <?php if($serverSettings['register'] == 0){ echo 'selected'; } ?>>Deaktiviert</option>
                                </select>
                                <br>
                                <button type="submit" name="updateLoginSettings" class="btn btn-primary" style="float: right;">Speichern</button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">

                            <h4>Startguthaben bearbeiten</h4>
                            <form method="post">
                                <label>Betrag:</label>
                                <input name="amount" class="form-control" value="<?php echo $serverSettings['start_amount']; ?>">
                                <br>
                                <button type="submit" name="setAmount" class="btn btn-primary" style="float: right;">Speichern</button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">

                            <?php

                            if(isset($_POST['updateProductPrices'])){

                                $SQL = $odb -> prepare("UPDATE `product_prices` SET `price` = :price WHERE `product_name` = 'TEAMSPEAK'");
                                $SQL->execute(array(":price" => $_POST['teamspeak']));

                                $SQL = $odb -> prepare("UPDATE `product_prices` SET `price` = :price WHERE `product_name` = 'VOICEBOT'");
                                $SQL->execute(array(":price" => $_POST['musikbot']));

                                echo sendSuccess('Die einstellungen wurden gespeichert');
                                header('refresh:3;url='.$url.'team/settings');
                            }

                            ?>

                            <h4>Produktpreise bearbeiten</h4>
                            <form method="post">
                                <label>Teamspeak:</label>
                                <input name="teamspeak" class="form-control" value="<?= $site->getPriceFromProduct($odb, 'TEAMSPEAK'); ?>">
                                <br>
                                <label>MusikBot:</label>
                                <input name="musikbot" class="form-control" value="<?= $site->getPriceFromProduct($odb, 'VOICEBOT'); ?>">
                                <br>
                                <button type="submit" name="updateProductPrices" class="btn btn-primary" style="float: right;">Speichern</button>
                            </form>

                        </div>
                    </div>
                </div>
            <?php } elseif($_GET['menu'] == 'rabatt'){ ?>
                <div class="col-md-4">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">

                            <h4>Gutschein erstellen</h4>
                            <form method="post">
                                <label>Betrag:</label>
                                <input name="amount" class="form-control" value="<?php echo $serverSettings['start_amount']; ?>">
                                <br>
                                <input name="code" class="form-control" value="<?php echo $code; ?>">
                                <br>
                                <button type="submit" name="createCoupon" class="btn btn-primary" style="float: right;">Erstellen</button>
                            </form>

                        </div>
                    </div>
                </div>

            <?php } elseif($_GET['menu'] == 'news'){?>
                <?php

                if(isset($_POST['createNews'])){
                    $errors = null;

                    if(empty($_POST['icon'])){
                        $errors = 'Bitte gebe ein Icon an';
                    }

                    if(empty($_POST['message'])){
                        $errors = 'Bitte gebe eine Nachricht an';
                    }

                    if(empty($errors)){

                        $SQL = $odb -> prepare("INSERT INTO `news`(`icon`, `message`) VALUES (:icon, :message)");
                        $SQL->execute(array(":icon" => $_POST['icon'], ":message" => $_POST['message']));
                        header('refresh:3;url='.$url.'team/settings/news');
                        echo sendSuccess('News wurden erstellt');
                    } else {
                        echo sendError($errors);
                    }
                }

                ?>
                <div class="col-md-6">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">
                            <h4>News schreiben</h4>

                            <form method="post">
                                <label>Icon:</label>
                                <input name="icon" class="form-control">
                                <br>
                                <label>Nachricht:</label>
                                <textarea class="form-control" name="message"></textarea>
                                <br>
                                <button type="submit" name="createNews" class="btn btn-primary" style="float: right;">Erstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } elseif($_GET['menu'] == 'radiolist'){?>
                <div class="col-md-6">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">

                            <?php

                            if(isset($_POST['createRadio'])){
                                $errors = null;

                                if(empty($_POST['name'])){
                                    $errors = 'Bitte gebe einen Namen an';
                                }

                                if(empty($_POST['url'])){
                                    $errors = 'Bitte gebe einen Stream Link an';
                                }

                                if(empty($_POST['user_id'])){
                                    $user_id = null;
                                } else {
                                    $user_id = $_POST['user_id'];
                                }

                                if(empty($errors)){

                                    $SQL = $odb->prepare("INSERT INTO `radiobot_webradio_list`(`user_id`, `name`, `url`) VALUES (:user_id,:name,:url)");
                                    $SQL->execute(array(":user_id" => $user_id, ":name" => $_POST['name'], ":url" => $_POST['url']));
                                    header('refresh:3;url='.$url.'team/settings/radiolist');
                                    echo sendSuccess('Stream wurde hinzugeügt');
                                } else {
                                    echo sendError($errors);
                                }

                            }

                            ?>

                            <h4>Stream hinzufügen</h4>
                            <form method="post">
                                <label>Name:</label>
                                <input name="name" class="form-control">
                                <br>
                                <label>Stream Link:</label>
                                <input name="url" class="form-control">
                                <br>
                                <label>User-ID:</label>
                                <input name="user_id" class="form-control">
                                <br>
                                <button type="submit" name="createRadio" class="btn btn-primary" style="float: right;">Erstellen</button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">

                            <?php

                            if(isset($_POST['deleteStream'])){
                                if(!empty($_POST['item_id'])){

                                    $SQL = $odb->prepare("DELETE FROM `radiobot_webradio_list` WHERE `id` = :id");
                                    $SQL->execute(array(":id" => $_POST['item_id']));
                                    header('refresh:3;url='.$url.'team/settings/radiolist');
                                    echo sendSuccess('Der Streamlink wurde entfernt');

                                }
                            }

                            ?>

                            <table class="table table-hover table-striped w-full" id="ticket_table">
                                <thead>
                                <tr>
                                    <th scope="col">Stream Name</th>
                                    <th scope="col">Stream Link</th>
                                    <th scope="col">User-ID</th>
                                    <th scope="col"> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $SQLSelectServers = $odb->prepare("SELECT * FROM `radiobot_webradio_list`");
                                $SQLSelectServers->execute();
                                if ($SQLSelectServers->rowCount() != 0) {
                                    while ($row = $SQLSelectServers -> fetch(PDO::FETCH_ASSOC)){ ?>
                                        <tr>
                                            <th scope="row"><?php echo $row['name']; ?></th>
                                            <td>
                                                <?php if(empty($row['user_id'])){ echo $row['url']; } else { echo 'Versteckt'; } ?>
                                            </td>
                                            <td>
                                                <?php echo $row['user_id']; ?>
                                            </td>
                                            <td>
                                                <form method="post">
                                                    <input name="item_id" value="<?php echo $row['id']; ?>" hidden="hidden">
                                                    <button class="btn btn-danger btn-sm" type="submit" name="deleteStream">X</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>