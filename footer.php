



<script type="text/javascript" src="<?= DOMAIN ?>/slick/slick.min.js"></script>
<style>
    /* the slides */
    .slick-slide {
        margin: 0 5px;
    }

    /* the parent */
    .slick-list {
        margin: 0 -5px;
    }

    .footer-heading {
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 30px;
    }

    .footer * {
        color: white;
    }

    .footer .text {
        font-size: 16px;
        margin-bottom: 0;
    }

    .footer .text a {
        font-size: 16px;
        color: white !important;
    }

    .leave-review {
        padding-left: 20px;
        padding-right: 20px;
        border-radius: 20px;
        border: 1px solid white;
        background: transparent !important;
        font-size: 16px;
        font-weight: 600;
    }

    @media(max-width: 767px) {
        .footer * {
            text-align: center;
        }

        .footer .col-md-3 {
            margin-top: 40px;
        }

        .footer .col-md-3:first-child {
            margin-top: 0px !important;
        }

        .footer .footer-heading {
            margin-bottom: 10px !important;
        }
    }
</style>
<script>
    $("#slick-product-list-images").slick({
        dots: true,
        slidesToShow: 6,
        rows: 1,
        slidesToScroll: 6,
        autoplay: true,
        infinite: false,
        autoplaySpeed: 1000,
        arrows: false,
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
        ],
        spacing: 2,
        prevArrow: "<div class='' style='position: absolute !important;left:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-left'></i></div>",
        nextArrow: "<div class='' style='position: absolute !important;right:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-right'></i></div>"
    });
    $("#slick-icons-hp").slick({
        dots: false,
        slidesToShow: 4,
        rows: 1,
        slidesToScroll: 4,
        autoplay: true,
        infinite: true,
        autoplaySpeed: 1500,
        arrows: false,
        spacing: 2,
        responsive: [

            {
                breakpoint: 1200,
                settings: {
                    arrows: false,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 920,
                settings: {
                    arrows: false,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 650,
                settings: {
                    arrows: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ],
        prevArrow: "<div class='' style='position: absolute !important;left:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px;cursor:pointer;padding:10px;color:white;' class='fas fa-chevron-left'></i></div>",
        nextArrow: "<div class='' style='position: absolute !important;right:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px;cursor:pointer;padding:10px;color:white;' class='fas fa-chevron-right'></i></div>"
    });
    $("#slick-images").slick({
        dots: false,
        slidesToShow: 1,
        rows: 1,
        slidesToScroll: 1,
        autoplay: true,
        infinite: true,
        autoplaySpeed: 3000,
        arrows: false,
        spacing: 2,
        responsive: [

            {
                breakpoint: 500,
                settings: {
                    arrows: false
                }
            },
        ],
        prevArrow: "<div class='' style='position: absolute !important;left:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px;cursor:pointer;padding:10px;color:white;' class='fas fa-chevron-left'></i></div>",
        nextArrow: "<div class='' style='position: absolute !important;right:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px;cursor:pointer;padding:10px;color:white;' class='fas fa-chevron-right'></i></div>"
    });
    $("#bed-icons").slick({
        dots: false,
        slidesToShow: 4,
        rows: 1,
        slidesToScroll: 4,
        autoplay: true,
        infinite: true,
        autoplaySpeed: 2000,
        arrows: false,
        lazyLoad: false,
        spacing: 2,
        responsive: [

            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
        ]
    });
    $("#slick-categories-homepage").slick({
        dots: false,
        slidesToShow: 3,
        rows: 1,
        slidesToScroll: 3,
        autoplay: true,
        infinite: true,
        autoplaySpeed: 3000,
        arrows: false,
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                }
            },
        ],
        spacing: 2,
        prevArrow: "<div class='' style='position: absolute !important;left:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-left'></i></div>",
        nextArrow: "<div class='' style='position: absolute !important;right:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-right'></i></div>"
    });



    $("#slick-related-products").slick({
        dots: true,
        slidesToShow: 4,
        rows: 1,
        slidesToScroll: 4,
        autoplay: false,
        infinite: false,
        autoplaySpeed: 3000,
        arrows: false,
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
        ],
        spacing: 2,
        prevArrow: "<div class='' style='position: absolute !important;left:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-left'></i></div>",
        nextArrow: "<div class='' style='position: absolute !important;right:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-right'></i></div>"
    });

    $("#slick-products-homepage").slick({
        dots: true,
        slidesToShow: 4,
        rows: 1,
        slidesToScroll: 4,
        autoplay: false,
        infinite: false,
        autoplaySpeed: 3000,
        arrows: false,
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ],
        spacing: 2,
        prevArrow: "<div class='' style='position: absolute !important;left:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-left'></i></div>",
        nextArrow: "<div class='' style='position: absolute !important;right:0px !important;top:50% !important;transform: translate(0,-50%) !important;z-index: 1111 !important;'><i style='font-size: 35px !important;cursor:pointer;padding:10px;color:white;' class='fas fa-caret-right'></i></div>"
    });
</script>

<script>
    $(function() {

        $('.sub-banner-icons').matchHeight({
            byRow: false
        });
        $('.inspiration-height').matchHeight({
            byRow: false
        });
        $('.mailing-height').matchHeight({
            byRow: false
        });
        $('.swatches').matchHeight({
            byRow: false
        });
        $('.dim1-height').matchHeight({
            byRow: false
        });

    });
</script>


<div class="container-fluid footer" style="background: #222222;padding-top: 30px;padding-bottom: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <p class="footer-heading"><?= COMPANY_NAME ?></p>
                <p class="text">25 Mount Street</p>
                <p class="text">Bradford, West Yorkshire</p>
                <p class="text mb-30" style="margin-bottom: 20px !important;">BD4 8TA</p>

                <p class="text mb-0">
                    <a style="font-weight: 600;" href="tel:0113 418 0408">0113 418 0408</a>
                </p>
                <p class="text mb-30" style="margin-bottom: 20px !important;">
                    <a style="font-weight: 600;word-break: break-all" href="mailto:info@comfortbedsltd.co.uk">info@comfortbedsltd.co.uk</a>
                </p>

                <p class="text mb-0" style="font-weight: 600;">
                    Mon - Fri
                </p>
                <p class="text" style="font-weight: 600;">
                    9:00am - 5:00pm
                </p>

            </div>
            <div class="col-md-3 col-sm-3">
                <p class="footer-heading">Our Products</p>
                <?php
                $categoryObj = new \App\Category();

                foreach ($categoryObj->getAll() as $category) { ?> 
                    <p class="text" style="margin-bottom: 5px !important;">
                        <a href="<?= DOMAIN ?>/<?= $category->seo_url ?>">
                            <?= $category->title ?>
                        </a>
                    </p>
                <?php }
                ?>
                
            </div>
            <div class="col-md-3 col-sm-3">
                <p class="footer-heading">More Information</p>

                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/about-us">About Us</a>
                </p>
                
                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/contact-us">Contact Us</a>
                </p>
                
                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/faqs">FAQs</a>
                </p>
                
                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/warranty">Warranty Policy</a>
                </p>

                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/swatches">Order Swatches</a>
                </p>

                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/beds-birmingham">Beds Birmingham</a>
                </p>

                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/beds-derby">Beds Derby</a>
                </p>

                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/beds-leeds">Beds Leeds</a>
                </p>

                <p class="text" style="margin-bottom: 5px !important;">
                    <a href="<?= DOMAIN ?>/beds-manchester">Beds Manchester</a>
                </p>

            </div>
            <div class="col-md-3 col-sm-3">
                <p class="footer-heading">Payment Options</p>




                <img src="<?= DOMAIN ?>/images/payment-stripe.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                <img src="<?= DOMAIN ?>/images/payment-paypal.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                <img src="<?= DOMAIN ?>/images/payment-google.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                <img src="<?= DOMAIN ?>/images/payment-apple.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                <img src="<?= DOMAIN ?>/images/payment-clearpay.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                <img src="<?= DOMAIN ?>/images/payment-klarna.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                <img src="<?= DOMAIN ?>/images/payment-visa.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                <img src="<?= DOMAIN ?>/images/payment-cash.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">


            </div>
        </div>
    </div>
</div>


<div class="container-fluid visible-lg visible-md visible-sm" style="background: #ffffff">
    <!-- <p style="margin-bottom: 0;color:#333 !important;padding: 5px;text-align: center;font-size: 16px;font-weight: 600;">
        Copyright <= date("Y") ?> <= COMPANY_NAME ?> <span style="margin-left: 25px;margin-right: 25px;"></span> Web Design by <a style="color:#333;" href="https://www.wtstechnologies.co.uk/" target="_blank">WTS Technologies</a>
    </p> -->

    <div class="row">
        <div class="col-md-12">
            <p style="margin-bottom: 0;color:#333 !important;padding: 5px;text-align: center;font-size: 16px;font-weight: 600;">
                Copyright <?= date("Y") ?> <?= COMPANY_NAME ?>
            </p>
        </div>
    </div>

    <div class="col-md-12">
        <p style="margin-bottom: 0;color:#333 !important;font-weight: 400;padding: 0px 0px 10px 0px;text-align: center;font-size: 12px;">
        <a href="<?= DOMAIN ?>/delivery-information">Delivery & Returns</a> | <a href="<?= DOMAIN ?>/privacy-policy">Privacy Policy</a> | <a href="<?= DOMAIN ?>/terms-conditions">Terms & Conditions</a> 
        </p>
    </div>


</div>
<div class="container-fluid visible-xs" style="background: #ffffff">

<div class="row">

    <div class="col-md-12">
        <!-- <p style="margin-bottom: 0;color:#333 !important;font-weight: 400;padding: 10px;text-align: center;font-size: 15px;">
            Copyright <?= date("Y") ?> <= COMPANY_NAME ?><br>
            Website by <a style="color:#333 !important;" href="https://www.wtstechnologies.co.uk/" target="_blank">WTS Technologies</a>
        </p> -->

        <p style="margin-bottom: 0;color:#333 !important;text-align: center;font-size: 15px;font-weight: 600;">
        Copyright <?= date("Y") ?> <?= COMPANY_NAME ?></p>
    </div>


    <div class="col-md-12">
        <p style="margin-bottom: 0;color:#333 !important;text-align: center;font-size: 12px;font-weight: 400; padding:0px 0px 5px 0px">
            <a href="<?= DOMAIN ?>/delivery-information">Delivery & Returns</a> | <a href="<?= DOMAIN ?>/privacy-policy">Privacy Policy</a> | <a href="<?= DOMAIN ?>/terms-conditions">Terms & Conditions</a> 
        </p>
    </div>


</div>
    
</div>



</body>

</html>