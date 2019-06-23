<?php
$currPage = "back_Buchhaltung";
include 'app/require_once/page_controller.php';
?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">
        <div class="row">

            <div class="col-md-6">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent">

                        <h4 class="text-center">Meine Bestellungen</h4>

                        <table class="table table-hover table-striped w-full" id="asc_table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Aktion</th>
                                <th scope="col">Beschreibung</th>
                                <th scope="col">Preis</th>
                                <th scope="col">Datum</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $SQLSelectServers = $odb -> prepare("SELECT * FROM `user_transactions` WHERE `user_id` = :user_id");
                            $SQLSelectServers->execute(array(":user_id" => $_SESSION['id']));
                            if ($SQLSelectServers->rowCount() != 0) {
                                while ($row = $SQLSelectServers -> fetch(PDO::FETCH_ASSOC)){

                                    if($row['art'] == 'RENEW'){
                                        $aktion = 'Verlängerung';
                                    } elseif($row['art'] == 'ORDER'){
                                        $aktion = 'Bestellung';
                                    } elseif($row['art'] == 'INTERN'){
                                        $aktion = 'Interne Transaktion';
                                    }

                                    ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $aktion; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><?php echo $row['amount']; ?>€</td>
                                        <td><?php echo $row['created_at']; ?></td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent">

                        <h4 class="text-center">Mein Zahlungsverlauf</h4>

                        <table class="table table-hover table-striped w-full" id="desc_table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Zahlungsmethode</th>
                                <th scope="col">Status</th>
                                <th scope="col">Betrag</th>
                                <th scope="col">Beschreibung</th>
                                <th scope="col">Datum</th>
                                <th scope="col">Rechnung</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $SQLSelectServers = $odb -> prepare("SELECT * FROM `transactions` WHERE `user_id` = :user_id AND `state` = 'DONE'");
                            $SQLSelectServers->execute(array(":user_id" => $_SESSION['id']));
                            if ($SQLSelectServers->rowCount() != 0) {
                                while ($row = $SQLSelectServers -> fetch(PDO::FETCH_ASSOC)){

                                    if($row['state'] == 'DONE'){
                                        $status = 'Erfolgreich';
                                    } elseif($row['state'] == 'ABORT'){
                                        $status = 'Abgebrochen';
                                    } elseif($row['state'] == 'PENDING'){
                                        $status = 'Warte auf Zahlungseingang';
                                    }

                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['id']; ?></th>
                                        <td><?php echo $row['gateway']; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td><?php echo $row['amount']; ?>€</td>
                                        <td><?php echo $row['desc']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><a href="<?php echo $url; ?>rechnung/<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Rechnung anzeigen</a></td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

