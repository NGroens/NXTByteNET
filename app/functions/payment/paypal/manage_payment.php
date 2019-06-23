<?php

$paypalConfig = [
    'email' => $paypalEmail,
    'return_url' => $url.'guthaben/aufladen/erfolgreich',
    'cancel_url' => $url.'guthaben/aufladen',
    'notify_url' => $url.'paypal_ipn.php'
];

//die($paypalConfig);

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

$itemName = 'Guthabenaufladung';
$itemAmount = $_POST['amount'];

require 'functions.php';

$data = [];

$data['business'] = $paypalConfig['email'];

$data['return'] = stripslashes($paypalConfig['return_url']);
$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
$data['notify_url'] = stripslashes($paypalConfig['notify_url']);

$data['item_name'] = $itemName;
$data['amount'] = $itemAmount;
$data['currency_code'] = 'EUR';
$data['custom'] = $_SESSION['id'];

$queryString = http_build_query($data);
header('location:' . $paypalUrl . '?cmd=_xclick&' . $queryString);

exit($paypalUrl . '?' . $queryString);

