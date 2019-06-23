<?php
$currPage = "back_Bestellen";
include 'app/require_once/page_controller.php';
?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <?php //TODO ?>

        <div class="row" data-plugin="matchHeight" data-by-row="true">

            <div class="col-xl-2"></div>
                <div class="col-md-6 col-xl-3">
                    <div class="pricing-list bg-white">
                        <div class="pricing-header">
                            <div class="pricing-title bg-blue-600">Teamspeak Server</div>
                            <div class="pricing-price">
                                <font size="5" class="blue-600">ab <?= $site->getPriceFromProduct($odb, 'TEAMSPEAK'); ?>€ <small>pro Slot</small></font>
                            </div>
                        </div>
                        <ul class="pricing-features">
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> 99% Uptime</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> OVH GAME DDoS Schutz</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Gute Anbindung</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Volle Adminrechte</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Keine Vertragslaufzeit</li>
                        </ul>
                        <div class="pricing-footer">
                            <a class="btn btn-primary btn-outline" role="button" href="<?php echo $url; ?>teamspeak/order"><i class="icon wb-arrow-right font-size-16 mr-15" aria-hidden="true"></i>Jetzt bestellen</a>
                        </div>
                    </div>
                </div>
            <div class="col-xl-2"></div>
                <div class="col-md-6 col-xl-3">
                    <div class="pricing-list bg-white">
                        <div class="pricing-header">
                            <div class="pricing-title bg-blue-600">MusikBot</div>
                            <div class="pricing-price">
                                <font size="5" class="blue-600">ab <?= $site->getPriceFromProduct($odb, 'VOICEBOT'); ?>€ <small>pro Monat</small></font>
                            </div>
                        </div>
                        <ul class="pricing-features">
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> 99% Uptime</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Beste Stream Qualität</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Gute Anbindung</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Keine Vertragslaufzeit</li>
                            <li> <i class="fa fa-fw fa-check" style="color: green;"></i> Einfache Verwaltung</li>
                        </ul>
                        <div class="pricing-footer">
                            <a class="btn btn-primary btn-outline" role="button" href="<?php echo $url; ?>musikbot/order"><i class="icon wb-arrow-right font-size-16 mr-15" aria-hidden="true"></i>Jetzt bestellen</a>
                        </div>
                    </div>
                </div>

        </div>

    </div>
</div>