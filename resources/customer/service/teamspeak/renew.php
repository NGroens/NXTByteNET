<?php
$currPage = "back_Teamspeak";
include 'app/require_once/page_controller.php';
include 'app/functions/services/teamspeak/renew.php';
?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?> #<?php echo $server_id; ?></h1>
    </div>

    <div class="page-content container-fluid">
        <div class="row">

            <div class="col-md-3">
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
                                <th class="text-left">Preis:</th>
                                <td class="text-right"><?php echo $price; ?> € /Monat</td>
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

            <div class="col-md-6">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20 text-center">
                        <h4>Server verlängern</h4>

                        <form method="post">
                        <select id="duration" name="duration" class="form-control">
                            <option data-factor="30" value="30" selected="">30 Tage</option>
                            <option data-factor="60" value="60">60 Tage</option>
                            <option data-factor="90" value="90">90 Tage</option>
                        </select>

                        <br>

                        <button type="submit" name="renewService" class="btn btn-primary">Kostenpflichtig verlängern</button>
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

        </div>
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

<script type="text/javascript">
    $("select, input, textarea").change(function() {
        update();
    }).trigger("change");

    function update()
    {
        var price = Number("<?php echo $price; ?>" * ($("#duration").find("option:selected").data("factor") / 30)).toLocaleString("de-DE", {minimumFractionDigits: 2, maximumFractionDigits: 2});
        $("*[data-amount]").html(price + " €");
    }
</script>