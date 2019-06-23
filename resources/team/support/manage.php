<?php
$currPage = "back_Team";
include 'app/require_once/page_controller.php';

$ticket_id = $_GET['id'];

$SQL = $odb -> prepare("SELECT * FROM `tickets` WHERE `id` = :ticket_id");
$SQL->execute(array(":ticket_id" => $ticket_id));
$ticketInfos = $SQL -> fetch(PDO::FETCH_ASSOC);

if(!($role->isInTeam($odb, $_SESSION['id']))){
    header('Location: '.$url.'support');
}

if($ticketInfos['status'] == 'OPEN'){
    $status = 'Offen';
} elseif($ticketInfos['status'] == 'CLOSED'){
    $status = 'Geschlossen';
}

if($ticketInfos['last_msg'] == 'CUSTOMER'){
    $last_msg = 'Kundenantwort';
} elseif($ticketInfos['last_msg'] == 'SUPPORT'){
    $last_msg = 'Supportantwort';
}

if(isset($_POST['answerTicket'])){
    if(isset($_POST['message']) && !empty($_POST['message'])){

        $SQL = $odb -> prepare("INSERT INTO `ticket_message`(`ticket_id`, `writer_id`, `message`) VALUES (:ticket_id,:writer_id,:message)");
        $SQL->execute(array(":ticket_id" => $ticket_id, ":writer_id" => $_SESSION['id'], ":message" => $_POST['message']));

        $SQL = $odb -> prepare("UPDATE `tickets` SET `last_msg` = 'SUPPORT' WHERE `id` = :id");
        $SQL->execute(array(":id" => $ticket_id));

        include 'app/mail/mail_templates/ticket_answered.php';
        sendMail($user->getEmail($odb, $ticketInfos['user_id']), $user->getName($odb, $ticketInfos['user_id']), $mailContent, $mailSubject, $emailAltBody, '', '');

        header('Location: '.$url.'team/support/'.$ticket_id);
        echo sendSuccess('Erfolgreich','Antwort übermittelt');

    }
}

if(isset($_POST['closeTicket'])){

    $SQL = $odb -> prepare("UPDATE `tickets` SET `status` = 'CLOSED' WHERE `id` = :id");
    $SQL->execute(array(":id" => $ticket_id));

    include 'app/mail/mail_templates/ticket_closed.php';
    sendMail($user->getEmail($odb, $ticketInfos['user_id']), $user->getName($odb, $ticketInfos['user_id']), $mailContent, $mailSubject, $emailAltBody, '', '');

    echo sendSuccess('Erfolgreich','Ticket geschlossen');
    header('refresh:3;url='.$url.'team/support/'.$ticket_id);
}

?>

<div class="page">

    <div class="page-header">
        <h1 class="page-title font-size-26 font-weight-100"><?php echo $currPageName; ?></h1>
    </div>

    <div class="page-content container-fluid">

        <div class="card card-shadow">
            <div class="card-header card-header-transparent">
                <div class="row">
                    <div class="col-md-2">
                        Ticket-ID: #<?php echo $ticket_id; ?>
                    </div>
                    <div class="col-md-3">
                        Status: <?php echo $status; ?>
                    </div>
                    <div class="col-md-3">
                        Letzte Antwort: <?php echo $last_msg; ?>
                    </div>
                    <div class="col-md-4">
                        Erstellt am: <?php echo $site->formatDateWithoutTime($ticketInfos['created_at']); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-body">
                <div class="chat-box">
                    <div class="chats">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="chat chat-left">
                                    <div class="chat-avatar">
                                        <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="<?php echo $user->getName($odb, $ticketInfos['user_id']); ?>">
                                            <img src="https://api.adorable.io/avatars/50/<?php echo $user->getName($odb, $ticketInfos['user_id']); ?>" alt="<?php echo $user->getName($odb, $ticketInfos['user_id']); ?>">
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-content">
                                            <p> <?php echo $ticketInfos['message']; ?> </p>
                                            <time class="chat-time"><?php echo $user->getName($odb, $ticketInfos['user_id']); ?> schrieb am <?php echo $site->formatDate($ticketInfos['created_at']); ?></time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>

                        <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                        <?php $SQL = $odb -> prepare("SELECT * FROM `ticket_message` WHERE `ticket_id` = :ticket_id");
                        $SQL->execute(array(":ticket_id" => $ticket_id));
                        if ($SQL->rowCount() != 0) {
                            while ($row = $SQL -> fetch(PDO::FETCH_ASSOC)){ ?>

                                <?php if($role->isInTeam($odb, $row['writer_id']) == true){ ?>
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="chat">
                                            <div class="chat-avatar">
                                                <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="<?php echo $user->getName($odb, $row['writer_id']); ?>">
                                                    <img src="https://api.adorable.io/avatars/50/<?= $user->getName($odb, $row['writer_id']); ?>" alt="<?= $user->getName($odb, $row['writer_id']); ?>">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-content">
                                                    <p> <?php echo nl2br2($row['message']); ?> </p>
                                                    <time class="chat-time"><?php echo $user->getName($odb, $row['writer_id']); ?> schrieb am <?php echo $site->formatDate($row['created_at']); ?></time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="chat chat-left">
                                                <div class="chat-avatar">
                                                    <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="<?php echo $user->getName($odb, $row['writer_id']); ?>">
                                                        <img src="https://api.adorable.io/avatars/50/<?= $user->getName($odb, $row['writer_id']); ?>" alt="<?= $user->getName($odb, $row['writer_id']); ?>">
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-content">
                                                        <p> <?php echo nl2br2($row['message']); ?> </p>
                                                        <time class="chat-time"><?php echo $user->getName($odb, $row['writer_id']); ?> schrieb am <?php echo $site->formatDate($row['created_at']); ?></time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                <?php } ?>

                            <?php } } ?>

                        <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                    </div>
                </div>
            </div>
            <div class="panel-footer pb-30">
                <?php if($ticketInfos['status'] == 'OPEN'){ ?>
                    <form method="post">

                        <hr>
                        <textarea class="form-control" rows="6" name="message" placeholder="Antworte auf diese Supportanfrage"></textarea>
                        <br>
                        <button class="btn btn-primary btn-block" name="answerTicket" type="submit">Antworten</button>

                    </form>
                    <br>
                    <form method="post">
                        <button class="btn btn-danger btn-block" name="closeTicket">Ticket schließen</button>
                    </form>
                <?php } else { ?>
                    <center>Dieses Ticket ist geschlossen</center>
                <?php } ?>
            </div>
        </div>

    </div>
</div>