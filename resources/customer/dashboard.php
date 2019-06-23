<?php
$currPage = "back_Dashboard";
include 'app/require_once/page_controller.php';
?>
<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <?php

        if(isset($_POST['safe_my_note'])){
            if(isset($_POST['my_note']) && !empty($_POST['my_note'])){

                $SQL = $odb->prepare("UPDATE `users` SET `account_note` = :my_note WHERE `id` = :user_id");
                $SQL->execute(array(":user_id" => $_SESSION['id'], ":my_note" => $_POST['my_note']));

                echo sendSuccess('Deine Notiz wurde gespeichert.');
                header('refresh:3;url='.$url.'dashboard');

            }
        }

        ?>

        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <!-- First Row -->
            <div class="col-xl-3 col-md-6 info-panel">
                <div class="card card-shadow">
                    <div class="card-block bg-white p-20">
                        <button type="button" class="btn btn-floating btn-sm btn-warning">
                            <i class="icon fa-money"></i>
                        </button>
                        <span class="ml-15 font-weight-400">Guthaben</span>
                        <div class="content-text text-center mb-0">
                            <span class="font-size-40 font-weight-100"><?php echo number_format($user->getMoney($odb, $_SESSION['id']), 2); ?>€</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 info-panel">
                <div class="card card-shadow">
                    <div class="card-block bg-white p-20">
                        <button type="button" class="btn btn-floating btn-sm btn-danger">
                            <i class="icon wb-grid-4"></i>
                        </button>
                        <span class="ml-15 font-weight-400">Produkte</span>
                        <div class="content-text text-center mb-0">
                            <span class="font-size-40 font-weight-100"><?php echo $site->getProductsFromCustomer($odb, $_SESSION['id']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 info-panel">
                <div class="card card-shadow">
                    <div class="card-block bg-white p-20">
                        <button type="button" class="btn btn-floating btn-sm btn-success">
                            <i class="icon wb-help"></i>
                        </button>
                        <span class="ml-15 font-weight-400">Offene Tickets</span>
                        <div class="content-text text-center mb-0">
                            <span class="font-size-40 font-weight-100"><?php echo $site->getOpenTicketsFromCustomer($odb, $_SESSION['id']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 info-panel">
                <div class="card card-shadow">
                    <div class="card-block bg-white p-20">
                        <button type="button" class="btn btn-floating btn-sm btn-primary">
                            <i class="icon wb-stats-bars"></i>
                        </button>
                        <span class="ml-15 font-weight-400">Monatliche Kosten</span>
                        <div class="content-text text-center mb-0">
                            <span class="font-size-40 font-weight-100"><?php echo number_format($site->getMontlyCostsFromCustomer($odb, $_SESSION['id']), 2); ?>€</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End First Row -->
        </div>

        <div class="row" data-plugin="matchHeight" data-by-row="true">

            <div class="col-md-6">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">

                        <p class="font-size-20 blue-grey-700">Meine Notizen</p>

                        <form method="post">
                            <textarea class="form-control" rows="5" name="my_note"><?php echo $userInfo['account_note']; ?></textarea>
                            <br>
                            <button type="submit" name="safe_my_note" class="btn btn-primary" style="float: right;">Speichern</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div id="recentActivityWidget" class="card card-shadow card-lg pb-20">
                    <div class="card-header card-header-transparent pb-10">
<!--                        <div class="card-header-actions">-->
<!--                            <span class="badge badge-default badge-round">VIEW ALL</span>-->
<!--                        </div>-->
                        <h5 class="card-title"> News </h5>
                    </div>
                    <ul class="timeline timeline-icon">

                        <?php
                        $SQLSelectServers = $odb -> prepare("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 3;");
                        $SQLSelectServers->execute();
                        if ($SQLSelectServers->rowCount() != 0) {
                        while ($row = $SQLSelectServers -> fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <li class="timeline-reverse timeline-item" style="cursor: default;">
                            <div class="timeline-content-wrap">
                                <div class="timeline-dot bg-green-600" style="cursor: default;">
                                    <?php echo $row['icon']; ?>
                                </div>
                                <div class="timeline-content">
                                    <div class="title">
                                        <!-- <span class="authors">NONE</span><br> -->
                                        <?php echo nl2br2($row['message']); ?>
                                    </div>
                                    <div class="metas">
                                        <?php echo $site->formatDateWithoutTime($row['created_at']); ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php } } ?>

                    </ul>
                </div>
            </div>

        </div>

    </div>
</div>