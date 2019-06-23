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

                        <h4>Benutzer Liste</h4>

                        <table id="asc_table" class="table table-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">E-Mail</th>
                                <th scope="col">Gruppe</th>
                                <th scope="col">Status</th>
                                <th scope="col">Kunde seit</th>
                                <th scope="col"> </th>
                                <th scope="col"> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $SQLSelectServers = $odb -> prepare("SELECT * FROM `users`");
                            $SQLSelectServers->execute(array(":user_id" => $_SESSION['id']));
                            if ($SQLSelectServers->rowCount() != 0) {
                                while ($row = $SQLSelectServers -> fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['id']; ?></th>
                                        <th scope="row"><?php echo $row['username']; ?></th>
                                        <th scope="row"><?php echo $row['email']; ?></th>
                                        <th scope="row"><?php echo $row['role']; ?></th>
                                        <th scope="row"><?php echo $row['status']; ?></th>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><a class="btn btn-primary btn-sm" href="<?php echo $url; ?>team/user/<?php echo $row['id']; ?>">Bearbeiten</a></td>
                                        <td><form method="post"><input name="user_id" value="<?php echo $row['id']; ?>" hidden="hidden"><button class="btn btn-primary btn-sm" type="submit" name="customerLogin">Einloggen</button></form></td>
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