<?php
$currPage = "front_Startseite";
include 'app/require_once/page_controller.php';
?>

<section class="blog-1-area about-blog homepage-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title ">
                    <h2>Warum gerade <span>NXTByte</span>? </h2>
                    <p>Warum solltest du dich gerade für NXTByte.net entscheiden.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-12 ">
                <div class="single-blog-1">
                    <img src="<?= $frontUrl; ?>img/service/about-icon-11.png" alt="section-icon">
                    <h2>Starke Leistung</h2>
                    <p>Wir verwenden ausschließlich hochwertige Hardware für den Dauerbetrieb.</p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12 ">
                <div class="single-blog-1">
                    <img src="<?= $frontUrl; ?>img/service/service-icon-4.png" alt="section-icon">
                    <h2>DDoS Schutz</h2>
                    <p>Bei uns sind deine Produkte vor DDoS Angriffen bestens gesichert mit unserem OVH Game Schutz.</p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12 ">
                <div class="single-blog-1">
                    <img src="<?= $frontUrl; ?>img/service/section-icon-3.png" alt="section-icon">
                    <h2>24/7 Support</h2>
                    <p>Unser freundlicher und fachkundiger Support hilft Dir gerne jederzeit weiter.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--REGISTER-AREA -->
<section class="register-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="register-heading">
                    <h2>Noch nicht Registriert?<br> Registriere dich noch heute.</h2>
                </div>
                <div class="register-btn">
                    <a class="pricing-btn blue-btn homepage-one-all-features-btn register-btn" href="<?= $url; ?>register">Registrieren</a>
                </div>
            </div>
        </div>
    </div>
</section>
