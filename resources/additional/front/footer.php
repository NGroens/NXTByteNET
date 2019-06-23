<!--BRANDE AREA -->
<section class="brand-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="brand-inner">
                    <div class="owl-carousel all-brand-carsouel">
                        <div class="brand-single-item">
                            <div class="brand-single-item-cell">
                                <img src="<?= $frontUrl; ?>img/brand-logo/brand-icon.png" alt="brand-icon">
                            </div>
                        </div>
                        <div class="brand-single-item">
                            <div class="brand-single-item-cell">
                                <img src="<?= $frontUrl; ?>img/brand-logo/brand-icon-2.png" alt="brand-icon">
                            </div>
                        </div>
                        <div class="brand-single-item">
                            <div class="brand-single-item-cell">
                                <img src="<?= $frontUrl; ?>img/brand-logo/brand-icon-3.png" alt="brand-icon">
                            </div>
                        </div>
                        <div class="brand-single-item">
                            <div class="brand-single-item-cell">
                                <img src="<?= $frontUrl; ?>img/brand-logo/brand-icon-4.png" alt="brand-icon">
                            </div>
                        </div>
                        <div class="brand-single-item">
                            <div class="brand-single-item-cell">
                                <img src="<?= $frontUrl; ?>img/brand-logo/brand-icon-5.png" alt="brand-icon">
                            </div>
                        </div>
                        <div class="brand-single-item">
                            <div class="brand-single-item-cell">
                                <img src="<?= $frontUrl; ?>img/brand-logo/brand-icon-6.png" alt="brand-icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--BRANDE AREA  END-->
<!--FOOTER AREA -->
<section class="footer-area">
    <div class="container">
        <div class="footer-main ">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="footer-single-item">
                        <div class="logo">
                            <a href="#"><img src="<?= $frontUrl; ?>img/logo/footer-logo.png" alt="logo"></a>
                        </div>
                        <p class="contact-info"><span>Telefon:</span><a href="tel: 0173 7580707">0173 7580707</a></p>
                        <p class="contact-info"><span>Email:</span><a href="mailto:support@nxtbyte.net">support@nxtbyte.net</a> </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12 ">
                    <div class="single-footer">
                        <h2>Produkte</h2>
                        <div class="footer-links">
                            <ul>
                                <li><a href="<?= $url; ?>teamspeak">TeamSpeak Server</a></li>
                                <li><a href="<?= $url; ?>musikbot">Musikbot</a></li>
								<li><a href="<?= $url; ?>webhosting">Webhosting</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12 ">
                    <div class="single-footer">
                        <h2>Nützliche Links</h2>
                        <div class="footer-links">
                            <ul>
                                <li><a href="http://ts-reseller.de/host/?id=XZ7FYL3VE95TT422CZ4NSWG">TeamSpeak ATHP</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12 ">
                    <div class="single-footer">
                        <h2>Unternehmen</h2>
                        <div class="footer-links">
                            <ul>
                                <li><a href="<?= $url; ?>impressum">Impressum</a></li>
                                <li><a href="<?= $url; ?>datenschutz">Datenschutzerklärung</a></li>
                                <li><a href="<?= $url; ?>agb">Allgemeine Geschäftsbedingungen</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--FOOTER-BOTTOM-AREA -->
        <div class="foter-botom">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 ">
                    <p> &copy; 2019 NXTByte, alle rechte vorbehalten.</p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 text-right ">
                    <div class="social-links">
                        <a href="https://www.youtube.com/channel/UCUn2mF1_mZ4iPVn1T6WgSCQ" target="_blank"><span class="ti-youtube"></span></a>
                        <a href="https://twitter.com/NXTByteNET" target="_blank"><span class="ti-twitter-alt"></span></a>
                    </div>
                </div>
            </div>
        </div>
</section>
<!--FOOTER AREA  END-->
<script src="<?= $frontUrl; ?>js/jquery.min.js"></script>
<script src="<?= $frontUrl; ?>js/bootstrap.min.js"></script>
<script src="<?= $frontUrl; ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= $frontUrl; ?>js/swiper.js"></script>
<script src="<?= $frontUrl; ?>js/beepup.js"></script>
<script src="<?= $frontUrl; ?>js/plugins.js"></script>
<script src="<?= $frontUrl; ?>js/main.js"></script>
<script src="<?= $frontUrl; ?>js/ajax-mail.js"></script>
<script src="<?= $frontUrl; ?>js/ajax-subscribe.js"></script>
<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.blog-slider', {
        spaceBetween: 30,
        effect: 'fade',
        loop: true,
        mousewheel:false,
        // autoHeight: true,
        pagination: {
            el: '.blog-slider__pagination',
            clickable: true,
        }
    });

    $('.tab-links li').on('click', function () {
        var swiper = new Swiper('.blog-slider', {
            spaceBetween: 30,
            effect: 'fade',
            loop: true,
            mousewheel:false,
            // autoHeight: true,
            pagination: {
                el: '.blog-slider__pagination',
                clickable: true,
            }
        });

    });
</script>
</body>
</html>