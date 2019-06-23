<?php
$currPage = "back_Team";
include 'app/require_once/page_controller.php';

if(!($role->isAdmin($odb, $_SESSION['id']))){
    header('Location: '.$url.'logout');
}

if(isset($_POST['customerLogin'])){
    if(isset($_POST['user_id']) && !empty($_POST['user_id'])){

        $getKundenInfo = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :user_id");
        $getKundenInfo -> execute(array(":user_id" => $_POST['user_id']));
        $kundenInfo = $getKundenInfo -> fetch(PDO::FETCH_ASSOC);

        if($getKundenInfo->rowCount() == 1) {

            setcookie("support_login", $_SESSION['username'], time() + 3600, '/');

            $_SESSION['username'] = $kundenInfo['username'];
            $_SESSION['id'] = $kundenInfo['id'];
            $_SESSION['email'] = $kundenInfo['email'];

            header('Location: ' . $url.'dashboard');

        }

    }
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

                        <h4>Transaktions Liste</h4>

                        <table id="desc_table" class="table table-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User-ID</th>
                                    <th scope="col">Zahlungsmethode</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Betrag</th>
                                    <th scope="col">Beschreibung</th>
                                    <th scope="col">Tid</th>
                                    <th scope="col">Erstellt am</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $SQL = $odb -> prepare("SELECT * FROM `transactions`");
                            $SQL->execute();
                            if ($SQL->rowCount() != 0) {
                                while ($row = $SQL -> fetch(PDO::FETCH_ASSOC)){ ?>
                                    <tr>
                                        <th><?= $row['id']; ?></th>
                                        <th><?= $row['user_id']; ?></th>
                                        <th><?= $row['gateway']; ?></th>
                                        <th><?= $row['state']; ?></th>
                                        <th><?= $row['amount']; ?></th>
                                        <th><?= $row['desc']; ?></th>
                                        <th><?= $row['tid']; ?></th>
                                        <th><?= $row['created_at']; ?></th>
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