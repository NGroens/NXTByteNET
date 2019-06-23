<?php
$currPage = "Buchhaltung";
include 'app/require_once/page_controller.php';

if(empty($_GET['id']) || !isset($_GET['id'])){
    header('Location: '.$url.'zahlungsverlauf');
}

$invoice_id = $_GET['id'];

$SQL = $odb -> prepare("SELECT * FROM `transactions` WHERE `id` = :id");
$SQL -> execute(array(":id" => $invoice_id));
$invoiceInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

if(!($_SESSION['id'] == $invoiceInfos['user_id'])){
    header('Location: '.$url.'zahlungsverlauf');
}

?>

<div class="main-content">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">

                <div class="header mt-md-5">
                    <div class="header-body">
                        <div class="row align-items-center">
                            <div class="col">

                                <h1 class="header-title">
                                    Rechnung #<?php echo $invoice_id; ?>
                                </h1>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-body p-5">
                    <div class="row">
                        <div class="col text-right">

                            <div class="badge badge-success">
                                <?php if($invoiceInfos['state'] == 'DONE'){ echo 'Erfolgreich'; } ?>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">

                            <img src="<?php echo $picUrl; ?>logo/logo.png" alt="..." class="img-fluid mb-4" style="max-width: 220px;">

                            <h2 class="mb-2">
                                Guthabenaufladung
                            </h2>

                            <br>
							<br>
							<br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">

                            <h6 class="text-uppercase text-muted">
                                Einzelunternehmen Leon Petersen
                            </h6>

                            <p class="text-muted mb-4">
                                <strong class="text-body">Leon Petersen</strong> <br>
                                Buchfinkenweg 9 <br>
                                04159 Leipzig <br>
                                Deutschland
                            </p>

                            <h6 class="text-uppercase text-muted">
                                Rechnung
                            </h6>

                            <p class="mb-4">
                                #<?php echo $invoice_id; ?>
                            </p>

                        </div>
                        <div class="col-12 col-md-6 text-md-right">

                            <h6 class="text-uppercase text-muted">
                                Rechnung an
                            </h6>

                            <p class="text-muted mb-4">
                                <strong class="text-body"><?php echo $userInfo['vorname']; ?> <?php echo $userInfo['nachname']; ?></strong> <br>
                                <?php echo $userInfo['strasse']; ?> <?php echo $userInfo['hausnummer']; ?><br>
                                <?php echo $userInfo['postleitzahl']; ?> <?php echo $userInfo['stadt']; ?><br>
                                <?php echo $userInfo['land']; ?>
                            </p>

                            <h6 class="text-uppercase text-muted">
                                Datum
                            </h6>

                            <p class="mb-4">
                                <time datetime="2018-04-23">
									<?php 
									$date = new DateTime($invoiceInfos['created_at']);
									echo $date->format('d.m.Y H:i:s');
									?>
								</time>
                            </p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">


                            <div class="table-responsive">
                                <table class="table my-4">
                                    <thead>
                                    <tr>
                                        <th class="px-0 bg-transparent border-top-0">
                                            <span class="h6">Beschreibung</span>
                                        </th>
                                        <th class="px-0 bg-transparent border-top-0">
                                            <span class="h6">Zahlungsmethode</span>
                                        </th>
                                        <th class="px-0 bg-transparent border-top-0 text-right">
                                            <span class="h6">Preis</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="px-0">
                                                <?php echo $invoiceInfos['desc']; ?>
                                            </td>
                                            <td class="px-0">
                                                <?php echo $invoiceInfos['gateway']; ?>
                                            </td>
                                            <td class="px-0 text-right">
                                                <?php echo $invoiceInfos['amount']; ?>€
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr class="my-5">


                        </div>
                    </div> <!-- / .row -->
                </div>

            </div>
        </div> <!-- / .row -->
    </div>

</div>

