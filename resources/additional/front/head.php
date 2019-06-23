<?php

if(strpos($currPage, 'front_') !== false){
    $currPageName = str_replace("front_", "", $currPage);
    $isBackPage = FALSE;
}

?>
<!doctype html>
<html lang="de">

<head>
    <!-- BASIC META-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $currPageName; ?> | NXTByte</title>
    <!-- FAVICON -->
    <link rel="apple-touch-icon" href="<?= $frontUrl; ?>img/favicon.ico">
    <link rel="icon" href="<?= $frontUrl; ?>img/favicon.ico">
    <!-- WEB FONTS  -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- BOOTSTRAP MIN CSS -->
    <link href="<?= $frontUrl; ?>css/bootstrap.min.css" rel="stylesheet">
    <!-- MC Scroll CSS -->
    <link href="<?= $frontUrl; ?>css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <!-- ALL PLUGINS CSS -->
    <link href="<?= $frontUrl; ?>css/swiper.css" rel="stylesheet">
    <!-- ALL PLUGINS CSS -->
    <link href="<?= $frontUrl; ?>css/elements.css" rel="stylesheet">
    <!-- THEME STYLE CSS -->
    <link href="<?= $frontUrl; ?>style.css" rel="stylesheet">
    <!-- RESPONSIVE CSS -->
    <link href="<?= $frontUrl; ?>responsive.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
    <script>
        window.addEventListener("load", function(){
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": "#237afc"
                    },
                    "button": {
                        "background": "#fff",
                        "text": "#237afc"
                    }
                },
                "theme": "classic",
                "position": "bottom-right",
                "content": {
                    "message": "Diese Website verwendet Cookies, um sicherzustellen, dass Sie das beste Ergebnis auf unserer Website erzielen.",
                    "dismiss": "Vertanden",
                    "link": "Erfahre mehr"
                }
            })});
    </script>

</head>
<body id="homepage-3">
<div class="preloader-wrapper">
    <div class="preloder">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>
</div>