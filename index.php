<?php

ini_set('session.gc_maxlifetime', 172800);
session_set_cookie_params(172800);

ob_start();
session_start();

$date = new DateTime(null, new DateTimeZone('Europe/Berlin'));
$timeNow = $date->getTimestamp();
$dateTimeNow = $date->format('Y-m-d H:i:s');

require_once 'app/mail/PHPMailer/src/Exception.php';
require_once 'app/mail/PHPMailer/src/PHPMailer.php';
require_once 'app/mail/PHPMailer/src/SMTP.php';

include_once 'app/require_once/database.php';
include_once 'app/require_once/config.php';
include_once 'app/notifications/sendMail.php';
include_once 'app/require_once/site_settings.php';
include_once 'vendor/autoload.php';

$source_dir = 'resources/';
$customer_dir = $source_dir.'customer/';
$site_dir = $source_dir.'site/';
$team_dir = $source_dir.'team/';

if(isset($_GET['m'])) {
    $m = protect($_GET['m']);
    switch ($m) {

        //External Main Page
        case "main_page": include("resources/sites/main_page.php"); break;
        case "agb": include("resources/sites/agb.php"); break;
        case "datenschutz": include("resources/sites/datenschutz.php"); break;
        case "impressum": include("resources/sites/impressum.php"); break;
        case "teamspeak": include("resources/sites/teamspeak.php"); break;
        case "musikbot": include("resources/sites/musikbot.php"); break;
		case "webhosting": include("resources/sites/webhosting.php"); break;

        //Auth
        case "login": include($customer_dir . "auth/login.php"); break;
        case "register": include($customer_dir . "auth/register.php");  break;
        case "logout": unset($_SESSION['username']); session_unset(); session_destroy(); header("Location: ./"); break;
        case "forgot_password": include($customer_dir . "auth/forgot_password.php"); break;

        //Team Logout
        case "team_logout": include($customer_dir . "auth/team_logout.php"); break;

        //Dashboard
        case "index": include($customer_dir . "dashboard.php"); break;
        case "profil": include($customer_dir . "profile.php"); break;
        case "affiliate_click": include($customer_dir . "affiliate_click.php"); break;
        case "service_list": include($customer_dir . "service/list.php"); break;
        case "service_order": include($customer_dir . "service/order.php"); break;

        //Support
        case "support": include($customer_dir . "support/index.php"); break;
        case "support_manage": include($customer_dir . "support/manage.php"); break;

        //Payments
        case "pay_now": include($customer_dir . "payments/pay_now.php"); break;
        case "payments": include($customer_dir . "payments/payments.php"); break;
        //case "zahlungsverlauf": include($customer_dir . "payments/zahlungsverlauf.php"); break;
        //case "bestellungen": include($customer_dir . "payments/bestellungen.php"); break;
        case "invoice": include($customer_dir . "payments/invoice.php"); break;

        //Radiobots
        case "voicebots": include($customer_dir . "service/voicebot/index.php"); break;
        case "voicebot_order": include($customer_dir . "service/voicebot/order.php"); break;
        case "voicebot_manage": include($customer_dir . "service/voicebot/manage.php"); break;
        case "voicebot_renew": include($customer_dir . "service/voicebot/renew.php"); break;

        //Teamspeak
        case "teamspeaks": include($customer_dir . "service/teamspeak/index.php"); break;
        case "teamspeak_order": include($customer_dir . "service/teamspeak/order.php"); break;
        case "teamspeak_manage": include($customer_dir . "service/teamspeak/manage.php"); break;
        case "teamspeak_renew": include($customer_dir . "service/teamspeak/renew.php"); break;

        //Team
        case "team_users": include($team_dir . "users.php"); break;
        case "team_user": include($team_dir . "user.php"); break;
        case "team_tickets": include($team_dir . "support/index.php"); break;
        case "team_ticket": include($team_dir . "support/manage.php"); break;
        case "team_settings": include($team_dir . "einstellungen.php"); break;
        case "team_settings_manage": include($team_dir . "einstellungen.php"); break;
        case "team_transactions": include($team_dir . "transactions.php"); break;

    }

        if(strpos($currPage, 'front_') !== false){
            include 'resources/additional/front/footer.php';
        } else {
            include 'resources/additional/footer.php';
        }

} else {
    echo 'Fehler #404';
}
?>