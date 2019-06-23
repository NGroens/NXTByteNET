<?php
$currPage = "back_Support";
include 'app/require_once/page_controller.php';
?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Neues Ticket erstellen</button>
        <br><br>

        <div class="row">

            <div class="col-md-12">
                <div class="card card-shadow">
                    <div class="card-header card-header-transparent">

                        <?php
                        if(isset($_POST['createTicket'])){
                            if(isset($_POST['title']) && !empty($_POST['title'])){
                                if(isset($_POST['category']) && !empty($_POST['category'])){
                                    if(isset($_POST['priority']) && !empty($_POST['priority'])){
                                        if(isset($_POST['message']) && !empty($_POST['message'])){

                                            $SQL = $odb->prepare("INSERT INTO `tickets`(`user_id`, `categorie`, `priority`, `title`, `message`, `status`, `last_msg`) VALUES (:user_id,:categorie,:priority,:title,:message,:status,:last_msg)");
                                            $SQL->execute(array(":user_id" => $_SESSION['id'], ":categorie" => $_POST['category'], ":priority" => $_POST['priority'], ":title" => $_POST['title'], ":message" => $_POST['message'], ":status" => 'OPEN', ":last_msg" => 'CUSTOMER'));

                                            include 'app/mail/mail_templates/ticket_created.php';
                                            sendMail($_SESSION['email'], $_SESSION['id'], $mailContent, $mailSubject, $emailAltBody, '', '');

                                            //TODO
                                            sendPush($pushoverUserKey,'Neues Support-Ticket','Soeben wurde ein neues Support-Ticket von dem Benutzer '.$user->getName($odb, $_SESSION['id']).' mit dem Titel '.$_POST['title'].' erstellt.');

                                            echo sendSuccess('Deine Anfrage wurde an das Team übermittelt');
                                            header('Location: '.$url.'support');
//                                            header('refresh:3;url='.$url.'support');
                                        }
                                    }
                                }
                            }
                        }
                        ?>

                        <h4 class="text-center">Meine Supportanfragen</h4>

                        <table class="table table-hover table-striped w-full" id="desc_table">
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
                            $SQL = $odb -> prepare("SELECT * FROM `tickets` WHERE `user_id` = :user_id");
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
                                        <td><a href="<?php echo $url; ?>support/<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Anschauen</a></td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <form method="post">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Neues Ticket erstellen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Titel:</label>
                        <input class="form-control" name="title" required="required">

                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Kategorie:</label>
                                <select class="form-control" name="category" required="required">
                                    <option value="ALLGEMEIN">Allgemein</option>
                                    <option value="TECHNIK">Technik</option>
                                    <option value="BUCHHALTUNG">Buchhaltung</option>
                                    <option value="PARTNER">Partnerschaft</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Priorität:</label>
                                <select class="form-control" name="priority" required="required">
                                    <option value="NORMAL">Normal</option>
                                    <option value="MITTEL">Mittel</option>
                                    <option value="HOCH">Hoch</option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <label>Beschreibung:</label>
                        <textarea class="form-control" name="message" rows="5" required="required"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Schließen</button>
                        <button type="submit" class="btn btn-primary" name="createTicket">Ticket erstellen</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>