<?php
$currPage = "back_MusikBot";
include 'app/require_once/page_controller.php';

if(isset($_POST['price'])){
    $price = str_replace(',','.', $_POST['price']);
}

?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">
        <div class="row">

            <div class="col-md-7">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20 text-center">

                        <?php

                        include 'app/functions/services/voicebot/order.php';

                        if(isset($_POST['step2'])){
                            if($user->getMoney($odb, $_SESSION['id']) < $price){
                                unset($_POST['step2']);
                                echo sendError('Du hast leider nicht genügend Guthaben');
                            } elseif(empty($_POST['bot_name'])) {
                                unset($_POST['step2']);
                                echo sendError('Bitte gebe einen Botnamen an');
                            }

                            if(empty($price)){
                                header('Location:'.$url.'musikbot/order');
                            }
                        }

                        ?>

                        <?php if($orderSuccess){ ?>
                            <h4>Bestellung erfolgreich</h4>

                            <br>

                            <p id="activeAction"></p>

                            <div class="progress progress-lg">
                                <div class="progress-bar progress-bar-success" id="progressBar" style="width: 0%;" role="progressbar">0%</div>
                            </div>

                            <br>

                            <div id="setupDone"></div>

                            <script>
                                var messages = {
                                    5: 'Dein MusikBot wird erstellt.',
                                    4: 'Dein MusikBot wird dir zugewiesen.',
                                    3: 'Die E-Mails werden versendet.',
                                    2: 'Deine Rechnung wird generiert.',
                                    1: 'Die Einrichtung wird abgeschlossen...',
                                    0: 'Dein MusikBot ist nun vollständig eingerichtet.'
                                };
                                timer = 5;
                                function countdown() {
                                    var percent = 100 / 5 * (5 - timer);
                                    $('#progressBar').css('width', percent + '%').html(percent + '%');
                                    if (percent < 100) {
                                        $('#activeAction').html('<i class="fa fa-fw fa-spin fa-spinner fa-4x"></i><br><br> ' + messages[parseInt(timer)]);
                                    } else {
                                        $('#activeAction').html('<i class="fa fa-fw fa-check fa-4x" style="color: green;"></i><br><br> ' + messages[parseInt(timer)]);
                                    }

                                    timer--;
                                    if (timer >= 0) {
                                        setTimeout(function() {
                                            countdown();
                                        }, 1800);
                                    } else {
                                        $('#setupDone').html('<a href="<?php echo $url; ?>service/list" class="btn btn-block btn-primary">MusikBot verwalten</a>');
                                    }
                                }
                                countdown();
                            </script>
                        <?php } elseif(isset($_POST['step2'])) { ?>
                            <h4>Prüfe deine Bestellung</h4>

                            <form method="post">

                                Botname: <?= $_POST['bot_name']; ?>
                                <input hidden value="<?php echo $_POST['bot_name']; ?>" name="bot_name">

                                <br>
                                Laufzeit: <?= $_POST['duration']; ?> Tage
                                <input hidden value="<?php echo $_POST['duration']; ?>" name="duration">

                                <br>
                                <hr>

                                <div>
                                    <input type="checkbox" name="agb" id="agb"> <label for="agb">Ich akzeptiere die <a href="<?php echo $url; ?>agb">AGB</a> und die <a href="<?php echo $url; ?>datenschutz">Datenschutzerklärung</a>.</label><br>

                                    <label for="wiederruf"><input type="checkbox" name="wiederruf" id="wiederruf"> Ich wünsche die vollständige Ausführung der Dienstleistung vor Fristablauf des Widerufsrechts gemäß Fernabsatzgesetz. Die automatische Einrichtung und Erbringung der Dienstleistung führt zum Erlöschen des Widerrufsrechts.</label>
                                </div>

                                <br>

                                <input hidden name="price" value="<?= $price; ?>">
                                <button type="submit" style="float:right;" class="btn btn-primary" name="orderService">Kostenpflichtig bestellen</button>
                            </form>
                        <?php } else { ?>
                            <form method="post">
                                <label>Botname</label>
                                <input name="bot_name" class="form-control" placeholder="Mein eigener MusikBot">

                                <br>

                                <label>Laufzeit</label>
                                <select name="duration" id="duration" class="form-control">
                                    <option data-factor="30" value="30" selected="">30 Tage</option>
                                    <option data-factor="60" value="60">60 Tage</option>
                                </select>

                                <br>

                                <input hidden name="price" id="price" value="">
                                <button type="submit" style="float:right;" class="btn btn-primary" name="step2">Bestellung prüfen</button>
                            </form>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20 text-center">
                        <h4>Kostenübersicht</h4>

                        <center>
                            <font size="10" data-amount=""><?php if(isset($_POST['price'])){ echo $_POST['price']; } else { echo '0.00'; } ?>€</font>
                        </center>

                        <?php if(isset($_POST['step2'])){ ?>
                            Konto vorher: <?= number_format($user->getMoney($odb, $_SESSION['id']), 2); ?>€<br>
                            Konto nachher: <?= number_format($user->getMoney($odb, $_SESSION['id']) - $price,2); ?>€
                            <br><br>
                        <?php } ?>

                        <div class="pricing-list">
                            <ul class="pricing-features">
                                <li> <i class="fa fa-fw fa-check" style="color: green;"></i> 99% Uptime</li>
                                <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Beste Stream Qualität</li>
                                <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Gute Anbindung</li>
                                <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Keine Vertragslaufzeit</li>
                                <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Einfache Verwaltung</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php if(!isset($_POST['price'])){ ?>
<script type="text/javascript">
    $("select, input, textarea").change(function()
    {
        update();
    }).trigger("change");

    function update()
    {
        var price = Number("<?php echo $site->getPriceFromProduct($odb, 'VOICEBOT'); ?>" * ($("#duration").find("option:selected").data("factor") / 30)).toLocaleString("de-DE", {minimumFractionDigits: 2, maximumFractionDigits: 2});
        $("*[data-amount]").html(price + " €");
        $('#price').val(price);
    }
</script>
<?php } ?>