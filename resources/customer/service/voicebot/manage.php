<?php
$currPage = "back_MusikBot";
include 'app/require_once/page_controller.php';

?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?> #<?= $_GET['id']; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <?php include 'app/functions/services/voicebot/manage/index.php'; ?>

        <?php if($suspended){ ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6" style="margin-top: 120px;">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20 text-center">

                            <i class="icon fa-server" style="font-size: 64px; color: red;"></i>

                            <h4>Produkt mit der ID #<?php echo $server_id; ?> ist abgelaufen</h4>
                            <a href="<?php echo $url; ?>musikbot/<?php echo $server_id; ?>/renew" class="btn btn-primary">Jetzt verlängern</a>

                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>

        <ul class="nav-quick nav-quick-bordered row">
            <li class="nav-item col-md-4 col-4">
                <a class="nav-link" href="<?php echo $url; ?>musikbot/<?php echo $server_id; ?>" <?php if(empty($_GET['menu'])){ echo 'style="color: #1e88e5;"'; } ?>>
                    <i class="icon wb-settings" aria-hidden="true"></i>
                    Übersicht
                </a>
            </li>
            <li class="nav-item col-md-4 col-4">
                <a class="nav-link" href="<?php echo $url; ?>musikbot/<?php echo $server_id; ?>/settings" <?php if($_GET['menu'] == 'settings'){ echo 'style="color: #1e88e5;"'; } ?>>
                    <i class="icon wb-user" aria-hidden="true"></i>
                    Einstellungen
                </a>
            </li>
            <li class="nav-item col-md-4 col-4">
                <a class="nav-link" href="<?php echo $url; ?>musikbot/<?php echo $server_id; ?>/radiolist" <?php if($_GET['menu'] == 'radiolist'){ echo 'style="color: #1e88e5;"'; } ?>>
                    <i class="icon wb-wrench" aria-hidden="true"></i>
                    Webradio Liste
                </a>
            </li>
        </ul>

        <div class="row">

            <?php if(empty($_GET['menu'])){ ?>
                <div class="col-md-4">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20 text-center">

                            <h4>Server Infos</h4>

                            <table class="table">
                                <tbody>
                                <tr>
                                    <th class="text-left">Status:</th>
                                    <td class="text-right"><?php echo $status_name; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Songname:</th>
                                    <td class="text-right"><?php echo $song_name; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Standort:</th>
                                    <td class="text-right">Deutschland</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Preis:</th>
                                    <td class="text-right"><?php echo $botInfos['price']; ?> € /Monat</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Laufzeit:</th>
                                    <td class="text-right"> <span id="countdown_text"> <span id="countdown">Lädt...</span></span> </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20 text-center">

                            <h4>Server Verwalten</h4>

                            <form method="POST" action="">
                                <center>
                                    <?php if($server_status == 'ONLINE'){ ?>
                                        <button type="button" disabled class="btn btn-block btn-success"><span>Starten</span></button>
                                        <button type="submit" name="sendStop" class="btn btn-block btn-danger"><span>Stoppen</span></button>
                                        <button type="submit" name="sendRestart" class="btn btn-block btn-warning"><span>Neustarten</span></button>
                                    <?php } elseif($server_status == 'OFFLINE') { ?>
                                        <button type="submit" name="sendStart" class="btn btn-block btn-success"><span>Starten</span></button>
                                        <button type="button" disabled class="btn btn-block btn-danger"><span>Stoppen</span></button>
                                        <button type="button" disabled class="btn btn-block btn-warning"><span>Neustarten</span></button>
                                    <?php } elseif($server_status == 'NEED_INSTALL') { ?>
                                        <center>
                                            <button type="submit" name="installServer" class="btn btn-block btn-float-lg btn-warning btn-block"><span>Installieren</span></button>
                                        </center>
                                    <?php } ?>
                                </center>
                            </form>

                            <br>
                            <a href="<?= $url; ?>musikbot/<?= $server_id; ?>/renew" class="btn btn-block btn-success"><span>Verlängern</span></a>
                            <br>

                            <br>
                            <br>
                            <h4>Direkt verbinden</h4>

                            <form method="post">
                                <select class="form-control" name="teamspeak_ip">
                                    <?php
                                    $SQLSelectService = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `user_id` = :user_id AND `deleted_at` IS NULL");
                                    $SQLSelectService->execute(array(":user_id" => $_SESSION['id']));
                                    if ($SQLSelectService->rowCount() != 0) {
                                        while ($show = $SQLSelectService -> fetch(PDO::FETCH_ASSOC)){ ?>
                                            <option value="<?php echo $show['teamspeak_ip']; ?>:<?php echo $show['teamspeak_port']; ?>"><?php echo $show['teamspeak_ip']; ?>:<?php echo $show['teamspeak_port']; ?> (ID: <?php echo $show['id']; ?>)</option>
                                        <?php } } else { echo '<option value="">Kein Teamspeak gefunden</option>'; $disabled = true; } ?>
                                </select>
                                <br>

                                <input hidden name="quick_connect" value="1">
                                <?php if($disabled){ ?>
                                    <button class="btn btn-primary btn-block" style="float: right;" disabled>Speichern</button>
                                <?php }else{ ?>
                                    <button class="btn btn-primary btn-block" style="float: right;" name="saveCFG">Speichern</button>
                                <?php } ?>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20 text-center">

                            <h4>Stream Verwalten</h4>

                            <form method="POST" action="">

                                <label>Streamlink</label>
                                <input name="song_url" placeholder="https://youtube.com/" class="form-control">

                                <br>

                                <label>Lautstärke <small>(1-100)</small></label>
                                <input name="volume" placeholder="1-100" type="number" class="form-control">

                                <br>

                                <button style="float: right;" type="submit" name="changeStreamSettings" class="btn btn-primary btn-sm">Speichern</button>

                            </form>

                        </div>
                    </div>
                </div>
            <?php } elseif($_GET['menu'] == 'settings'){ ?>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20 text-center">

                            <h4>Server einstellungen ändern</h4>

                            <form method="post">
                                <table class="table mb-0">
                                    <tbody>

                                    <tr>
                                        <th class="text-left">Server IP</th>
                                        <th>
                                            <input name="teamspeak_ip" value="<?php echo $botInfos['server_addr']; ?>" placeholder="127.0.0.1:9987" class="form-control">
                                        </th>
                                    </tr>

                                    <tr>
                                        <th class="text-left">Bot Name</th>
                                        <th><input name="bot_name" value="<?php echo $botInfos['bot_name']; ?>" class="form-control"></th>
                                    </tr>

                                    <tr>
                                        <th class="text-left">Server Passwort</th>
                                        <th><input name="ts3_server_password" value="<?php echo $botInfos['server_password']; ?>" class="form-control"></th>
                                    </tr>

                                    <tr>
                                        <th class="text-left">Channel ID</th>
                                        <th><input name="channel_id" value="<?php echo $botInfos['default_channel']; ?>" class="form-control"></th>
                                    </tr>

                                    <tr>
                                        <th class="text-left">Channel Passwort</th>
                                        <th><input name="channel_password" value="<?php echo $botInfos['channel_password']; ?>" class="form-control"></th>
                                    </tr>

                                    </tbody>
                                </table>
                                <button type="submit" name="saveCFG" class="btn btn-primary btn-block">Speichern</button>
                            </form>

                        </div>
                    </div>
                </div>
            <?php } elseif($_GET['menu'] == 'radiolist'){?>
                <div class="col-md-12">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent">

                            <table class="table table-hover table-striped w-full" id="ticket_table">
                                <thead>
                                <tr>
                                    <th scope="col">Stream Name</th>
                                    <th scope="col">Stream Link</th>
                                    <th scope="col"> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $SQLSelectServers = $odb -> prepare("SELECT * FROM `radiobot_webradio_list` WHERE `user_id` = :user_id OR `user_id` IS NULL");
                                $SQLSelectServers->execute(array(":user_id" => $_SESSION['id']));
                                if ($SQLSelectServers->rowCount() != 0) {
                                    while ($row = $SQLSelectServers -> fetch(PDO::FETCH_ASSOC)){ ?>
                                        <tr>
                                            <th scope="row"><?php echo $row['name']; ?></th>
                                            <td>
                                                <?php if(empty($row['user_id'])){ echo $row['url']; } else { echo 'Versteckt'; } ?>
                                            </td>
                                            <td>
                                                <form method="post">
                                                    <input name="song_url" value="<?php echo $row['id']; ?>" hidden="hidden">
                                                    <button class="btn btn-primary btn-sm" type="submit" name="changeStreamSettings">Abspielen</button>
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

        <?php } ?>
    </div>
</div>

<script>
    var countDownDate = new Date("<?= $botInfos['expire_at']; ?>").getTime();
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
            $('#countdown_text').html('MusikBot ist abgelaufen!');
        }
    }, 1000);
</script>