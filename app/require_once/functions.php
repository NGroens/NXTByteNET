<?php
//include functions
require 'app/functions/role.php';
require 'app/functions/user.php';
require 'app/functions/site.php';
require 'app/functions/order.php';
require 'app/functions/services/teamspeak/teamspeak.php';

//register functions
$role = new role;
$user = new user;
$site = new site;
$order = new order;
$ts3 = new ts3;