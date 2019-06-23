<?php
$currPage = "back_Team";
include 'app/require_once/page_controller.php';

if(!($role->isInTeam($odb, $_SESSION['id']))){
    header('Location: '.$url.'support');
}

?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent py-20">
                        <table id="ticket_table" class="table table-hover table-striped w-full">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titel</th>
                                <th scope="col">Status</th>
                                <th scope="col">Letzte Antwort</th>
                                <th scope="col">Datum</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $SQL = $odb -> prepare("SELECT * FROM `tickets` ORDER BY `id` ASC");
                            $SQL->execute(array(":user_id" => $_SESSION['id']));
                            if ($SQL->rowCount() != 0) {
                                while ($row = $SQL -> fetch(PDO::FETCH_ASSOC)){

                                    if($row['status'] == 'OPEN'){
                                        $status = 'Offen';
                                    } elseif($row['status'] == 'CLOSED'){
                                        $status = 'Geschlossen';
                                    }

                                    if($row['last_msg'] == 'CUSTOMER'){
                                        $last_msg = 'Kundenantwort';
                                    } elseif($row['last_msg'] == 'SUPPORT'){
                                        $last_msg = 'Supportantwort';
                                    }

                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['id']; ?></th>
                                        <th scope="row"><?php echo $row['title']; ?></th>
                                        <th scope="row"><?php echo $status; ?></th>
                                        <th scope="row"><?php echo $last_msg; ?></th>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><a href="<?php echo $url; ?>team/support/<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Anschauen</a></td>
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