<?php

if(strpos($currPage, 'auth_') !== false){
    $currPageName = str_replace("auth_", "", $currPage);
    $isBackPage = TRUE;
} else {
    $currPageName = str_replace("back_", "", $currPage);
    $isBackPage = TRUE;
}

?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">

    <title><?= $currPageName.' | '.$name; ?></title>

    <link rel="apple-touch-icon" href="<?php echo $cdnUrl; ?>images/apple-touch-icon.png">
    <link rel="shortcut icon" href="<?= $frontUrl; ?>img/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>css/site.min.css">

    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/animsition/animsition.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/switchery/switchery.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/flag-icon-css/flag-icon.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>examples/css/pages/login-v3.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>examples/css/tables/datatable.css">

    <!-- DASHBOARD -->
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/chartist/chartist.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/aspieprogress/asPieProgress.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/jquery-selective/jquery-selective.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>examples/css/dashboard/team.css">


    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>fonts/web-icons/web-icons.min.css">
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>fonts/brand-icons/brand-icons.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <link rel="stylesheet" href="<?php echo $cdnUrl; ?>fonts/font-awesome/font-awesome.min.css?v4.0.2">

    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>

    <!--[if lt IE 9]>
    <script src="<?php echo $cdnUrl; ?>vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="<?php echo $cdnUrl; ?>vendor/media-match/media.match.min.js"></script>
    <script src="<?php echo $cdnUrl; ?>vendor/respond/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha256-ENFZrbVzylNbgnXx0n3I1g//2WeO47XxoPe0vkp3NC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <!-- Scripts -->
    <script src="<?php echo $cdnUrl; ?>vendor/breakpoints/breakpoints.js"></script>
    <script>
        Breakpoints();
    </script>
</head>
<?php

if(strpos($currPage, 'auth_') !== false){
    $class = 'animsition page-login-v3 layout-full';
} elseif(strpos($currPage, 'back_') !== false){
    $class = 'animsition dashboard';
}

?>
<body class="<?php echo $class; ?>">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
