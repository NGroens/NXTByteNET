<?php
$currPage = "back_Teamspeak";
include 'app/require_once/page_controller.php';
?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?> #<?= $_GET['id']; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <?php include 'app/functions/services/teamspeak/manage.php'; ?>

        <?php if($suspended){ ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6" style="margin-top: 120px;">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20 text-center">

                            <i class="icon fa-server" style="font-size: 64px; color: red;"></i>

                            <h4>Produkt mit der ID #<?php echo $server_id; ?> ist abgelaufen</h4>
                            <a href="<?php echo $url; ?>teamspeak/<?php echo $server_id; ?>/renew" class="btn btn-primary">Jetzt verlängern</a>

                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>

            <ul class="nav-quick nav-quick-bordered row">
                <li class="nav-item col-md-4 col-4">
                    <a class="nav-link" href="<?php echo $url; ?>teamspeak/<?php echo $server_id; ?>" <?php if(empty($_GET['menu'])){ echo 'style="color: #1e88e5;"'; } ?>>
                        <i class="icon wb-settings" aria-hidden="true"></i>
                        Übersicht
                    </a>
                </li>
                <li class="nav-item col-md-4 col-4">
                    <a class="nav-link" href="<?php echo $url; ?>teamspeak/<?php echo $server_id; ?>/viewer" <?php if($_GET['menu'] == 'viewer'){ echo 'style="color: #1e88e5;"'; } ?>>
                        <i class="icon wb-user" aria-hidden="true"></i>
                        Viewer
                    </a>
                </li>
                <li class="nav-item col-md-4 col-4">
                    <a class="nav-link" href="<?php echo $url; ?>teamspeak/<?php echo $server_id; ?>/tokens" <?php if($_GET['menu'] == 'tokens'){ echo 'style="color: #1e88e5;"'; } ?>>
                        <i class="icon wb-wrench" aria-hidden="true"></i>
                        Tokens
                    </a>
                </li>
            </ul>

            <div class="row">

                <?php if(empty($_GET['menu'])){ ?>
                    <div class="col-md-4">
                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20 text-center">

                                <h4>Server Infos</h4>

                                <table class="table mb-0">
                                    <tbody>
                                    <?php if($serverStatus == 'ONLINE'){ ?>
                                        <tr>
                                            <th class="text-left">IP</th>
                                            <th><?php echo $serverInfos['teamspeak_ip']; ?>:<?php echo $serverInfos['teamspeak_port']; ?> <a href="ts3server://<?php echo $serverInfos['teamspeak_ip']; ?>:<?php echo $serverInfos['teamspeak_port']; ?>" class="btn btn-primary btn-sm">Verbinden</a></th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Status</th>
                                            <th><?php echo $status_msg; ?></th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">User Online</th>
                                            <th><?php echo getClientsOnline($ts3_query, $serverStatus); ?> / <?php echo $serverInfos['slots']; ?></th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">Onlinezeit</th>
                                            <th><?php echo getOnlineTime($ts3_query); ?></th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">Version</th>
                                            <th><?php echo $version['version']; ?> <?php if($_SESSION['username'] == 'RIVEX'){ ?><small>(Build: <?php echo $version['build']; ?>)</small><?php } ?></th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">System</th>
                                            <th><?php echo $version['platform']; ?></th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">Channels</th>
                                            <th><?php echo getChannelCount($ts3_query); ?></th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">Ping</th>
                                            <th><?php echo round($connection_info['connection_ping'], 2); ?>ms</th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">Paketverlust</th>
                                            <th><?php if(round($connection_info['connection_packetloss_total'], 2) == '1'){ echo '0.00'; } else { echo round($connection_info['connection_packetloss_total'], 2); } ?>%</th>
                                        </tr>

                                        <tr>
                                            <th class="text-left">Laufzeit</th>
                                            <th> <span id="countdown_text"> <span id="countdown">Lädt...</span></span> </th>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <th class="text-left">Status</th>
                                            <th>Offline</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">IP</th>
                                            <th><?php echo $serverInfos['teamspeak_ip']; ?>:<?php echo $serverInfos['teamspeak_port']; ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Laufzeit</th>
                                            <th> <span id="countdown_text"> <span id="countdown">Lädt...</span></span> </th>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20 text-center">

                                <h4>Server verwalten</h4>

                                <form method="POST" action="">
                                    <?php if($serverStatus == 'ONLINE'){ ?>
                                        <center>
                                            <button type="button" disabled class="btn btn-block btn-success"><span>Starten</span></button>
                                            <button type="submit" name="sendStop" class="btn btn-block btn-danger"><span>Stoppen</span></button>
                                        </center>
                                    <?php } elseif($serverStatus == 'OFFLINE') { ?>
                                        <center>
                                            <button type="submit" name="sendStart" class="btn btn-block btn-success"><span>Starten</span></button>
                                            <button type="button" disabled class="btn btn-block btn-danger"><span>Stoppen</span></button>
                                        </center>
                                    <?php } ?>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20 text-center">

                                <h4>Server Aktionen</h4>

                                <center>
                                    <a href="<?php echo $url; ?>teamspeak/<?php echo $server_id; ?>/renew" class="btn btn-block btn-primary"><span>Verlängern</span></a>
                                    <a href="<?php echo $url; ?>teamspeak/<?php echo $server_id; ?>/reconfigure" class="btn btn-block btn-warning"><span>Up/Downgrade</span></a>
                                </center>

                            </div>
                        </div>
                    </div>
                <?php } elseif($_GET['menu'] == 'viewer'){ ?>
                    <div class="col-md-12">
                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20 text-center">

                                <h4>Teamspeak Viewer</h4>

                                <?php echo getViewer($ts3_query,$picUrl,$serverStatus); ?>

                            </div>
                        </div>
                    </div>
                <?php } elseif($_GET['menu'] == 'tokens'){?>

                <div class="col-md-12">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20 text-center">

                            <form method="post">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <select name="group" class="form-control">
                                            <?php
                                            if($serverStatus == 'OFFLINE') { echo '<option>Server Offline</option>'; } else {
                                                $groups = getServerGroups($ts3_query, $serverStatus);
                                                foreach ($groups as $group) {
                                                    echo '<option value="' . $group->getId() . '">' . $group . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php if($serverStatus == 'OFFLINE'){ ?>
                                        <div class="col-xs-12 col-md-4">
                                            <input type="text" disabled="disabled" name="description" placeholder="Beschreibung" class="form-control">
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <button type="button" class="btn btn-default" disabled="disabled">Token erstellen</button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-xs-12 col-md-4">
                                            <input type="text" name="description" placeholder="Beschreibung" class="form-control">
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <button type="submit" class="btn btn-default" name="createToken">Token erstellen</button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </form>

                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Token</th>
                                        <th>Gruppe</th>
                                        <th>Beschreibung</th>
                                        <th>Aktionen</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody_tokens">
                                    <form method="post">
                                        <?php
                                        $tokens = listTokens($ts3_query, $serverStatus); if(isset($tokens) && !empty($tokens)){ foreach ($tokens as $token) { ?>
                                            <tr>
                                                <td style="max-width: 200px; word-wrap: break-word;"><?php echo $token['token']; ?></td>
                                                <td><?php echo getGroupName($ts3_query, $token['token_id1'])['name']; ?></td>
                                                <td><?php echo $token['token_description']; ?></td>
                                                <?php if($serverStatus == 'OFFLINE'){ ?>
                                                    <td><button type="button" disabled="disabled" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                                <?php } else { ?>
                                                    <td><button type="submit" name="deleteToken" value="<?php echo $token['token']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                                <?php } ?>
                                            </tr>
                                        <?php }  } ?>
                                    </form>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                <?php } elseif($_GET['menu'] == 'reconfigure'){?>

                    <div class="col-md-3">
                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20 text-center" style="margin-bottom: -10px;">

                                <div class="pricing-list">
                                    <ul class="pricing-features">
                                        <li> Slots: <?= $serverInfos['slots']; ?> </li>
                                        <li><span id="countdown_text"> <span id="countdown">Lädt...</span></span></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <?php

                        if(isset($_POST['reconfigure'])) {
                            $errors = null;

                            if (empty($_POST['slot_count'])) {
                                $errors = 'Bitte wähle eine anzahl an Slots';
                            }

                            if ($_POST['slot_count'] == $serverInfos['slots']) {
                                $errors = 'Bitte wähle eine andere anzahl an Slots';
                            }

                            if ($_POST['slot_count'] < 10) {
                                $errors = 'Bitte wähle einen Betrag der größer ist als 10';
                            }

                            if ($_POST['slot_count'] > 1000) {
                                $errors = 'Bitte wähle einen Betrag der keliner ist als 1000';
                            }

                            if ($site->getDiffInDays($serverInfos['expire_at']) == 0) {
                                $errors = 'Bitte verlängere deinen Server zurerst';
                            }

                            if (empty($errors)) {

                                $this_curr_price = $site->getPriceFromProduct($odb, 'TEAMSPEAK') * $serverInfos['slots'];
                                $this_new_price = $site->getPriceFromProduct($odb, 'TEAMSPEAK') * $_POST['slot_count'];
                                $price = ($this_curr_price - $this_new_price) * $site->getDiffInDays($serverInfos['expire_at']) / 30;

                                if ($price < 0) {
                                    if ($user->getMoney($odb, $_SESSION['id']) >= $price) {
                                        modify($ts3_query, $_POST['slot_count'], $serverInfos['teamspeak_port']);
    //                                    $user->addMoney($odb, $price, $_SESSION['id']);
                                        $price = str_replace('-', '', $price);
                                        $user->removeMoney($odb, $price, $_SESSION['id']);
                                        $order->addOrder($odb, $_SESSION['id'], 'ORDER', '-'.$price, 'Teamspeak upgrade');

                                        $SQL = $odb->prepare("UPDATE `teamspeaks` SET `slots` = :slots WHERE `id` = :service_id");
                                        $SQL->execute(array(":slots" => $_POST['slot_count'], ":service_id" => $server_id));

                                        echo sendSuccess('Dein Teamspeak Server wurde erfolgreich geupgraded');
                                        header('refresh:3;url='.$url.'teamspeak/'.$server_id);
                                    } else {
                                        echo sendError('Du hast leider nicht genügend Guthaben');
                                    }
                                } else {
                                    modify($ts3_query, $_POST['slot_count'], $serverInfos['teamspeak_port']);
//                                        $price = str_replace('-', '', $price);
//                                        $user->removeMoney($odb, $price, $_SESSION['id']);
                                    $user->addMoney($odb, $price, $_SESSION['id']);
                                    $order->addOrder($odb, $_SESSION['id'], 'ORDER', $price, 'Teamspeak downgrade');

                                    $SQL = $odb->prepare("UPDATE `teamspeaks` SET `slots` = :slots WHERE `id` = :service_id");
                                    $SQL->execute(array(":slots" => $_POST['slot_count'], ":service_id" => $server_id));

                                    echo sendSuccess('Dein Teamspeak Server wurde erfolgreich gedowngraded');
                                    header('refresh:3;url='.$url.'teamspeak/'.$server_id);
                                }

                            } else {
                                echo sendError($errors);
                            }

                        }

                        ?>

                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20">
                                <h4 class="text-center">Teamspeak Server up/downgraden</h4>

                                <form method="post">
                                    <label for="slots">Slots</label>
                                    <input name="slot_count" id="slot_count" class="form-control" type="number" value="<?= $serverInfos['slots']; ?>" min="10" max="1000">

                                    <br>

                                    <button name="reconfigure" type="submit" class="btn btn-primary btn-block">Up/Downgraden</button>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20 text-center">

                                <h4>Kostenübersicht</h4>

                                <center>
                                    <font size="10" data-amount="">0.00€</font>
                                </center>

                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">

                        $('#slot_count').on('input', function() {update();});
                        $("select, textarea").change(function() { update(); } ).trigger("change");

                        function update()
                        {

                            var curr_price = <?= $site->getPriceFromProduct($odb, 'TEAMSPEAK'); ?> * <?= $serverInfos['slots']; ?>;
                            var new_price = <?= $site->getPriceFromProduct($odb, 'TEAMSPEAK'); ?> * parseInt($('#slot_count').val());
                            var num = (curr_price - new_price) * <?= $site->getDiffInDays($serverInfos['expire_at']); ?> / 30;

                            var price = Number(Math.abs(num))
                                .toLocaleString("de-DE", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                            if(num < 0)
                                $("*[data-amount]").html("-"+price + " €");
                            else
                                $("*[data-amount]").html("+" + price + " €");

                        }

                    </script>

                <?php } ?>

            </div>

        <?php } ?>

    </div>
</div>

<script>
    var countDownDate = new Date("<?= $serverInfos['expire_at']; ?>").getTime();
    var x = setInterval(function() {

        var now = new Date().getTime();
        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if(days == 1){ var days_text = ' Tag' } else { var days_text = ' Tage'; }
        if(hours == 1){ var hours_text = ' Stunde' } else { var hours_text = ' Stunden'; }
        if(minutes == 1){ var minutes_text = ' Minute' } else { var minutes_text = ' Minuten'; }
        if(seconds == 1){ var seconds_text = ' Sekunde' } else { var seconds_text = ' Sekunden'; }

        if(days == 0 && !(hours == 0 && minutes == 0 && seconds == 0)){
            $('#countdown').html(hours+hours_text+', '+  minutes+minutes_text+' und ' +  seconds+seconds_text);
            if(days == 0 && hours == 0 && !(minutes == 0 && seconds == 0)){
                $('#countdown').html(minutes+minutes_text+' und '+  seconds+seconds_text);
                if(days == 0 && hours == 0 && minutes == 0 && !(seconds == 0)){
                    $('#countdown').html(seconds+seconds_text);
                }
            }
        } else {
            $('#countdown').html(days+days_text+', '+  hours+hours_text+', '+  minutes+minutes_text);
        }

        if (distance < 0) {
            clearInterval(x);
            $('#countdown_text').html('Teamspeak ist abgelaufen!');
        }
    }, 1000);
</script>