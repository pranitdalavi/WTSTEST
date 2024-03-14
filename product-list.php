<?php

use App\Product;
use App\ProductImage;

$productObj = new Product;
$productImageObj = new ProductImage;


if (isset($_GET['q'])) {

    $query = $productObj->search($_GET['q']);
    $title = 'You searched for... <br />' . $_GET['q'];
    $meta_title = COMPANY_NAME . ' | Search';

} elseif (strstr($url, '/new-in-shop')) {

    $query = $productObj->dealWeek();
    $title = 'NEW IN SHOP';
    $meta_title = COMPANY_NAME . ' | New In Shop';

} elseif (strstr($url, '/deal-of')) {

    $query = $productObj->dealDay();
    $title = 'DEAL OF THE DAY';
    $meta_title = COMPANY_NAME . ' | Deal of The Day';

} else {

    $query = $productObj->getAllByCategory($category_id);
    $title = $category_title;
    $meta_title = COMPANY_NAME . ' | ' . $category_title;

}

$attrObj = new \App\Attribute();
$attrImageObj = new \App\AttributeImage();

$categoryObj = new \App\Category();
$cat = $categoryObj->getData($slug);

require 'header.php';

?>

<style>
    @media (min-width: 1025px) {

        .same-height3 {
            height: 253px !important;
            overflow: hidden
        }

        .same-height3 img {
            max-height: 253px
        }

        .para-height {
            height: 60px !important;
            overflow: auto
        }

    }

    @media (min-width: 991px) and (max-width: 1024px) {

        .same-height3 {
            height: 205px !important;
            overflow: hidden
        }

        .same-height3 img {
            max-height: 205px
        }

        .para-height {
            height: 60px !important;
            overflow: auto
        }

    }

    @media (max-width: 320px) {

        .same-height3 {
            height: 110px !important;
            overflow: hidden
        }


    }

    @media (min-width: 321px) and (max-width: 375px) {

        .same-height3 {
            height: 120px !important;
            overflow: hidden
        }


    }

    @media (min-width: 376px) and (max-width: 414px) {

        .same-height3 {
            height: 150px !important;
            overflow: hidden
        }


    }
</style>

<script>
    $(function() {

        if (screen.width < 1025) {

            $('.same-height').matchHeight();

        }

    });
</script>


<script>
    function descText() {
        var x = document.getElementById("shortText");
        var y = document.getElementById("fullText");
        var a = document.getElementById("buttonTextLess");
        var b = document.getElementById("buttonTextMore");


        if (y.style.display === "none") {
            y.style.display = "block";
            x.style.display = "none";

            a.style.display = "block";
            b.style.display = "none";

        } else {
            x.style.display = "block";
            y.style.display = "none";

            a.style.display = "none";
            b.style.display = "block";
        }
    }

    // function myFunction() {
    //     var x = document.getElementById("myDIV");
    //     if (x.style.display === "none") {
    //         x.style.display = "block";
    //     } else {
    //         x.style.display = "none";
    //     }
    // }
</script>

<div class="container-fluid mt-30">




    <style>
        .container {
            width: 100% !important;
            max-width: 1600px !important;
        }
    </style>
    <div class="container" style="padding-left:  0 !important;padding-right: 0 !important;">

        <div class="row">

            <div class="col-lg-12 col-md-12">
                <h1 class="text-center mb-30 mt-0" style="font-weight: 600 !important;"><?= strtoupper($title) ?></h1>

                <?php $paraText = $cat[0]->info; ?>

                <p class="text-center" id="shortText" style="font-size: 16px;"><?php echo mb_strimwidth($paraText, 0, 300, "..."); ?></p>

                <p class="text-center" id="fullText" style="display:none; font-size: 16px;"><?= $cat[0]->info ?></p>


                <br />
                <button onclick="descText()" id="buttonTextMore" style="border: none;background: #3a004a !important;color: white;font-size: 14px;padding: 5px 20px;">Read More</button>

                <button onclick="descText()" id="buttonTextLess" style="border: none;background: #3a004a !important;color: white;font-size: 14px;padding: 5px 20px; display:none; ">Show Less</button>




               <div style="height: 25px; display:none;">
                   <br>
                   <br>
                   <style>
                       .bread{
                           font-size: 14px;
                       }
                   </style>
                   <a class="bread" href="<?= DOMAIN ?>">Home</a>
                   <?php

                   $carry = "";
                   $url = $_SERVER['REQUEST_URI'];
                   $slug2 = explode('/', $_SERVER['REQUEST_URI']);
                   $x = 0;
                   foreach ($slug2 as $value){
                       $true = $value;
                       $value = str_replace("-"," ", $value);
                       $value = str_replace("%20"," ", $value);


                       if($value != "" and $value != "comfortbeds"){

                           if($x == 0){
                               $carry .= $true;

                           }
                           else{
                               $carry .=  "/". $true ;
                           }
                           $x ++;
                           echo ' / <a class="bread" href="'. DOMAIN .'/'.$carry.'" style="text-transform: capitalize">'. $value .'</a>';
                       }
                   } ?>
               </div>
                <!-- <bR>
                <bR> -->
                <div class="">
                    <div class=" panel panel-default">
                        <div class="panel-body" style="padding: 15px;">
                            <div class=" mb-10 mt-10" style="transform: translate(10px,0)">
                                <?php echo count($query) ?> Results

                            </div>


                            <?php foreach ($query as $row) {

                                $image = $productImageObj->getRowByFieldNotDeleted('product_id', $row->id);

                            ?>

                                <div class=" col-md-3 col-xs-12 col-sm-6 mb-20" style="padding: 5px;">

                                    <div class=" mb-0" style="padding: 0 !important;border-radius:0px;">

                                        <div class="mb-10">

                                            <a href="<?= DOMAIN ?>/<?= $slug ?>/<?= $row->seo_url ?>">
                                                <img src="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" data-first="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" data-second="<?= DOMAIN ?>/product-images/<?= $images->id ?>.<?= $images->ext ?>" alt="<?= $images->alt ?>" alt="<?= $image->alt ?>" style="width: 100%;border-radius: 10px;">
                                            </a>
                                        </div>

                                        <a class="prod-list-link" href="<?= DOMAIN ?>/<?= $slug ?>/<?= $row->seo_url ?>">
                                            <p style="padding-left: 5px;font-size: 16px;font-weight: 500;" class="mb-0 text-left"><?= $row->title ?></p>

                                            <p style="padding-left: 5px;font-size: 24px;" class="orange text-left">

                                                <strong>
                                                    <?php

                                                    if ($row->special_offer_price) {

                                                    ?>
                                                        <span style=" color:black; font-weight:400; font-size:18px; "><s><?php print '£' . $row->price; ?></s></span>
                                                        <span style=" color:red; font-weight:600; font-size:22px; "> <?php print '£' . $row->special_offer_price; ?> </span>
                                                    <?php

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


                                                if (in_array("1", $cat) or in_array("2", $cat) or in_array("3", $cat) or in_array("4", $cat) or in_array("6", $cat) ) { ?>
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
                    <?php if (!count($query)) { ?>

                        <p class="text-center">There are no results for that query.</p>

                    <?php } ?>



                </div>
            </div>
        </div>



    </div>

</div>

<?php require 'footer.php'; ?>