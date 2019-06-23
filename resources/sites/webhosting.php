<?php
$currPage = "front_Webhosting";
include 'app/require_once/page_controller.php';
?>

<section class="blog-1-area about-blog homepage-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title ">
                    <h2>Warum gerade <span>NXTByte</span>? </h2>
                    <p>Warum solltest du dich gerade für nxtbyte.net entscheiden.</p>
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


<!-- WELCOME AREA END -->

<!--PRICING-TABLE -->
<section class="hosting-plan-area clouds">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>Webhosting<span> mieten</span>!</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="single-pricing-table">
                    <h2>Starter</h2>
                    <div class="pricing-amount">
                        <span class="price"> 1€ </span>
                        <span class="subscription">/ Monatlich</span>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li>5 GB SSD Speicher</li>
                            <li>5 Domains aufschaltbar</li>
                            <li>5 Subdomain inklusive</li>
                            <li>15 E-Mail Adressen</li>
                            <li>5 FTP Accounts</li>
                            <li>5 Datenbanken</li>
                            <li>DDoS Schutz</li>
                        </ul>
                        <a class="pricing-btn blue-btn" href="<?= $url; ?>support">Jetzt Anfragen</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-pricing-table">
                    <h2>Profi</h2>
                    <div class="pricing-amount">
                        <span class="price"> 5€ </span>
                        <span class="subscription">/ Monatlich</span>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li>15 GB SSD Speicher</li>
                            <li>15 Domains aufschaltbar</li>
                            <li>15 Subdomain inklusive</li>
                            <li>25 E-Mail Adressen</li>
                            <li>15 FTP Accounts</li>
                            <li>15 Datenbanken</li>
                            <li>DDoS Schutz</li>
                        </ul>
                        <a class="pricing-btn blue-btn" href="<?= $url; ?>support">Jetzt Anfragen</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-pricing-table">
                    <h2>Business</h2>
                    <div class="pricing-amount">
                        <span class="price"> 10€ </span>
                        <span class="subscription">/ Monatlich</span>
                    </div>
                    <div class="pricing-content">
                        <ul>
                            <li>150 GB SSD Speicher</li>
                            <li>Unlimited Domains aufschaltbar</li>
                            <li>Unlimited Subdomain inklusive</li>
                            <li>Unlimited E-Mail Adressen</li>
                            <li>Unlimited FTP Accounts</li>
                            <li>Unlimited Datenbanken</li>
                            <li>DDoS Schutz</li>
                        </ul>
                        <a class="pricing-btn blue-btn" href="<?= $url; ?>support">Jetzt Anfragen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--PRICING-TABLE END -->