(function ($) {
    "use strict";

    jQuery(document).ready(function ($) {


        $('.slider-wrapper').on('init', function (e, slick) {
            var $firstAnimatingElements = $('div.slider-single-item:first-child').find('[data-animation]');
            doAnimations($firstAnimatingElements);
        });
        $('.slider-wrapper').on('beforeChange', function (e, slick, currentSlide, nextSlide) {
            var $animatingElements = $('div.slider-single-item[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
            doAnimations($animatingElements);
        });
        $('.slider-wrapper').slick({
            autoplay: true,
            autoplaySpeed: 7000,
            dots: false,
            fade: true,
            cssEase: 'cubic-bezier(0.7, 0, 0.3, .1)',
        });

        function doAnimations(elements) {
            var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            elements.each(function () {
                var $this = $(this);
                var $animationDelay = $this.data('delay');
                var $animationType = 'animated ' + $this.data('animation');
                $this.css({
                    'animation-delay': $animationDelay,
                    '-webkit-animation-delay': $animationDelay
                });
                $this.addClass($animationType).one(animationEndEvents, function () {
                    $this.removeClass($animationType);
                });
            });
        }

 

        //WOW ANIMATION

        new WOW().init();

        //sticky nav

        $(".stick").sticky({
            topSpacing: 0,
        });


     $(".bpws-wrapper").mCustomScrollbar({theme:"minimal"});



        //data center


        $('.map-icon').hover(function () {
            $(this).prev().toggleClass('show');
        });

        $('.info-window').hover(function () {
            $(this).toggleClass('show');
        });

        //pricing-tab-switcher

        $('.pricing-tab-switcher').on('click', function () {
            $(this).toggleClass('active');

            $('.pricing-amount').toggleClass('change-subs-duration');
        });

        //MOBILE MENU

        $('#mainmenu').slicknav({
            prependTo: '.navigation'
        });


        //NICE SELECT

        $('select').niceSelect();


        // COUNTER UP

        $(".counter").counterUp({
            delay: 10,
            time: 5000
        });

        // about-slider

        $('.about-slider').slick({
            fade: true
        });


        $('.testimonial-carousel').slick({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            nextArrow: $('.testi-nav-right'),
            prevArrow: $('.testi-nav-left'),
            responsive: [
                {
                    breakpoint:900,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });


        $(".service-teatimonial").slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            nextArrow: $('.service-nav-right'),
            prevArrow: $('.service-nav-left'),
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $(".owl-carousel.team-carosuel").owlCarousel({
            items: 4,
            loop: true,
            nav: true,
            navText: ["<span class='ti-angle-left'>", "<span class='ti-angle-right'>"],
            autoplay: false,
            dots: false,
            mouseDrag: false,
            margin: 30,
            responsiveClass: 'owl-reponsive-' + 'breakpoint',
          responsiveClass: true,
          responsiveRefreshRate: true,
            responsive: {
                0: {
                    items: 1,
                },
                500: {
                    items: 2,
                },
                960: {
                    items: 3,
                },
                1000: {
                    items: 4,
                }
            }
        });


        $('.owl-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplaySpeed: 600,
            responsiveClass: 'owl-reponsive-' + 'breakpoint',
              responsiveClass: true,
              responsiveRefreshRate: true,
              responsive : {
                  0 : {
                      items: 1
                  },
                  768 : {
                      items: 3
                  },
                  960 : {
                      items: 4
                  },
                  1200 : {
                      items: 5
                  },
                  1920 : {
                      items: 5
                  }
              }
        });


        $('.owl-carousel.all-famework-carsouel').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplaySpeed: 600,
            responsiveClass: 'owl-reponsive-' + 'breakpoint',
              responsiveClass: true,
              responsiveRefreshRate: true,
              responsive : {
                  0 : {
                      items: 1
                  },
                  768 : {
                      items: 3
                  },
                  960 : {
                      items: 4
                  },
                  1200 : {
                      items: 5
                  },
                  1920 : {
                      items: 5
                  }
              }
        });


        //DATE COUNTDOWN 

        $('[data-countdown]').each(function () {
            var $this = $(this),
                finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function (event) {
                $this.html(event.strftime(
                    '<div class="cdown"><span class="days"><strong>%-D</strong><p>Days.</p></span></div><div class="cdown"><span class="hour"><strong> %-H</strong><p>Hours.</p></span></div> <div class="cdown"><span class="minutes"><strong>%M</strong> <p>MINUTES.</p></span></div><div class="cdown"><span class="second"><strong> %S</strong><p>SECONDS.</p></span></div>'
                ));
            });
        });



    });





    //TAB ANIMATAION SLIDE

    jQuery('.tabs.animated-slide-2 .tab-links a').on('click', function(e) {
        var currentAttrValue = jQuery(this).attr('href');

        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).slideDown(400).siblings().slideUp(400);

        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

        e.preventDefault();
    });
    //TAB ANIMATAION SLIDE

    jQuery('.nav.nav-tabs a').on('click', function(e) {
        var currentAttrValue = jQuery(this).attr('href');

        // Show/Hide Tabs
        jQuery('.beefup' + currentAttrValue).slideDown(400).siblings().slideUp(400);

        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

        e.preventDefault();













    });


        


    $(window).on('load', function(){ 
        $('.preloder').fadeOut(800);
        $('.preloader-wrapper').delay(800).fadeOut('slow');


    });



}(jQuery));