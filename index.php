<?php

require __DIR__.'/routes.php';
require __DIR__ . '/includes/config.php';

use App\Product;
use App\ProductImage;
use App\GalleryImage;

$productObj = new Product;
$productImageObj = new ProductImage;
$galleryImageObj = new GalleryImage;
$categoryObj = new \App\Category();
$subscriberObj = new \App\Subscriber();
$bannerImages = $galleryImageObj->getAll();
$categories = $categoryObj->getAll();

if (isset($_POST["subscribe_email"])) {
    $subscriberObj->addNewSubscriber($_POST["subscribe_email"]);
}


require 'header.php';
?>

<?php
if (isset($_GET["subscribe"])) {
?>
    <script>
        $(document).ready(function() {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#subscribe").offset().top
            }, 500);
        })
    </script>

<?php
}

?>

<style>
    .container {
        width: 100% !important;
        max-width: 1500px !important;
    }

    html {
        scroll-behavior: smooth;
    }

    .heros .bg {
        background: rgba(0, 0, 0, .2);
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }

    .heros .center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 900px !important;
        width: 100%;
    }

    .heros .banner-title {
        font-size: 65px !important;
        font-weight: 700 !important;
        margin-bottom: 5px !important;
        text-align: left !important;
        margin-top: 5px !important;
    }

    .heros .banner-description {
        font-size: 26px !important;
        font-weight: 700 !important;
        margin-top: 5px !important;
        margin-bottom: 10px !important;
        text-align: left !important;
    }

    .heros .banner-button {
        margin-top: 25px;
        font-size: 18px !important;
        background: #3a004a !important;
        color: white;
        border-radius: 5px;
        border: none;
        padding: 3px;
        padding-left: 20px;
        padding-right: 20px;
        transition: .5s;
    }

    .heros .banner-button:hover {
        transition: .5s;
        opacity: .9;
    }

    @media(max-width: 767px) {
        .heros .banner-title {
            font-size: 35px !important;
        }

        .heros .banner-description {
            font-size: 18px !important;
        }

        .heros .banner-button {
            margin-top: 15px !important;
            font-size: 15px !important;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        .heros .center {
            width: 80%;
        }
    }

    @media(max-width: 991px) {
        .heros .center {
            max-width: 700px !important;
        }

        .inspiration-height {
            height: auto !important;
        }

        .inspiration-height div {
            position: relative !important;
            left: 0 !important;
            top: 0 !important;
            transform: none !important;
        }
    }

    @media(max-width: 767px) {
        #a1 {
            padding-right: 10px !important;
        }

        #a2 {
            padding-left: 10px !important;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center" style="font-weight: 600;">Expertly crafted in West Yorkshire</h2>
            <p style="font-size: 15px;text-align: center">
                We believe that a good night’s sleep is essential to a happy life. That’s why we are dedicated to<Br>
                delivering only the best in bespoke beds and mattresses for all your comfort needs.All our products<Br>
                are manufactured in the UK, using British materials and are built to last!
            </p>
        </div>
    </div>
</div>

<div class="container categories-desktop" style="margin-top: 30px;">
    <style>
        @media(max-width: 991px) {
            .categories-desktop {
                display: none;
            }
        }

        @media(min-width: 991px) {
            #categories-mobile {
                display: none;
            }

        }

        .darken {
            filter: brightness(60%)
        }
    </style>
    <div class="row categories">
        <div class="col-md-4 col" style="padding: 10px;margin: auto;margin: 0 auto;">

            <a href="<?= DOMAIN ?>/divan-beds">

                <img class="darken" src="<?= DOMAIN ?>/category-images/53.jpg" style="width: 100%;border-radius: 15px;">
                <div style="position: absolute;left:50%;top:50%;transform: translate(-50%,-50%)">


                    <p class="mb-0 text-center" style="color:white;text-decoration: none !important;font-size: 30px;">
                        Divan Beds </p>
                    <div class="text-center mt-10">
                        <button class="btn btn-primary" style="background: white !important;color:#333 !important;border-radius: 15px !important;padding-top: 2px !important;padding-bottom: 2px !important;padding-left: 15px !important;padding-right: 15px !important;font-weight: 500 !important;border: none !important;">SHOP NOW</button>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col" style="padding: 10px;margin: auto;margin: 0 auto;">

            <a href="<?= DOMAIN ?>/ottoman-beds">

                <img class="darken" src="<?= DOMAIN ?>/category-images/65.jpg" style="width: 100%;border-radius: 15px;">
                <div style="position: absolute;left:50%;top:50%;transform: translate(-50%,-50%)">


                    <p class="mb-0 text-center" style="color:white;text-decoration: none !important;font-size: 30px;">
                        Ottoman Beds </p>
                    <div class="text-center mt-10">
                        <button class="btn btn-primary" style="background: white !important;color:#333 !important;border-radius: 15px !important;padding-top: 2px !important;padding-bottom: 2px !important;padding-left: 15px !important;padding-right: 15px !important;font-weight: 500 !important;border: none !important;">SHOP NOW</button>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col" style="padding: 10px;margin: auto;margin: 0 auto;">

            <a href="<?= DOMAIN ?>/bed-frames">

                <img class="darken" src="<?= DOMAIN ?>/category-images/109.jpg" style="width: 100%;border-radius: 15px;">
                <div style="position: absolute;left:50%;top:50%;transform: translate(-50%,-50%)">


                    <p class="mb-0 text-center" style="color:white;text-decoration: none !important;font-size: 30px;">
                        Bed Frames </p>
                    <div class="text-center mt-10">
                        <button class="btn btn-primary" style="background: white !important;color:#333 !important;border-radius: 15px !important;padding-top: 2px !important;padding-bottom: 2px !important;padding-left: 15px !important;padding-right: 15px !important;font-weight: 500 !important;border: none !important;">SHOP NOW</button>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-offset-2 col" style="padding: 10px;">

            <a href="<?= DOMAIN ?>/headboards">

                <img class="darken" src="<?= DOMAIN ?>/category-images/125.jpg" style="width: 100%;border-radius: 15px;">
                <div style="position: absolute;left:50%;top:50%;transform: translate(-50%,-50%)">


                    <p class="mb-0 text-center" style="color:white;text-decoration: none !important;font-size: 30px;">
                        Headboards </p>
                    <div class="text-center mt-10">
                        <button class="btn btn-primary" style="background: white !important;color:#333 !important;border-radius: 15px !important;padding-top: 2px !important;padding-bottom: 2px !important;padding-left: 15px !important;padding-right: 15px !important;font-weight: 500 !important;border: none !important;">SHOP NOW</button>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col" style="padding: 10px;margin: auto;margin: 0 auto;">

            <a href="<?= DOMAIN ?>/mattresses">

                <img class="darken" src="<?= DOMAIN ?>/category-images/silk_1000.jpg" style="width: 100%;border-radius: 15px;">
                <div style="position: absolute;left:50%;top:50%;transform: translate(-50%,-50%)">


                    <p class="mb-0 text-center" style="color:white;text-decoration: none !important;font-size: 30px;">
                        Mattresses </p>
                    <div class="text-center mt-10">
                        <button class="btn btn-primary" style="background: white !important;color:#333 !important;border-radius: 15px !important;padding-top: 2px !important;padding-bottom: 2px !important;padding-left: 15px !important;padding-right: 15px !important;font-weight: 500 !important;border: none !important;">SHOP NOW</button>

                    </div>
                </div>
            </a>
        </div>



    </div>
</div>

<div class="container" id="categories-mobile" style="margin-top: 30px;">
    <div class="row">
        <div class="col-md-12">
            <div id="slick-categories-homepage">
                <?php
                foreach ($categories as $category) { ?>
                    <div class="  mb-10" style="position: relative !important;">
                        <a href="<?= DOMAIN ?>/<?= $category->seo_url ?>" style="">
                            <img class="darken" src="<?= DOMAIN ?>/category-images/<?= $category->id ?>.jpg" style="width: 100%;border-radius: 15px;">
                            <div style="position: absolute;left:50%;top:50%;transform: translate(-50%,-50%);width: 100%;">


                                <p class="mb-0 text-center" style="color:white;text-decoration: none !important;font-size: 24px;width: 100%;">
                                    <?= $category->title ?>
                                </p>
                                <div class="text-center mt-10">
                                    <button class="btn btn-primary" style="background: white !important;color:#333 !important;border-radius: 15px !important;padding-top: 2px !important;padding-bottom: 2px !important;padding-left: 15px !important;padding-right: 15px !important;font-weight: 500 !important;border: none !important;">SHOP NOW</button>

                                </div>
                            </div>
                        </a>
                    </div>

                <?php }
                ?>
            </div>
        </div>



    </div>
</div>

<div class="container">
    <style>
        .top-offer-title {
            font-size: 25px;
            font-weight: 600;
            margin-bottom: 0px;
        }

        .top-offer-block {
            position: absolute;
            right: 15%;
            top: 50%;
            transform: translate(-15%, -50%);
            color: white;
            text-align: center
        }

        @media(max-width: 550px) {
            .top-offer-title {
                font-size: 19px !important;
            }

            .top-offer-block {
                right: 5%;
                transform: translate(-5%, -50%);
            }
        }
    </style>
    <div class="row" style="display: none">
        <div class="col-md-12 mb-20">
            <h2 class="text-center" style="font-weight: 600;">Discover Our Top Offers</h2>
        </div>
        <div class="col-md-6 mb-10">
            <div style="position: relative">
                <img src="<?php echo DOMAIN ?>/images/comfort%20beds%20bed.png" style="width: 100%;border-radius: 5px;">
                <div class="top-offer-block">
                    <p class="top-offer-title">SAVE 10%</p>
                    <p>on Divans<br>and Ottomans</p>
                </div>


            </div>
        </div>
        <div class="col-md-6 mb-10">
            <div style="position: relative">
                <img src="<?php echo DOMAIN ?>/images/comfort%20beds%20pillows.png" style="width: 100%;border-radius: 5px;">
                <div class="top-offer-block">
                    <p class="top-offer-title">Every Bed</p>
                    <p>Gets 2 FREE<br /> Pillows </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-20" style="background: #ebe6ed;">
    <div class="row">
        <div class="col-md-12 mb-00">
            <h2 class="text-center mt-30" style="font-weight: 600;color:#461954">Sleep Tight With Our Luxurious Mattresses</h2>
            <p class="text-center" style="color:#461954;font-weight: 500 !important;">Choose your perfect bed with your ideal...</p>

        </div>
    </div>
    <div class="container" style="max-width: 1300px !important;">
        <div class="row">
            <div class="col-md-12">
                <div id="bed-icons" class="mt-30 mb-30">
                    <div>
                        <img class="bed-icon" src="<?= DOMAIN ?>/images/ruler-combined-solid.svg" style="width: 100%;max-width: 40px;margin: auto">
                        <!-- <img class="bed-icon" src="<?= DOMAIN ?>/images/bed%20cat%20icon.png" style="width: 100%;max-width: 40px;margin: auto"> -->
                        <p class="text-center mt-10" style="color:#461954;font-weight: 500 !important;">Bed Size</p>
                    </div>
                    <div>
                        <img class="bed-icon" src="<?= DOMAIN ?>/images/palette-solid.svg" style="width: 100%;max-width: 40px;margin: auto">
                        <!-- <img class="bed-icon" src="<?= DOMAIN ?>/images/material%20cat%20icon.png" style="width: 100%;max-width: 40px;margin: auto"> -->
                        <p class="text-center mt-10" style="color:#461954;font-weight: 500 !important;">Colour and Material</p>
                    </div>
                    <div>
                        <img class="bed-icon" src="<?= DOMAIN ?>/images/bed-solid.svg" style="width: 100%;max-width: 45px;margin: auto">
                        <!-- <img class="bed-icon" src="<?= DOMAIN ?>/images/headboard%20icon0.png" style="width: 100%;max-width: 45px;margin: auto"> -->
                        <p class="text-center mt-10" style="color:#461954;font-weight: 500 !important;">Headboard</p>
                    </div>
                    <div>
                        <img class="bed-icon" src="<?= DOMAIN ?>/images/storage0.svg" style="width: 100%;max-width: 50px;margin: auto">
                        <!-- <img class="bed-icon" src="<?= DOMAIN ?>/images/storage%20cat%20icon.png" style="width: 100%;max-width: 50px;margin: auto"> -->
                        <p class="text-center mt-10" style="color:#461954;font-weight: 500 !important;">Storage Options</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

$attrObj = new \App\Attribute();
$attrImageObj = new \App\AttributeImage();

?>
<div class="container-fluid">
    <div class="container mt-10">
        <h2 style="font-size: 30px;font-weight: 600 !important;text-align: center;margin-bottom: 35px;">Our Best Sellers</h2>
        <div class="row mb-20">

            <style>
                .slick-slide a {
                    outline: none !important;
                }

                .slick-slide a:focus {
                    outline: none !important;
                }

                .slick-slide a,
                .slick-slide:focus * {
                    outline: none !important;
                }
            </style>
            <div id="slick-products-homepage" style="padding-left: 5px;padding-right: 5px;">
                <?php
                foreach ($productObj->getAllForHomepage() as $row) {
                    $categories = [];
                    $row->category_id = str_replace('"', "", $row->category_id);
                    $row->category_id = str_replace('[', "", $row->category_id);
                    $row->category_id = str_replace(']', "", $row->category_id);

                    foreach (explode(",", $row->category_id) as $cat) {

                        $data = $categoryObj->getDataById($cat)[0];

                        array_push($categories, $data->seo_url);
                        break;
                    }


                    $image = $productImageObj->getRowByFieldNotDeleted('product_id', $row->id);
                ?>
                    <div class="" style="padding: 5px;">

                        <div class=" mb-0" style="padding: 0 !important;border-radius:0px;">

                            <div class="mb-10">
                                <a href="<?= DOMAIN ?>/<?= $categories[0] ?>/<?= $row->seo_url ?>">
                                    <!-- <img src="<?= DOMAIN ?>/product-images-thumbnails/<?= $image->id ?>.<?= $image->ext ?>" data-first="<?= DOMAIN ?>/product-images-thumbnails/<?= $image->id ?>.<?= $image->ext ?>" data-second="<?= DOMAIN ?>/product-images-thumbnails/<?= $image->id ?>.<?= $image->ext ?>" alt="<?= $image->alt ?>" alt="<?= $image->alt ?>" style="width: 100%;border-radius: 10px;"> -->
                                    <div style='background-image: url("<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>"); background-color: #cccccc;background-position: center;background-repeat: no-repeat;background-size: cover;position: relative;height: 250px;width: 100%;border-radius: 10px;'></div>

                                </a>
                            </div>

                            <a class="prod-list-link" href="<?= DOMAIN ?>/<?= $categories[0] ?>/<?= $row->seo_url ?>">
                                <p style="padding-left: 5px;font-size: 16px;font-weight: 500;" class="mb-0 text-left"><?= $row->title ?></p>

                                <p style="padding-left: 5px;font-size: 24px;" class="orange text-left">

                                    <strong>
                                        <?php
                                        if ($row->special_offer_price) {

                                            print '£' . $row->special_offer_price;
                                        } else {

                                            print '£' . $row->price;
                                        }

                                        ?>
                                    </strong>

                                </p>
                                <div class="">
                                    <?php
                                    $row->category_id = str_replace('"', "", $row->category_id);
                                    $row->category_id = str_replace('[', "", $row->category_id);
                                    $row->category_id = str_replace(']', "", $row->category_id);
                                    $cat = explode(",", $row->category_id);



                                    if (in_array("1", $cat) or in_array("2", $cat) or in_array("3", $cat) or in_array("4", $cat) or in_array("6", $cat)) { ?>
                                        <div class="col-xs-6" style="padding-left: 5px;">
                                            <img src="<?= DOMAIN ?>/images/color-1.png" style="width: 20px;display: inline-block;border-radius: 100%;">
                                            <img src="<?= DOMAIN ?>/images/color-2.png" style="width: 20px;display: inline-block;border-radius: 100%;">
                                            <img src="<?= DOMAIN ?>/images/color-3.png" style="width: 20px;display: inline-block;border-radius: 100%;">
                                            <img src="<?= DOMAIN ?>/images/color-4.png" style="width: 20px;display: inline-block;border-radius: 100%;">
                                        </div>
                                    <?php } else {
                                    }

                                    $col = "col-xs-12";
                                    if (in_array("1", $cat) or in_array("2", $cat) or in_array("3", $cat) or in_array("4", $cat) or in_array("6", $cat)) {
                                        $col = "col-xs-6";
                                    }
                                    ?>

                                    <div class="<?= $col ?>" style="padding: 0;">
                                        <button style="border:1px solid lightgray;padding-left: 15px;padding-right: 15px;width: 100%;transform: translate(0,2px);border-radius: 20px;background: white;font-size: 15px;">VIEW NOW</button>

                                    </div>
                                </div>
                            </a>
                        </div>


                    </div>

                <?php } ?>
            </div>


        </div>
    </div>
</div>


<div class="container">
    <?php require("reviewsio.php"); ?>
</div>


<?php require 'footer.php'; ?>