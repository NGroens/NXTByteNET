<?php
$currPage = "back_Meine Produkte";
include 'app/require_once/page_controller.php';
?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <?php //TODO ?>

        <div class="row" data-plugin="matchHeight" data-by-row="true">

            <?php
            $SQLSelectService = $odb -> prepare("SELECT * FROM `teamspeaks` WHERE `user_id` = :user_id AND `deleted_at` IS NULL");
            $SQLSelectService->execute(array(":user_id" => $_SESSION['id']));
            if ($SQLSelectService->rowCount() != 0) {
            while ($row = $SQLSelectService -> fetch(PDO::FETCH_ASSOC)) {

            if(is_null($row['suspended'])){
                $suspended = FALSE;
                $status_name = 'Aktiv';
                $status_color = 'bg-blue-600';
            } else {
                $suspended = TRUE;
                $status_name = 'Abgelaufen';
                $status_color = 'bg-orange-400';
            }

            ?>
            <div class="col-md-6 col-xl-3">
                <div class="pricing-list bg-white">
                    <div class="pricing-header">
                        <div class="pricing-title <?php echo $status_color; ?>">Teamspeak Server</div>
                        <div class="pricing-price">
                            <font size="5" class="blue-600"><?php echo $row['teamspeak_ip']; ?>:<?php echo $row['teamspeak_port']; ?></font>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li> Status: <?php echo $status_name; ?></li>
                        <li> Laufzeit: <?php echo $site->formatDate($row['expire_at']); ?></li>
                    </ul>
                    <div class="pricing-footer">
                        <a class="btn btn-primary btn-outline" role="button" href="<?php echo $url; ?>teamspeak/<?php echo $row['id']; ?>"><i class="icon wb-arrow-right font-size-16 mr-15" aria-hidden="true"></i>Verwalten</a>
                    </div>
                </div>
            </div>
            <?php } } ?>

            <?php
            $SQLSelectService = $odb -> prepare("SELECT * FROM `radiobots` WHERE `user_id` = :user_id AND `deleted_at` IS NULL");
            $SQLSelectService->execute(array(":user_id" => $_SESSION['id']));
            if ($SQLSelectService->rowCount() != 0) {
                while ($row = $SQLSelectService -> fetch(PDO::FETCH_ASSOC)) {

                    if($row['state'] == 'NEED_INSTALL'){
                        $status_name = 'Warte auf Installation';
                    } elseif($row['state'] == 'ACTIVE'){
                        $status_name = 'Aktiv';
                    } elseif($row['state'] == 'DISABLED'){
                        $status_name = 'Deaktiviert';
                    }

                    if(!($row['state'] == 'SUSPENDED')){
                        $suspended = FALSE;
                        $status_color = 'bg-blue-600';
                    } else {
                        $suspended = TRUE;
                        $status_name = 'Abgelaufen';
                        $status_color = 'bg-orange-400';
                    }

                    ?>
                    <div class="col-md-6 col-xl-3">
                        <div class="pricing-list bg-white">
                            <div class="pricing-header">
                                <div class="pricing-title <?php echo $status_color; ?>">MusikBot</div>
                                <div class="pricing-price">
                                    <font size="5" class="blue-600"><?php echo $row['bot_name']; ?></font>
                                </div>
                            </div>
                            <ul class="pricing-features">
                                <li> Status: <?php echo $status_name; ?></li>
                                <li> Laufzeit: <?php echo $site->formatDate($row['expire_at']); ?></li>
                            </ul>
                            <div class="pricing-footer">
                                <a class="btn btn-primary btn-outline" role="button" href="<?php echo $url; ?>musikbot/<?php echo $row['id']; ?>"><i class="icon wb-arrow-right font-size-16 mr-15" aria-hidden="true"></i>Verwalten</a>
                            </div>
                        </div>
                    </div>
                <?php } } ?>

        </div>

    </div>
</div>