<?php
/**
 * Created by PhpStorm.
 * User: Sylvano
 * Date: 07.03.2019
 * Time: 21:23
 */

if($_POST['payment_method'] == 'CREDITCARD'){

    $amount = $_POST["amount"];
    $amount = str_replace(',','.', $amount);

    if ($amount < 1 || $amount > 500) {
        if($amount < 1){
            echo sendError('Für Kreditkarten Zahlungen ist ein Mindestbetrag von 1.00€ notwendig!');
        } else {
            echo sendError('Bitte gebe einen Betrag zwischen 1.00€ und 500€ an!');
        }
    } else {

        $stripe_amount = str_replace('.', '', $amount);
        if ($stripe_amount < 100) {
            $stripe_amount = $stripe_amount.'00';
        }

        \Stripe\Stripe::setApiKey("sk_live_YvGJjwI9ak1hS0eRub4sP77g00yl967NWN");

        $session = \Stripe\Checkout\Session::create([
            'success_url' => 'https://nxtbyte.net/guthaben/aufladen/erfolgreich',
            'cancel_url' => 'https://nxtbyte.net/guthaben/aufladen',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'amount' => $stripe_amount,
                'quantity' => 1,
                'name' => 'Guthabenaufladung',
                'currency' => 'eur'
            ]]
        ], [
            'stripe_version' => '2018-11-08; checkout_sessions_beta=v1'
        ]);

        $payment_tid = $session->id;
        $payment_url = 'NONE';
        $customer_ip = $_SERVER['REMOTE_ADDR'];

        var_dump($session);

        if (isset($payment_tid)) {

            $SQL = $odb->prepare("INSERT INTO `transactions`(`user_id`, `gateway`, `state`, `amount`, `desc`, `tid`) VALUES (:user_id,:gateway,'PENDING',:amount,'Guthabenaufladung mit Kreditkarte',:tid)");
            $SQL->execute(array(":user_id" => $_SESSION['id'], ":gateway" => 'creditcard', ":amount" => $amount, ":tid" => $payment_tid));

        } else {
            header('Location: https://nxtbyte.net/');
            //exit;
        }
    }

?>
<script>
    var stripe = Stripe(
        'pk_live_YpwcfjK5LMDM8j9VVGzi5riW00IZbV4Xgi',
        {
            betas: ['checkout_beta_4']
        }
    );

    stripe.redirectToCheckout({
        sessionId: '<?php echo $payment_tid; ?>',
    }).then(function (result) {
        alert(result);
    });
</script>
<?php } ?>