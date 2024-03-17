<?php



use App\Product;
use App\ProductImage;

$productObj = new Product;
$productImageObj = new ProductImage;
$categoryObj = new \App\Category();


$row = $productObj->getRowByFieldNotDeleted('seo_url', explode("?", $slug)[0]);

if (!$row) {

    include('404.php');
    exit;
}
if (isset($_POST["email-share"])) {
    \App\Helpers\Mail::shareEmail($row, $_POST["send-to"]);
}

if ($row->cross_sell_ids) {

    $crossSellsArray = json_decode($row->cross_sell_ids);
    $newCrossSell = [];
    foreach ($crossSellsArray as $crossSell) {

        if (!$productObj->find($crossSell)->deleted_at) {

            $newCrossSell[] = $crossSell;
        }
    }
}

$attributes = json_decode($row->attributes);


if (isset($_POST['product_id'])) {

    $cartObj->add();
    if ($_POST["installation"] == "on") {
        $installation = $productObj->getById(2);
        $cartObj->addExtra($installation[0]->id, 1, $installation[0]->price, $_POST["sku"]);
    }
    if ($_POST["removal"] == "on") {
        $removal = $productObj->getById(3);

        $cartObj->addExtra($removal[0]->id, 1, $removal[0]->price, $_POST["sku"]);
    }
    if ($_POST["mattress"] != "") {
        $mattress = $productObj->getById($_POST["mattress"]);

        $cartObj->addExtra($mattress[0]->id, $_POST["quantity"], $mattress[0]->price, $_POST["sku"]);
    }

    header("Location: " . DOMAIN . "/cart");
}

$cat = $row->category_id;
$cat = str_replace("[", "", $cat);
$cat = str_replace("]", "", $cat);
$cat = str_replace('"', "", $cat);
$cat = explode(",", $cat);

$relatedProducts = $productObj->relatedProducts($row->id, $cat);



$meta_title = COMPANY_NAME . ' | ' .
    $row->title;
$attrObj = new \App\Attribute();
$attrImageObj = new \App\AttributeImage();

require('header.php');


?>

<script>
    fbq('track', 'ViewContent', {
        content_ids: ['<?= $row->id ?>'], // 'REQUIRED': array of product IDs
        content_type: 'product', // RECOMMENDED: Either product or product_group based on the content_ids or contents being passed.
    });
</script>

<meta property="og:url" content="<?= DOMAIN ?><?= $_SERVER['REQUEST_URI']; ?>">

<meta property="product:retailer_item_id" content="<?= $row->id ?>">

<meta property="product:brand" content="Comfort Beds">

<meta property="product:availability" content="in stock">

<meta property="product:condition" content="new">

<meta property="og:title" content="<?= $row->title ?>">


<?php

$description10 = nl2br($row->long_description);

$description10 = str_replace('</p><br />', '</p>', $description10);
$description10 = str_replace('</li><br />', '</li>', $description10);
$description10 = str_replace('<ul><br />', '<ul>', $description10);
$description10 = str_replace('<ul><br />', '<ul>', $description10);
$description10 = str_replace('</ul><br />', '</ul>', $description10);
$description10 = str_replace('<table><br />', '<table>', $description10);
$description10 = str_replace('<tbody><br />', '<tbody><ul>', $description10);
$description10 = str_replace('<tr><br />', '<tr>', $description10);
$description10 = str_replace('</th><br />', '</th>', $description10);
$description10 = str_replace('</td><br />', '</td>', $description10);
$description10 = str_replace('</tr><br />', '</tr>', $description10);
$description10 = str_replace('><br />', '>', $description10);


// $descriptionFacebookNew = nl2br($row->long_description);
$descriptionOG = strip_tags($description10);

?>

<meta property="og:description" content="<?= $descriptionOG; ?>">




<meta property="product:price:amount" content="<?= $row->special_offer_price ? $row->special_offer_price : $row->price ?>">

<meta property="product:price:currency" content="GBP">

<?php

$i = 1;

foreach ($productImageObj->getAll($row->id) as $product_image) {

?>


    <meta property="og:image" content="<?= DOMAIN ?>/product-images/<?= $product_image->id ?>.<?= $product_image->ext ?>">

    <meta property="og:additional_image_link" content="<?= DOMAIN ?>/product-images/<?= $product_image->id ?>.<?= $product_image->ext ?>">


<?php $i++;
} ?>



<script>
    $(document).ready(function() {
        $("#slick-actions").hide();
    })
</script>
<Script>
    $(document).ready(function (){
        setTimeout(function (){
            $("#fabric-button").click();
            clearTimeout(this);
        },1000);
        


    })
    console.log("ready")

    function run(size) {
        console.log(size)

        if (size != "") {


            for (let i = 0; i < $(".item").length; i++) {

                console.log($($($(".items")).find(".items-item")[i]))

                $($($(".items")).find(".items-item")).eq(size).click();



            }




        } else {

            for (let i = 0; i < $(".item").length; i++) {
                $($(".items")[i]).find(".items-item").eq(0).click();
            }
            $('html,body').scrollTop(0);
        }


    }
    $(document).ready(function() {
        run("<?php if(isset($_GET["size"])) {
                    echo $_GET["size"];
                } ?>");
    });
</Script>
<style>
    ul {
        list-style-image: url('<?= DOMAIN ?>/images/circle-check-regular (2).svg') !important;
        font-size: 20px;
    }

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

    #slick-images .slick-dots {
        bottom: 10px !important;
    }

    #slick-images .slick-dots li.slick-active button:before {
        color: white !important;
        font-size: 10px;
    }

    #slick-images .slick-dots li button:before {
        color: white !important;
        font-size: 8px;
    }

    #slick-images .slick-dotted.slick-slider {
        margin-bottom: 0 !important;
    }

    #slick-products-homepage .slick-dots li.slick-active button:before {

        font-size: 10px;
    }

    #slick-categories-homepage .slick-dots li.slick-active button:before {

        font-size: 10px;
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


    /* the slides */
    #slick-icons-hp .slick-slide {
        margin: 0 20px;
    }

    /* the parent */
    #slick-icons-hp .slick-list {
        margin: 0 -20px;
    }
</style>

<form action="" method="post" class="mt-20">
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #F5F5F5;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
            background: #fff;
            margin-bottom: 30px
        }
    </style>
    <script>
        $(function() {
            $('.option-select').change(function() {
                if (this.value != '') {
                    var options = this.value.split('-');


                    for (let i = 0; i < $(".carousel-indicators").find("img").length; i++) {
                        if ($($(".carousel-indicators").find("img")[i]).attr("alt").toUpperCase().includes(options[0].toUpperCase())) {
                            $($(".carousel-indicators").find("img")[i]).click();
                        }
                    }

                    var price = options[1].trim();
                    price = Number(price);
                    price = price.toFixed(2);
                    $('#show-price').html('<span class="red"> NOW &pound;' + price + '</span>');

                    $('#cart_price').val(price);
                }
            });
        });
    </script>
    <script>
        function openCity(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

    <?php if (count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes())) {   ?>



    <?php } ?>


    <style>
        .container {
            width: 100% !important;
            max-width: 1600px !important;
        }
    </style>



    <div class="container" style="height: 35px;padding-left: 5px !important;">

        <style>
            .bread {
                font-size: 14px;
            }
        </style>
        <a class="bread" href="<?= DOMAIN ?>">ome</a>
        <?php

        $carry = "";
        $url = $_SERVER['REQUEST_URI'];
        $slug2 = explode('/', $_SERVER['REQUEST_URI']);
        $x = 0;
        foreach ($slug2 as $value) {
            $true = $value;
            $value = str_replace("-", " ", $value);
            $value = str_replace("%20", " ", $value);


            if ($value != "" and $value != "comfortbeds") {

                if ($x == 0) {
                    $carry .= $true;
                } else {
                    $carry .=  "/" . $true;
                }
                $x++;
                echo ' / <a class="bread" href="' . DOMAIN . '/' . $carry . '" style="text-transform: capitalize">' . $value . '</a>';
            }
        }
        ?>
    </div>
    <div class="container pt-0 pl-0 pr-0">

        <div class="container-fluid pb-0  pl-0 pr-0">




            <div class="panel panel-default mt-0 mb-0">
                <div class="panel-body pb-30">
                    <?php require __DIR__ . '/includes/flash-messages.php'; ?>


                    <div class="row mt-10">




                        <div class="col-md-6">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                                <div class="carousel-inner" role="listbox">

                                    <?php

                                    $i = 1;

                                    foreach ($productImageObj->getAll($row->id) as $product_image) {

                                    ?>

                                        <?php

                                        $imageLlink = DOMAIN . "/product-images/" . $product_image->id . "." . $product_image->ext;

                                        $imageLlinkAdditional = DOMAIN . "/product-images/" . $product_image->id . "." . $product_image->ext;

                                        ?>




                                        <div class="item <?php if ($i == 1) { ?>active <?php } ?> pl-0-mob pr-0-mob">
                                            <a href="<?= DOMAIN ?>/product-images/<?= $product_image->id ?>.<?= $product_image->ext ?>" data-lightbox="set" data-title="<?= $row->title ?> <?= $i ?>"> <img style="width: 100%;" class="img-responsive main-image" src="<?= DOMAIN ?>/product-images/<?= $product_image->id ?>.<?= $product_image->ext ?>" alt="<?= $product_image->alt ?> Main"> </a>
                                        </div>

                                    <?php $i++;
                                    } ?>

                                    <?php if (count($productImageObj->getAll($row->id)) > 1) {  // don't show left and right arrows if there is only 1 image  
                                    ?>

                                        <!-- Controls -->
                                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                            <i class="fa fa-chevron-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                            <i class="fa fa-chevron-right"></i>
                                            <span class="sr-only">Next</span>
                                        </a>

                                    <?php } ?>
                                </div>




                                <div class="main-image row" style="padding-top: 10px;padding-bottom: 0px;width: 100% !important;">
                                    <?php

                                    $i = 0;

                                    foreach ($productImageObj->getAll($row->id) as $product_image) {

                                    ?>
                                        <div class="col-lg-2 col-md-3 col-sm-2 col-xs-3 mb-10" style="padding: 0px;padding-right: 5px;padding-left: 5px;">
                                            <div data-target="#myCarousel" style="" data-slide-to="<?= $i ?>" <?php if ($i == 0) { ?>class=" active <?php if (count($productImageObj->getAll($row->id)) == 1) {
                                                                                                                                                        print 'hidden-xs';
                                                                                                                                                    }  ?> " <?php } ?>>
                                                <img style="width: 100%;" class="" src="<?= DOMAIN ?>/product-images/<?= $product_image->id ?>.<?= $product_image->ext ?>" alt="<?= $product_image->alt ?> Thumb">
                                            </div>
                                        </div>

                                    <?php $i++;
                                    } ?>


                                </div>


                            </div>
                            <div class="visible-md visible-lg">
                                <style>
                                    .switch {
                                        position: relative;
                                        display: inline-block;
                                        width: 54px;
                                        height: 28px;
                                    }

                                    .switch input {
                                        opacity: 0;
                                        width: 0;
                                        height: 0;
                                    }

                                    .slider {
                                        position: absolute;
                                        cursor: pointer;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        bottom: 0;
                                        background-color: #ccc;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                    }

                                    .slider:before {
                                        position: absolute;
                                        content: "";
                                        height: 20px;
                                        width: 20px;
                                        left: 4px;
                                        bottom: 4px;
                                        background-color: white;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                    }

                                    input:checked+.slider {
                                        background-color: #3a004a !important;
                                    }

                                    input:focus+.slider {
                                        box-shadow: 0 0 1px #3a004a !important;
                                    }

                                    input:checked+.slider:before {
                                        -webkit-transform: translateX(26px);
                                        -ms-transform: translateX(26px);
                                        transform: translateX(26px);
                                    }

                                    /* Rounded sliders */
                                    .slider.round {
                                        border-radius: 34px;
                                    }

                                    .slider.round:before {
                                        border-radius: 50%;
                                    }

                                    .addons {
                                        background: #f2f2f2;
                                        border-radius: 5px;
                                        padding: 15px;
                                        font-size: 17px;
                                    }
                                </style>
                                <?php

                                $row->category_id = str_replace('"', "", $row->category_id);
                                $row->category_id = str_replace('[', "", $row->category_id);
                                $row->category_id = str_replace(']', "", $row->category_id);
                                $cat = explode(",", $row->category_id);




                                if ($row->category_id = "1") { ?>
                                    <meta property="product:item_group_id" content="1">
                                    <meta property="product:category" content="505764">
                                    <meta property="product:google_product_category" content="505764">
                                    <meta property="google_product_category" content="505764">

                                <?php } elseif ($row->category_id = "2") { ?>
                                    <meta property="product:item_group_id" content="2">
                                    <meta property="product:category" content="505764">
                                    <meta property="product:google_product_category" content="505764">
                                    <meta property="google_product_category" content="505764">

                                <?php } elseif ($row->category_id = "3") { ?>
                                    <meta property="product:item_group_id" content="3">
                                    <meta property="product:category" content="505764">
                                    <meta property="product:google_product_category" content="505764">
                                    <meta property="google_product_category" content="505764">

                                <?php } elseif ($row->category_id = "4") { ?>
                                    <meta property="product:item_group_id" content="4">
                                    <meta property="product:category" content="451">
                                    <meta property="product:google_product_category" content="451">
                                    <meta property="google_product_category" content="451">

                                <?php } elseif ($row->category_id = "5") { ?>
                                    <meta property="product:item_group_id" content="5">
                                    <meta property="product:category" content="2696">
                                    <meta property="product:google_product_category" content="2696">
                                    <meta property="google_product_category" content="2696">

                                <?php } else {
                                }


                                if (in_array("1", $cat) or in_array("2", $cat) or in_array("3", $cat) or in_array("4", $cat) or in_array("5", $cat) or in_array("6", $cat)) { ?>







                                    <div class="mt-20 addons">
                                        <?php

                                        $installation = $productObj->getById(2);

                                        ?>
                                        <?= $installation[0]->title ?> (£<?= $installation[0]->price ?>)
                                        <label class="switch" style="float: right;">
                                            <input type="checkbox" name="installation">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <!-- <div class="mt-20 addons">
                                        <php

                                        $removal = $productObj->getById(3);

                                        ?>
                                        <= $removal[0]->title ?> (£<= $removal[0]->price ?>)
                                        <label class="switch" style="float: right;">
                                            <input type="checkbox" name="removal">
                                            <span class="slider round"></span>
                                        </label>
                                    </div> -->
                                    <style>
                                        .btn-yes {
                                            background: transparent !important;
                                            border: 1px solid #3a004a !important;
                                            color: #333 !important;
                                            border-radius: 40px;
                                            min-width: 60px;
                                            transition: .5s;
                                            padding: 4px;
                                        }

                                        .btn-no {
                                            background: #3a004a !important;
                                            border: 1px solid #3a004a !important;
                                            color: white !important;
                                            border-radius: 40px;
                                            min-width: 60px;
                                            padding: 4px;
                                            transition: .5s;
                                        }

                                        .add-mattress {
                                            background: transparent !important;
                                            border: 1px solid #3a004a !important;
                                            color: #333 !important;
                                            border-radius: 40px;
                                            min-width: 80px;
                                            transition: .5s;
                                            padding: 7px;
                                            display: inline-block;
                                            margin: 0 !important;

                                        }

                                        .remove-mattress {
                                            background: #3a004a !important;
                                            border: 1px solid #3a004a !important;
                                            color: white !important;
                                            border-radius: 40px;
                                            min-width: 80px;
                                            transition: .5s;
                                            padding: 7px;

                                        }

                                        .btn-yes:hover {
                                            background: #3a004a !important;
                                            color: white !important;
                                            transition: .5s;
                                            border: 1px solid #3a004a !important;
                                        }

                                        .remove-mattress:hover {
                                            background: #3a004a !important;
                                            color: white !important;
                                            transition: .5s;
                                            border: 1px solid #3a004a !important;
                                        }

                                        .btn-no:hover {
                                            background: #3a004a !important;
                                            color: white !important;
                                            transition: .5s;
                                            border: 1px solid #3a004a !important;

                                        }

                                        .add-mattress:hover {
                                            background: #3a004a !important;
                                            color: white !important;
                                            transition: .5s;
                                            border: 1px solid #3a004a !important;

                                        }

                                        .right-btns {
                                            position: absolute;
                                            right: 10px;
                                            top: 50%;
                                            transform: translate(0, -50%);
                                        }

                                        .mattress-img {
                                            max-width: 85px;
                                        }

                                        .mattress-td {
                                            width: 120px;
                                        }

                                        @media(min-width: 600px) {}

                                        .remove-mattress {
                                            display: none;
                                        }

                                        @media(max-width: 600px) {
                                            .mattress-td {
                                                width: 60px;
                                            }

                                            .mattress-img {
                                                max-width: 65px;
                                            }


                                        }
                                    </style>

                                    <?php
                                    $url = 'https://www.' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                                    if (strpos($url, 'mattresses') !== false) {
                                    } else { ?>

                                        <div class="mt-20 addons" style="position: relative">
                                            Upgrade your Mattress & get 2 FREE pillows
                                            <div class="right-btns">
                                                <button onclick="openMattresses(this)" id="mattress-yes" class="btn btn-primary btn-yes" type="button">Yes</button>
                                                <button onclick="NoMattresses(this)" id="mattress-no" class="btn btn-primary btn-no" type="button">No</button>
                                            </div>
                                        </div>

                                    <?php } ?>

                                <?php } ?>

                            </div>
                            <script>
                                function openMattresses(that) {
                                    $(that).removeClass("btn-yes").addClass("btn-no");
                                    $(that).blur();
                                    $("#mattress-no").removeClass("btn-no").addClass("btn-yes");
                                    $("#mattresses").show();
                                }

                                function NoMattresses(that) {
                                    $(that).removeClass("btn-yes").addClass("btn-no");
                                    $("#mattress-yes").removeClass("btn-no").addClass("btn-yes");
                                    $(that).blur();

                                    $("#mattresses").hide();
                                    $("#mattress").val("")
                                    $(".mattress-item").show();
                                    $(".add-mattress").show();
                                    $(".remove-mattress").hide();
                                }


                                function openMattresses2(that) {
                                    $(that).removeClass("btn-yes").addClass("btn-no");
                                    $(that).blur();
                                    $("#mattress-no2").removeClass("btn-no").addClass("btn-yes");
                                    $("#mattresses2").show();
                                }

                                function NoMattresses2(that) {
                                    $(that).removeClass("btn-yes").addClass("btn-no");
                                    $("#mattress-yes2").removeClass("btn-no").addClass("btn-yes");
                                    $(that).blur();

                                    $("#mattresses2").hide();
                                    $("#mattress").val("")
                                    $(".mattress-item").show();
                                    $(".add-mattress").show();
                                    $(".remove-mattress").hide();
                                }

                                function addMattress(id, that) {
                                    $(".mattress-item").hide();
                                    $(that).parent().parent().parent().parent().show();
                                    $("#mattress").val(id)
                                    $(that).hide();
                                    $(that).parent().find(".remove-mattress").show();

                                }

                                function removeMattress(that) {
                                    $("#mattress").val("")
                                    $(that).parent().find(".add-mattress").show();
                                    $(".mattress-item").show();
                                    $(".remove-mattress").hide();
                                }
                            </script>

                            <div class="mat1" style="display: none" id="mattresses">
                                <script>

                                </script>
                                <?php
                                foreach ($productObj->getMattressesNew(5) as $mattress) {
                                    $categories = [];
                                    $mattress->category_id = str_replace('"', "", $mattress->category_id);
                                    $mattress->category_id = str_replace('[', "", $mattress->category_id);
                                    $mattress->category_id = str_replace(']', "", $mattress->category_id);

                                    foreach (explode(",", $mattress->category_id) as $cat) {

                                        $data = $categoryObj->getDataById($cat)[0];

                                        array_push($categories, $data->seo_url);
                                        break;
                                    }

                                    $image = $productImageObj->getRowByFieldNotDeleted('product_id', $mattress->id);
                                ?>
                                    <table class="table mb-5 mt-5 mattress-item" style="font-size: 15px;">
                                        <tr>
                                            <td style="width: 75px;vertical-align: middle;padding:3px;border:0;">
                                                <a class="mattress-links" href="<?= DOMAIN ?>/<?= $categories[0] ?>/<?= $mattress->seo_url ?>?" style="display: inline-block">
                                                    <img src="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" alt="<?= $image->alt ?>" class="mattress-img">
                                                </a>
                                            </td>
                                            <td style="vertical-align: middle;padding:3px;border:0;">
                                                <span class="mb-5 mt-0" style="text-align: left;font-weight: 400 !important;"><?= $mattress->title ?></span><Br>
                                                <span style="color:#333;font-weight: 600 !important;margin-bottom: 17px;text-align: left;">
                                                    <?php
                                                    if ($mattress->special_offer_price) {

                                                        print '<span class="red"><strike>£' . $mattress->price . '</strike></span> £' . $mattress->special_offer_price;
                                                    } else {

                                                        print '£' . $mattress->price;
                                                    }
                                                    ?>
                                                </span>
                                            </td>

                                            <td class="mattress-td" style="vertical-align: middle;padding:3px;border:0;text-align: right">
                                                <a class="mattress-links" href="<?php echo DOMAIN ?>/<?= $categories[0] ?>/<?= $mattress->seo_url ?>" target="_blank">
                                                    <button class="btn btn-primary add-mattress" type="button">VIEW</button>

                                                </a>

                                            </td>
                                        </tr>
                                    </table>



                                <?php } ?>
                            </div>

                        </div>



                        <div class="col-md-6 pt-20-mob">

                            <h1 style="font-weight:600 !important;"><span style="margin-right: 15px;"><?= $row->title ?></span></h1>


                            <?php

                            $weight = $row->weight;
                            $last_number = substr($weight, -1);
                            $weight = number_format(floatval($row->weight), 2);
                            if ($last_number == 0) {

                                $weight = number_format(floatval($row->weight), 1);
                            }

                            ?>


                            <hr>

                            <p style="font-size:12px; font-weight: 400;"><i class="fa fa-check-circle-o" style="color:green" aria-hidden="true"></i> Free Delivery Within 3 - 7 Working Days</p>

                            <div class="mt-20" id="long_description" style="font-size: 15px ">

                                <style>
                                    @media(max-width: 991px) {
                                        #long_description_desktop {
                                            display: none;
                                        }
                                    }
                                </style>
                                <div id="long_description_desktop">

                                    <?php
                                    function limit_text($text, $limit)
                                    {
                                        if (str_word_count($text, 0) > $limit) {
                                            $words = str_word_count($text, 2);
                                            $pos   = array_keys($words);
                                            $text  = substr($text, 0, $pos[$limit]) . '<span style="color:#3490dc;cursor: pointer;" onclick="scrollToDescription(this)">Read more</span>';
                                        }
                                        return $text;
                                    }

                                    $description = nl2br($row->description);

                                    $description = str_replace('</p><br />', '</p>', $description);
                                    $description = str_replace('</li><br />', '</li>', $description);
                                    $description = str_replace('<ul><br />', '<ul>', $description);
                                    $description = str_replace('<ul><br />', '<ul>', $description);
                                    $description = str_replace('</ul><br />', '</ul>', $description);
                                    $description = str_replace('<table><br />', '<table>', $description);
                                    $description = str_replace('<tbody><br />', '<tbody><ul>', $description);
                                    $description = str_replace('<tr><br />', '<tr>', $description);
                                    $description = str_replace('</th><br />', '</th>', $description);
                                    $description = str_replace('</td><br />', '</td>', $description);
                                    $description = str_replace('</tr><br />', '</tr>', $description);
                                    $description = str_replace('><br />', '>', $description);

                                    print($description);




                                    ?>


                                </div>

                            </div>





                            <?php if ($row->product_status) { ?>

                                <div class="row mt-20">
                                    <script>
                                        /*
                              $($("img")[i]).click();

                             */
                                        $(document).ready(function() {
                                            $(".aaa")[0].click();
                                        });

                                        function findColorImage(that, value, index) {

                                            for (let i = 0; i < $(".left-thumb").length; i++) {


                                                if ($($(".left-thumb")[i]).attr("alt").toLowerCase().includes(value.toLowerCase())) {
                                                    $("#color-name").text(value);
                                                    $(".left-thumb").css({
                                                        border: "none"
                                                    });
                                                    $(that).css({
                                                        border: "2px solid #c5a864"
                                                    });

                                                    $($(".left-thumb")[i]).click();
                                                    $("#color-select").prop("selectedIndex", parseInt(index) + 1);
                                                    break;

                                                }
                                            }

                                        }
                                    </script>







                                </div>



                                <div class="row">



                                    <input type="hidden" name="product_id" value="<?= $row->id ?>" />
                                    <input type="hidden" id="price" value="<?= $row->special_offer_price ? $row->special_offer_price : $row->price ?>" />


                                    <input type="hidden" id="cart_price" name="cart_price" value="<?= $row->special_offer_price ? $row->special_offer_price : $row->price ?>" />


                                    <input type="hidden" name="sku" id="sku" value="<?= $row->sku ?>" />


                                    <?php

                                    $overallPrice = $row->special_offer_price ? $row->special_offer_price : $row->price;

                                    $max = $row->qty_available > 10 ? 10 : $row->qty_available;

                                    ?>



                                </div>
                                <input name="payment_route" value="0" id="payment_route" type="hidden">

                                <input type="hidden" id="userIP" name="userIP" value="<?= $_SERVER["REMOTE_ADDR"] ?>" />
                                

                                <?php

                                $cookie_name = "CustomerSource";

                                if (isset($_COOKIE[$cookie_name])) {
                                    $customerSource = $_COOKIE[$cookie_name];
                                } else {
                                    $customerSource = 'none';
                                }
                                ?>
                                <input name="customerSource" value="<?= $customerSource ?>" id="customerSource" type="hidden">

                                <?php
                                $row->connected = str_replace('"', "", $row->connected);

                                $connected = explode(",", $row->connected);
                                $row->connected = $connected;
                                $attributeObj = new \App\Attribute();
                                $attributeImageObj = new \App\AttributeImage();

                                $addons = [];
                                $addonsIndex = [];
                                $raw = [];

                                if ($row->connected[0] != "false") {
                                    foreach ($connected as $item) {
                                        array_push($raw, $attributeObj->getById($item));
                                    }
                                    foreach ($raw as $item) {
                                        if (!in_array($item[0]->attribute, $addonsIndex)) {
                                            array_push($addonsIndex, $item[0]->attribute);
                                            array_push($addons, [
                                                "attribute" => $item[0]->attribute,
                                                "items" => []
                                            ]);
                                        }
                                    }

                                    foreach ($addons as $key => $addon) {
                                        foreach ($raw as $item) {

                                            if ($addon["attribute"] == $item[0]->attribute) {
                                                array_push($addons[$key]["items"], $item[0]);
                                            }
                                        }
                                    }
                                }





                                ?>
                                <style>
                                    .toggle-btna {
                                        font-size: 14px;
                                        position: absolute;
                                        top: 50%;
                                        right: 10px;
                                        transform: translate(0, -50%);
                                        padding: 4px;
                                        transition: .5s;
                                        border-radius: 10px;
                                    }

                                    .toogle-heading {
                                        position: relative;
                                        font-size: 16px;
                                    }

                                    .toogle-heading:hover .toggle-btna {
                                        background: #3a004a !important;
                                        transition: .5s;
                                        cursor: pointer;
                                        color: white;
                                        padding: 4px;
                                        border-radius: 10px;
                                    }

                                    .price-tag {
                                        position: absolute;
                                        left: 0px;
                                        border-radius: 0px;
                                        top: 0px;
                                        background: #3a004a;
                                        padding-left: 15px;
                                        padding-right: 15px;
                                        width: 100%;
                                        font-size: 14px;
                                        font-weight: 500;
                                        color: white;
                                    }

                                    .selector-tag {
                                        position: absolute;
                                        left: 0px;
                                        border-radius: 0px;
                                        top: 0px;
                                        background: #3a004a;
                                        width: 100%;
                                        padding-left: 15px;
                                        padding-right: 15px;
                                        font-size: 14px;
                                        font-weight: 500;
                                        color: white;
                                        display: none;
                                    }

                                    .item {
                                        border: 2px solid transparent;
                                        cursor: pointer;
                                    }

                                    .items .active {
                                        border: 2px solid #3a004a;
                                    }

                                    @media(max-width: 991px) {
                                        .head-font {
                                            font-size: 15px !important;
                                        }
                                    }
                                </style>

                                <script>
                                    let original = <?php if ($row->special_offer_price) {
                                                        print $row->special_offer_price;
                                                    } else {
                                                        print $row->price;
                                                    } ?>;




                                    let total = 0;
                                    let prices = [];
                                    let descriptions = [];

                                    let newIssue = <?php if ($row->special_offer_price) {
                                                        $priceDiff = $row->price - $row->special_offer_price;
                                                        print $priceDiff;
                                                    } else {
                                                        $priceDiff = $row->price - 100;
                                                        print $priceDiff;
                                                    } ?>;


                                    let counterBotClick = 0;

                                    var attributeForMattress = "";

                                    function attributeAdd(index, price, that, name, limit, vals) {



                                        counterBotClick++;
                                        if (vals == "Bed Size") {
                                            if (limit == "limiter") {
                                                for (let i = 0; i < $(".items-item").length; i++) {
                                                    if ($($(".items-item")[i]).attr("data-storage") == "limited") {
                                                        $($(".items-item")[i]).hide();
                                                    }
                                                }
                                            } else {
                                                for (let i = 0; i < $(".items-item").length; i++) {
                                                    if ($($(".items-item")[i]).attr("data-storage") == "limited") {
                                                        $($(".items-item")[i]).show();
                                                    }
                                                }

                                            }



                                            for (let i = 0; i < $(".items-item").length; i++) {
                                                if ($($(".items-item")[i]).attr("data-triggerm") != "") {
                                                    $($(".items-item")[i]).hide();

                                                }
                                                if ($(that).attr("data-showm") != "") {
                                                    for (let j = 0; j < $(".items-item").length; j++) {
                                                        if ($($(".items-item")[j]).attr("data-triggerm") == $(that).attr("data-showm")) {
                                                            $($(".items-item")[j]).show();
                                                            $($(".items-item")[j]).click();
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $(that).parent().parent().hide()


                                        if ($(".items").length < counterBotClick) {
                                            $($(".items")[parseInt(index) + 1]).show();

                                        }
                                        try {
                                            if ($(".items").length < counterBotClick) {
                                                $($(".items")[parseInt(index) + 1]).show();
                                                $([document.documentElement, document.body]).animate({
                                                    scrollTop: $($(".items")[parseInt(index) + 1]).offset().top - 100
                                                }, 0);

                                            }
                                        } catch (err) {

                                        }



                                        $(that).parent().find(".checks").hide();
                                        $(that).find(".checks").show();
                                        if (vals == "Bed Size") {
                                            attributeForMattress = $(that).find(".secret-item-index").text();
                                            console.log(attributeForMattress)
                                            for (let i = 0; i < $(".mattress-links").length; i++) {
                                                $($(".mattress-links")[i]).attr("href", ($($(".mattress-links")[i]).attr("href").split("?")[0] + "?size=" + attributeForMattress))

                                            }
                                        }
                                        $(that).parent().find(".price-tag").show();
                                        $(that).parent().find(".selector-tag").hide();
                                        $(that).find(".price-tag").hide();
                                        $(that).find(".selector-tag").show();
                                        prices[index] = price;
                                        descriptions[parseInt(index) + 1] = name;

                                        calculcatePrice();

                                    }

                                    function calculcatePrice() {
                                        total = 0;
                                        for (let i = 0; i < prices.length; i++) {
                                            if (prices[i] != null) {
                                                total += parseFloat(prices[i]);

                                            }

                                        }
                                        total += original;
                                        $("#extra").val(total)


                                        $("#summ").show();
                                        $("#extra_description").val("");
                                        let texts = "";
                                        for (let i = 0; i < descriptions.length; i++) {
                                            if (descriptions[i] != undefined) {
                                                texts += "," + descriptions[i];

                                            }
                                        }
                                        $("#extra_description").val(texts.substring(1));
                                        $("#base-price").text((original * parseInt($("#qty-value").val())).toFixed(2));
                                        $("#options-price").text(((total - original) * parseInt($("#qty-value").val())).toFixed(2));

                                        $("#was-price").text(((total + newIssue) * parseInt($("#qty-value").val())).toFixed(2));


                                        $("#total-price").text((total * parseInt($("#qty-value").val())).toFixed(2));


                                        $("#price").val((total));

                                        $("#price-Top").val((total));

                                        $("#cart_price").val((total));

                                    }


                                </script>
                                <div>
                                    <?php
                                    foreach ($addons as $key => $addon) { ?>
                                        <div class="panel panel-default mb-20" style="background: transparent;">
                                            <div class="panel-heading toogle-heading head-font" onclick="$(this).parent().find('.panel-body').toggle()" style="padding-left: 65px">
                                                <?php
                                                if (strtoupper($addon["attribute"]) == "BED SIZE") { ?>
                                                    <img src="<?= DOMAIN ?>/images/bed%20cat%20icon.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "MATTRESS SIZE") { ?>
                                                    <img src="<?= DOMAIN ?>/images/bed%20cat%20icon.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "HEADBOARD SIZE") { ?>
                                                    <img src="<?= DOMAIN ?>/images/bed%20cat%20icon.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "MATERIALS") { ?>
                                                    <img src="<?= DOMAIN ?>/images/material%20cat%20icon.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "HEADBOARD") { ?>
                                                    <img src="<?= DOMAIN ?>/images/headboard%20cat%20icon.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "HEADBOARDS") { ?>
                                                    <img src="<?= DOMAIN ?>/images/headboard%20icon0.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "HEADBOARDS (FOOTBOARD INCLUDED)") { ?>
                                                    <img src="<?= DOMAIN ?>/images/headboard%20icon0.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }

                                                if (strtoupper($addon["attribute"]) == "HEADBOARDS / STUDS (FOOTBOARD INCLUDED)") { ?>
                                                    <img src="<?= DOMAIN ?>/images/headboard%20icon0.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }

                                                if (strtoupper($addon["attribute"]) == "HEADBOARDS / STUDS") { ?>
                                                    <img src="<?= DOMAIN ?>/images/headboard%20icon0.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }

                                                if (strtoupper($addon["attribute"]) == "STORAGE") { ?>
                                                    <img src="<?= DOMAIN ?>/images/storage%20cat%20icon.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "STORAGE OPTIONS") { ?>
                                                    <img src="<?= DOMAIN ?>/images/comfort%20beds%20storage%20icons-18.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "BUTTONS") { ?>
                                                    <img src="<?= DOMAIN ?>/images/Buttons%20Icons-26.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                if (strtoupper($addon["attribute"]) == "MATTRESS") { ?>
                                                    <img src="<?= DOMAIN ?>/images/comfort%20beds%20icons-29.png" style="width: 60px;position: absolute;left:0px;top:50%;transform: translate(0,-50%);">
                                                <?php }
                                                ?>
                                                <?= $addon["attribute"] ?>
                                                <div class="toggle-btna">
                                                    toggle <i class="fa fa-chevron-down"></i>
                                                </div>
                                            </div>

                                            <div class="panel-body items" style="background: #f2f2f2 !important;display: none">
                                                <div class="row" style="position: relative">
                                                    <?php
                                                    $materialsGroups = [];
                                                    if (strtoupper($addon["attribute"]) == "MATERIALS" or strtoupper($addon["attribute"]) == "MATERIAL") {
                                                        $categories = $attrObj->getMaterialGroups();
                                                        foreach ($categories as $ca) {
                                                            array_push($materialsGroups, [
                                                                "name" => $ca->material_group,
                                                                "items" => []
                                                            ]);
                                                        }
                                                        foreach ($addon["items"] as $item) {
                                                            foreach ($materialsGroups as $keyA => $groupItem) {
                                                                if ($groupItem["name"] == $item->material_group) {
                                                                    array_push($materialsGroups[$keyA]["items"], $item);
                                                                }
                                                            }
                                                        }
                                                        if (count($materialsGroups) > 0) {
                                                            foreach ($materialsGroups as $q) {
                                                    ?>
                                                                <?php
                                                                if (count($q["items"]) > 0) { ?>
                                                                    <h4 class="ml-15"><?= $q["name"] ?></h4>
                                                                <?php }
                                                                ?>

                                                                <?php
                                                                if (count($q["items"]) > 0) {
                                                                    foreach ($q["items"] as $key3 => $item) {
                                                                        $image = $attributeImageObj->getRowByFieldNotDeleted('blog_id', $item->id);
                                                                ?>

                                                                        <div data-triggerm="<?= $item->trigger_mattress ?>" data-showm="<?= $item->show_mattress ?>" data-storage="<?= $item->storage_limit ?>" class="items-item q-<?= $key ?>" style="padding: 5px;width: 100px;display: inline-block" onclick="attributeAdd('<?= $key ?>','<?= $item->price ?>',this,'<?= $addon['attribute'] . ': ' . $item->name . "(" . $item->material_group . ")" ?>','<?= $item->storage_limit ?>','<?= $addon['attribute'] ?>')">
                                                                            <div class="item" style="position: relative;padding-top: 0px;">
                                                                                <div class="checks" style="display: none;color:White;font-size: 9px;text-align: center;line-height: 20px;width: 20px;height: 20px;background: #3a004a !important;border-radius: 100%;position: absolute;right:-5px;top:-5px;z-index: 112;">
                                                                                    <i class="fa fa-check"></i>
                                                                                </div>
                                                                                <div style="width: 100%;position: relative">
                                                                                    <?php
                                                                                    if (strtoupper($item->attribute) == "MATERIAL" or strtoupper($item->attribute) == "MATERIALS") { ?>
                                                                                        <img src="<?php echo DOMAIN ?>/images/grey-border.png" style="width: 100%;position: absolute;z-index: 111;left:0;top:0;">

                                                                                    <?php }
                                                                                    ?>
                                                                                    <img src="<?php echo DOMAIN ?>/attribute-images/<?= $image->id ?>.<?= $image->ext ?>" style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            <div style="font-size: 14px;">
                                                                                <span style="display:none;" class="secret-item-index"><?= $key3 ?></span>
                                                                                <?php if (isset($item->price) && $item->price == '0') { ?>

                                                                                    <p class="text-center mt-10"><span class="item-attr-name"><?= $item->name ?></span></p>

                                                                                    <?php } else {

                                                                                    if (str_contains($item->name, 'Chelsea Mattress')) {
                                                                                        echo "<p class='text-center mt-10'><span class='item-attr-name'>$item->name</span></p>";
                                                                                    } else { ?>
                                                                                        <p class='text-center mt-10'><span class='item-attr-name'><?= $item->name ?></span> <Br>+ £<?= number_format($item->price, 2) ?> </p>

                                                                                <?php }
                                                                                } ?>
                                                                            </div>

                                                                        </div>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>

                                                            <?php

                                                            }
                                                        }
                                                    } else {
                                                        foreach ($addon["items"] as $key3 => $item) {

                                                            $image = $attributeImageObj->getRowByFieldNotDeleted('blog_id', $item->id);
                                                            ?>

                                                            <div data-triggerm="<?= $item->trigger_mattress ?>" data-showm="<?= $item->show_mattress ?>" data-storage="<?= $item->storage_limit ?>" class="items-item q-<?= $key ?>" style="padding: 5px;width: 100px;float:left;" onclick="attributeAdd('<?= $key ?>','<?= $item->price ?>',this,'<?= $addon['attribute'] . ': ' . $item->name ?>','<?= $item->storage_limit ?>','<?= $addon['attribute'] ?>')">
                                                                <div class="item" style="position: relative;padding-top: 0px;">
                                                                    <div class="checks" style="display: none;color:White;font-size: 9px;text-align: center;line-height: 20px;width: 20px;height: 20px;background: #3a004a !important;border-radius: 100%;position: absolute;right:-5px;top:-5px;z-index: 112;">
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                    <div style="width: 100%;position: relative">
                                                                        <?php
                                                                        if (strtoupper($item->attribute) == "MATERIAL" or strtoupper($item->attribute) == "MATERIALS") { ?>
                                                                            <img src="<?php echo DOMAIN ?>/images/grey-border.png" style="width: 100%;position: absolute;z-index: 111;left:0;top:0;">

                                                                        <?php }
                                                                        ?>
                                                                        <img src="<?php echo DOMAIN ?>/attribute-images/<?= $image->id ?>.<?= $image->ext ?>" style="width: 100%;">
                                                                    </div>
                                                                </div>
                                                                <div style="font-size: 14px;">
                                                                    <span style="display:none;" class="secret-item-index"><?= $key3 ?></span>
                                                                    <?php

                                                                    /*if (isset($item->price) && $item->price == '0') {
                                                                    ?> <p class="text-center mt-10"><span class="item-attr-name"><?= $item->name ?></span></p> <?php } else {  ?> <p class="text-center mt-10"><span class="item-attr-name"><?= $item->name ?></span> <Br>£<?= number_format($item->price, 2) ?></p> 
                                                                    <?php  }*/
                                                                    ?>

                                                                    <?php if (isset($item->price) && $item->price == '0') { ?>

                                                                        <p class="text-center mt-10"><span class="item-attr-name"><?= $item->name ?></span></p>

                                                                        <?php } else {

                                                                        if (str_contains($item->name, 'Chelsea Mattress')) {
                                                                            echo "<p class='text-center mt-10'><span class='item-attr-name'>$item->name</span></p>";
                                                                        } else { ?>
                                                                            <p class='text-center mt-10'><span class='item-attr-name'><?= $item->name ?></span> <Br>+ £<?= number_format($item->price, 2) ?> </p>

                                                                    <?php }
                                                                    } ?>
                                                                </div>

                                                            </div>
                                                    <?php }
                                                    }





                                                    ?>
                                                </div>
                                               
                            <?php if (strtoupper($addon["attribute"]) == "HEADBOARDS / STUDS" ){ ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="fabric-button" style="width: 100%;padding: 3px !important;text-align: center;font-size: 15px;max-height: 31px;min-height: 31px" onclick="fabricButton(this);" class="fabricbutton switcher active mb-5 mt-5">
                                            Fabric Buttons
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div id="diamante-button" style="width: 100%;padding: 3px !important;text-align: center;font-size: 15px;max-height: 31px;min-height: 31px" onclick="diamanteButton(this);" class="switcher in-active mb-5 mt-5">
                                            Diamonte Buttons
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            ?>

                            <?php if (strtoupper($addon["attribute"]) == "HEADBOARDS / STUDS (FOOTBOARD INCLUDED)" ){ ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="fabric-button" style="width: 100%;padding: 3px !important;text-align: center;font-size: 15px;max-height: 31px;min-height: 31px" onclick="fabricButton(this);" class="fabricbutton switcher active mb-5 mt-5">
                                            Fabric Buttons
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div id="diamante-button" style="width: 100%;padding: 3px !important;text-align: center;font-size: 15px;max-height: 31px;min-height: 31px" onclick="diamanteButton(this);" class="switcher in-active mb-5 mt-5">
                                            Diamonte Buttons
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            ?>
                            

                                                <script>
                                                    
                                function fabricButton(that){
                                    $("#fabric-button").removeClass("in-active").addClass("active");
                                    $("#diamante-button").removeClass("active").addClass("in-active");

                                    for (let i = 0; i < descriptions.length; i++) {
                                        if(descriptions[i] == "Fabric Buttons"){
                                            descriptions.splice(i,1);
                                        }
                                        if(descriptions[i] == "Diamante Buttons"){
                                            descriptions.splice(i,1);
                                        }
                                    }
                                    if(!descriptions.includes("Fabric Buttons")){
                                        descriptions.push("Fabric Buttons");
                                        calculcatePrice();

                                    }


                                }
                                function diamanteButton(that) {
                                    $("#fabric-button").removeClass("active").addClass("in-active");
                                    $("#diamante-button").removeClass("in-active").addClass("active");
                                    for (let i = 0; i < descriptions.length; i++) {
                                        if(descriptions[i] == "Fabric Buttons"){
                                            descriptions.splice(i,1);
                                        }
                                        if(descriptions[i] == "Diamante Buttons"){
                                            descriptions.splice(i,1);
                                        }
                                    }
                                    if(!descriptions.includes("Diamante Buttons")){
                                        descriptions.push("Diamante Buttons");
                                        calculcatePrice();

                                    }

                                }



                                                </script>
                                            </div>
                                        </div>
                                        <script>
                                            $('.q-<?= $key ?>').matchHeight({
                                                byRow: false
                                            });
                                        </script>
                                    <?php } ?>

                                </div>
                                <div class="visible-sm visible-xs">
                                    <style>
                                        .switch {
                                            position: relative;
                                            display: inline-block;
                                            width: 54px;
                                            height: 28px;
                                        }

                                        .switch input {
                                            opacity: 0;
                                            width: 0;
                                            height: 0;
                                        }

                                        .slider {
                                            position: absolute;
                                            cursor: pointer;
                                            top: 0;
                                            left: 0;
                                            right: 0;
                                            bottom: 0;
                                            background-color: #ccc;
                                            -webkit-transition: .4s;
                                            transition: .4s;
                                        }

                                        .slider:before {
                                            position: absolute;
                                            content: "";
                                            height: 20px;
                                            width: 20px;
                                            left: 4px;
                                            bottom: 4px;
                                            background-color: white;
                                            -webkit-transition: .4s;
                                            transition: .4s;
                                        }

                                        input:checked+.slider {
                                            background-color: #3a004a !important;
                                        }

                                        input:focus+.slider {
                                            box-shadow: 0 0 1px #3a004a !important;
                                        }

                                        input:checked+.slider:before {
                                            -webkit-transform: translateX(26px);
                                            -ms-transform: translateX(26px);
                                            transform: translateX(26px);
                                        }

                                        /* Rounded sliders */
                                        .slider.round {
                                            border-radius: 34px;
                                        }

                                        .slider.round:before {
                                            border-radius: 50%;
                                        }

                                        .addons {
                                            background: #f2f2f2;
                                            border-radius: 5px;
                                            padding: 15px;
                                            font-size: 17px;
                                        }
                                    </style>

                                    <?php

                                    $row->category_id = str_replace('"', "", $row->category_id);
                                    $row->category_id = str_replace('[', "", $row->category_id);
                                    $row->category_id = str_replace(']', "", $row->category_id);
                                    $cat = explode(",", $row->category_id);


                                    if (in_array("1", $cat) or in_array("2", $cat) or in_array("3", $cat) or in_array("4", $cat) or in_array("5", $cat) or in_array("6", $cat)) { ?>
                                        <div class="mt-20 addons" style="padding-right: 70px;position: relative;font-size: 15px;">
                                            <?php

                                            $installation = $productObj->getById(2);

                                            ?>
                                            <?= $installation[0]->title ?> (£<?= $installation[0]->price ?>)
                                            <label class="switch" style="position: absolute;right:10px;top:50%;transform: translate(0,-50%)">
                                                <input type="checkbox" name="installation">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <!-- <div class="mt-20 addons" style="padding-right: 70px;position: relative;font-size: 15px;">
                                            <php

                                            $removal = $productObj->getById(3);

                                            ?>
                                            <= $removal[0]->title ?> (£<= $removal[0]->price ?>)
                                            <label class="switch" style="position: absolute;right:10px;top:50%;transform: translate(0,-50%)">
                                                <input type="checkbox" name="removal">
                                                <span class="slider round"></span>
                                            </label>
                                        </div> -->
                                        <style>
                                            .btn-yes {
                                                background: transparent !important;
                                                border: 1px solid #3a004a !important;
                                                color: #333 !important;
                                                border-radius: 40px;
                                                min-width: 60px;
                                                transition: .5s;
                                                padding: 4px;
                                            }

                                            .btn-no {
                                                background: #3a004a !important;
                                                border: 1px solid #3a004a !important;
                                                color: white !important;
                                                border-radius: 40px;
                                                min-width: 60px;
                                                padding: 4px;
                                                transition: .5s;
                                            }

                                            .add-mattress {
                                                background: transparent !important;
                                                border: 1px solid #3a004a !important;
                                                color: #333 !important;
                                                border-radius: 40px;
                                                min-width: 80px;
                                                transition: .5s;
                                                padding: 7px;
                                                display: inline-block;
                                                margin: 0 !important;

                                            }

                                            .remove-mattress {
                                                background: #3a004a !important;
                                                border: 1px solid #3a004a !important;
                                                color: white !important;
                                                border-radius: 40px;
                                                min-width: 80px;
                                                transition: .5s;
                                                padding: 7px;

                                            }

                                            .btn-yes:hover {
                                                background: #3a004a !important;
                                                color: white !important;
                                                transition: .5s;
                                                border: 1px solid #3a004a !important;
                                            }

                                            .remove-mattress:hover {
                                                background: #3a004a !important;
                                                color: white !important;
                                                transition: .5s;
                                                border: 1px solid #3a004a !important;
                                            }

                                            .btn-no:hover {
                                                background: #3a004a !important;
                                                color: white !important;
                                                transition: .5s;
                                                border: 1px solid #3a004a !important;

                                            }

                                            .add-mattress:hover {
                                                background: #3a004a !important;
                                                color: white !important;
                                                transition: .5s;
                                                border: 1px solid #3a004a !important;

                                            }

                                            .right-btns {
                                                position: absolute;
                                                right: 10px;
                                                top: 50%;
                                                transform: translate(0, -50%);
                                            }

                                            .mattress-img {
                                                max-width: 85px;
                                            }

                                            .mattress-td {
                                                width: 120px;
                                            }

                                            @media(min-width: 600px) {}

                                            .remove-mattress {
                                                display: none;
                                            }

                                            @media(max-width: 600px) {
                                                .mattress-td {
                                                    width: 60px;
                                                }

                                                .mattress-img {
                                                    max-width: 65px;
                                                }


                                            }
                                        </style>
                                        <div class="mt-20 addons" style="position: relative;padding-right: 140px;;font-size: 15px;">
                                        Upgrade your Mattress & get 2 FREE pillows
                                            <div class="right-btns">


                                                <button onclick="openMattresses2(this)" id="mattress-yes2" class="btn btn-primary btn-yes" type="button">Yes</button>
                                                <button onclick="NoMattresses2(this)" id="mattress-no2" class="btn btn-primary btn-no" type="button">No</button>
                                            </div>

                                        </div>
                                        <div class="mat1" style="display: none" id="mattresses2">
                                            <?php
                                            foreach ($productObj->getMattressesNew(5) as $mattress) {
                                                $categories = [];
                                                $mattress->category_id = str_replace('"', "", $mattress->category_id);
                                                $mattress->category_id = str_replace('[', "", $mattress->category_id);
                                                $mattress->category_id = str_replace(']', "", $mattress->category_id);

                                                foreach (explode(",", $mattress->category_id) as $cat) {

                                                    $data = $categoryObj->getDataById($cat)[0];

                                                    array_push($categories, $data->seo_url);
                                                    break;
                                                }

                                                $image = $productImageObj->getRowByFieldNotDeleted('product_id', $mattress->id);
                                            ?>
                                                <table class="table mb-5 mt-5 mattress-item" style="font-size: 15px;">
                                                    <tr>
                                                        <td style="width: 75px;vertical-align: middle;padding:3px;border:0;">
                                                            <a class="mattress-links" href="<?= DOMAIN ?>/<?= $categories[0] ?>/<?= $mattress->seo_url ?>?" style="display: inline-block">
                                                                <img src="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" alt="<?= $image->alt ?>" class="mattress-img">
                                                            </a>
                                                        </td>
                                                        <td style="vertical-align: middle;padding:3px;border:0;">
                                                            <span class="mb-5 mt-0" style="text-align: left;font-weight: 400 !important;"><?= $mattress->title ?></span><Br>
                                                            <span style="color:#333;font-weight: 600 !important;margin-bottom: 17px;text-align: left;">
                                                                <?php
                                                                if ($mattress->special_offer_price) {

                                                                    print '<span class="red"><strike>£' . $mattress->price . '</strike></span> £' . $mattress->special_offer_price;
                                                                } else {

                                                                    print '£' . $mattress->price;
                                                                }
                                                                ?>




                                                            </span>
                                                        </td>

                                                        <td class="mattress-td" style="vertical-align: middle;padding:3px;border:0;text-align: right">
                                                            <a class="mattress-links" href="<?php echo DOMAIN ?>/<?= $categories[0] ?>/<?= $mattress->seo_url ?>" target="_blank">
                                                                <button class="btn btn-primary add-mattress" type="button">VIEW</button>

                                                            </a>

                                                        </td>
                                                    </tr>
                                                </table>



                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>

                                <script>
                                function calculatePriceAsPerQuantity() {
                                    let total = prices.filter(price => price !== null).reduce((acc, price) => acc + parseFloat(price), 0);
                                    total += original;

                                    $("#extra").val(total);
                                    $("#summ").show();
                                    $("#extra_description").val(descriptions.filter(desc => desc !== undefined).join(","));

                                    const quantity = parseInt($("#quantity").val());
                                    const basePrice = (original * quantity).toFixed(2);
                                    const optionsPrice = ((total - original) * quantity).toFixed(2);
                                    const wasPrice = ((total + newIssue) * quantity).toFixed(2);
                                    const totalPrice = (total * quantity).toFixed(2);

                                    $("#base-price").text(basePrice);
                                    $("#options-price").text(optionsPrice);
                                    $("#was-price").text(wasPrice);
                                    $("#total-price").text(totalPrice);

                                    $("#price, #price-Top, #cart_price").val(total);
                                }
                                </script>
                                <div class="panel panel-default mt-20">
                                    <div class="panel-heading">Summary</div>

                                    <div class="panel-body">
                                        <div id="summ" style="display: none">
                                            <!-- <span style="font-size: 15px;">Base amount: £</span><span style="font-size: 15px;" id="base-price"></span><br> -->
                                            <!-- <span style="font-size: 15px;">Options amount: £</span><span style="font-size: 15px;" id="options-price"></span><br> -->


                                            <?php
                                            if ($row->special_offer_price) {

                                                // echo "<span style='color:#3a004a ;font-size: 19px;font-weight:700;'><strike>WAS: £$row->price</strike></span>";

                                                echo "<span style='font-size: 16px;font-weight:500;color:#3a004a'>WAS: £</span><span style='font-size: 16px;font-weight:500;color:#3a004a' id='was-price'></span>";
                                            } else {

                                                echo "";
                                            }
                                            ?>
                                            <br>
                                            <span style="font-size: 19px;font-weight:700;color:red">NOW: £</span><span style="font-size: 19px;font-weight:700;color:red" id="total-price"></span>
                                            <br>

                                            <br>
                                        </div>
                                        <?php
                                        if ($row->qty_available > 0 and $row->product_status == 1) { ?>
                                            <div style="max-width: 65px;display: inline-block">
                                                <input style="display: none" onclick="calculcatePrice();" type="number" name="quantity" id="qty-value" class="form-control mb-10" value="1" placeholder="Quantity..." max="<?= $row->qty_available ?>">

                                            </div>
                                            <input id="extra_description" name="extra" class="form-control" type="hidden">
                                            <input id="mattress" name="mattress" type="hidden">

                                            <div style="display: inline-block">
                                                <button type="submit" style="min-width: 160px;border-radius: 20px;" class="btn btn-default form-control" onclick="$('#payment_route').val('0')"> ADD TO CART</button>
                                            </div>
                                            <div style="display: inline-block">
                                            <label for="quantity">Select Quantity:</label>
                                                <input onclick="calculatePriceAsPerQuantity();" type="number" name="quantity" id="quantity" value="1">
                                            </div>
                                            



                                        <?php } else { ?>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                                <div class="mt-30"><i class="fa fa-lock" style="color:#3a004a !important;font-size: 15px;"></i> Secure Payments</div>
                                <hr style="margin-top: 5px">
                                <div style="background: #f2f2f2;padding: 5px;padding-top: 10px;border-radius: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-stripe.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-paypal.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-google.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-apple.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-clearpay.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-klarna.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-visa.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                    <img src="<?= DOMAIN ?>/images/payment-cash.png" style="width: 70px;display: inline-block;margin-bottom: 5px;">
                                </div>





                                <div class="mt-20">
                                    <style>
                                        .share-email-b {
                                            background: transparent;
                                            transition: .3s;
                                            padding: 4px;
                                            padding-left: 10px;
                                            padding-right: 10px;
                                            margin-left: 5px;
                                            margin-right: 10px;
                                            border: 1px solid lightgrey;
                                            position: relative;
                                        }

                                        .share-email-b:hover {
                                            transition: .3s;
                                            background: #3a004a;
                                            cursor: pointer;
                                            border: 1px solid #3a004a;
                                            color: white !important;
                                        }

                                        .share-email-b:hover i {
                                            color: white;
                                        }

                                        .share-email {
                                            background: transparent;
                                            transition: .3s;
                                            width: 40px;
                                            height: 40px;
                                            border: 1px solid lightgrey;
                                            position: relative;
                                        }

                                        .share-email i {
                                            position: absolute;
                                            left: 50%;
                                            top: 50%;
                                            transform: translate(-50%, -50%);
                                        }

                                        .share-email:hover {
                                            transition: .3s;
                                            background: #3a004a;
                                            cursor: pointer;
                                            border: none !important;
                                        }

                                        .share-email:hover i {
                                            color: white;
                                        }
                                    </style>

                                    <div id="send-form" style="display: none;position: relative">
                                        <input name="" value="" placeholder="Send to E-mail..." id="fake-share-email" class="form-control" onkeyup="$('#send-to').val(this.value)">
                                        <div class="share-email" onclick="sendShare(this)" style="position: absolute;right:0;top:0;width: 34px !important;height: 34px !important;">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                    </div>
                                    <script>
                                        function sendShare(that) {
                                            if ($("#fake-share-email").val() == "") {
                                                $("#fake-share-email").css({
                                                    border: "1px solid #3a004a"
                                                });
                                                $(that).css({
                                                    border: "1px solid #3a004a"
                                                });
                                                $("#fake-share-email").attr("placeholder", "Field must be filled out!");
                                            } else {
                                                $('#email-share').click();
                                            }
                                        }
                                    </script>

                                    <div style="display:none;" class="share-email" onclick="$('#send-form').show();$(this).remove();">
                                        <i class="far fa-envelope"></i>
                                    </div>
                                </div>

                        </div>






                    </div>

                <?php } ?>

                </div>


            </div>
            <div class="panel panel-default mt-5 mb-1" style="padding-left: 15px;padding-right: 15px;">
                <div class="panel-body" id="btns-description">
                    <style>
                        @media(max-width: 767px) {
                            #btns-description {
                                padding-left: 0px !important;
                                padding-right: 0px !important;
                            }

                            .switcher {
                                padding: 5px !important;
                                padding-left: 10px !important;
                                padding-right: 10px !important;
                                font-size: 14px;

                            }
                        }
                    </style>
                    <style>
                        .switcher {
                            color: white;
                            width: fit-content;
                            padding: 10px;
                            padding-left: 20px !important;
                            padding-right: 20px !important;
                            display: inline-block;
                            font-size: 17px;
                            border-radius: 5px;
                            cursor: pointer;

                        }

                        .switcher.in-active {
                            background: #f5e1fa;
                            color: #333;
                            font-weight: 500;
                        }

                        .switcher.active {
                            background: #3a004a;
                            font-weight: 500;
                        }

                        .switcher.in-active:hover {
                            background: #3a004a;
                            color: white;

                        }
                    </style>
                    <script>
                        function activateDescription(that) {
                            $("#activate-description").removeClass("in-active").addClass("active");
                            $("#activate-dimensions").removeClass("active").addClass("in-active");
                            $("#activate-dimensions2").removeClass("active").addClass("in-active");
                            $("#activate-dimensions3").removeClass("active").addClass("in-active");
                            $("#activate-delivery").removeClass("active").addClass("in-active");


                            $("#more-description").show();
                            $("#more-dimensions").hide();
                            $("#more-dimensions2").hide();
                            $("#more-dimensions3").hide();
                            $("#more-delivery").hide();

                        }

                        function activateDimensions(that) {
                            $("#activate-description").removeClass("active").addClass("in-active");
                            $("#activate-dimensions2").removeClass("active").addClass("in-active");
                            $("#activate-dimensions").removeClass("in-active").addClass("active");
                            $("#activate-dimensions3").removeClass("active").addClass("in-active");
                            $("#activate-delivery").removeClass("active").addClass("in-active");


                            $("#more-description").hide();
                            $("#more-dimensions2").hide();
                            $("#more-dimensions").show();
                            $("#more-dimensions3").hide();
                            $("#more-delivery").hide();

                        }

                        function activateDimensions2(that) {
                            $("#activate-description").removeClass("active").addClass("in-active");
                            $("#activate-dimensions").removeClass("active").addClass("in-active");
                            $("#activate-dimensions2").removeClass("in-active").addClass("active");
                            $("#activate-dimensions3").removeClass("active").addClass("in-active");
                            $("#activate-delivery").removeClass("active").addClass("in-active");




                            $("#more-description").hide();
                            $("#more-dimensions").hide();
                            $("#more-dimensions2").show();
                            $("#more-dimensions3").hide();
                            $("#more-delivery").hide();


                        }

                        function activateDimensions3(that) {
                            $("#activate-description").removeClass("active").addClass("in-active");
                            $("#activate-dimensions").removeClass("active").addClass("in-active");
                            $("#activate-dimensions2").removeClass("active").addClass("in-active");
                            $("#activate-dimensions3").removeClass("in-active").addClass("active");
                            $("#activate-delivery").removeClass("active").addClass("in-active");




                            $("#more-description").hide();
                            $("#more-dimensions").hide();
                            $("#more-dimensions2").hide();
                            $("#more-dimensions3").show();
                            $("#more-delivery").hide();


                        }

                        function activateDelivery(that) {
                            $("#activate-description").removeClass("active").addClass("in-active");
                            $("#activate-dimensions").removeClass("active").addClass("in-active");
                            $("#activate-dimensions2").removeClass("active").addClass("in-active");
                            $("#activate-dimensions3").removeClass("active").addClass("in-active");
                            $("#activate-delivery").removeClass("in-active").addClass("active");




                            $("#more-description").hide();
                            $("#more-dimensions").hide();
                            $("#more-dimensions2").hide();
                            $("#more-dimensions3").hide();
                            $("#more-delivery").show();


                        }
                    </script>
                    <?php
                    $dimensionObj = new \App\Dimension();
                    $headboards = [];
                    $beds = [];
                    $mattresses = [];

                    foreach (explode(",", $row->connected_dimensions) as $dimension) {

                        foreach ($dimensionObj->getById($dimension) as $dim) {

                            if (strtoupper($dim->attribute) == "HEADBOARD") {
                                array_push($headboards, $dim);
                            }
                            if (strtoupper($dim->attribute) == "BED" or strtoupper($dim->attribute) == "BEDS") {
                                array_push($beds, $dim);
                            }
                            if (strtoupper($dim->attribute) == "MATTRESS") {
                                array_push($mattresses, $dim);
                            }
                        }
                    }
                    ?>
                    <div id="activate-description" onclick="activateDescription(this);" class="switcher active mb-5 mt-5">Description</div>


                    <?php
                    if (count($headboards) > 0) { ?>
                        <div id="activate-dimensions" onclick="activateDimensions(this);" class="switcher in-active mb-5 mt-5">Headboard Dimensions</div>
                    <?php }
                    ?>


                    <?php
                    if (count($beds) > 0) { ?>
                        <div id="activate-dimensions2" onclick="activateDimensions2(this);" class="switcher in-active mb-5 mt-5">Bed Dimensions</div>
                    <?php }
                    ?>


                    <?php
                    if (count($mattresses) > 0) { ?>
                        <div id="activate-dimensions3" onclick="activateDimensions3(this);" class="switcher in-active mb-5 mt-5">Mattress Dimensions</div>
                    <?php }
                    ?>


                    <?php
                    $url = 'https://www.' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                    if (strpos($url, 'mattresses') !== false) {
                    } else { ?>

                        <div id="activate-description" onclick="window.open('https://www.comfortbedsltd.co.uk/swatches')" class="switcher in-active mb-5 mt-5">Order Swatches</div>

                    <?php } ?>

                    <div id="activate-delivery" onclick="activateDelivery(this);" class="switcher mb-5 in-active mt-5">Delivery Policy</div>





                </div>
            </div>

            <div class="panel panel-default mt-5">
                <div class="panel-body" style="padding: 0;">
                    <div class="row">

                        <style>
                            .option {
                                background: red;
                                color: white;
                                border-radius: 15px;
                                padding: 4px;
                                padding-right: 15px;
                                padding-left: 15px;
                                font-size: 15px;
                            }
                        </style>
                        <div class="col-md-12 mt-10" style="padding: 50px  !important;padding-top: 15px !important;" id="more-description">

                            <?php

                            $description2 = nl2br($row->long_description);

                            $description2 = str_replace('</p><br />', '</p>', $description2);
                            $description2 = str_replace('</li><br />', '</li>', $description2);
                            $description2 = str_replace('<ul><br />', '<ul>', $description2);
                            $description2 = str_replace('<ul><br />', '<ul>', $description2);
                            $description2 = str_replace('</ul><br />', '</ul>', $description2);
                            $description2 = str_replace('<table><br />', '<table>', $description2);
                            $description2 = str_replace('<tbody><br />', '<tbody><ul>', $description2);
                            $description2 = str_replace('<tr><br />', '<tr>', $description2);
                            $description2 = str_replace('</th><br />', '</th>', $description2);
                            $description2 = str_replace('</td><br />', '</td>', $description2);
                            $description2 = str_replace('</tr><br />', '</tr>', $description2);
                            $description2 = str_replace('><br />', '>', $description2);

                            print $description2;


                            // $descriptionFacebookNew = nl2br($row->long_description);
                            $descriptionFacebook = strip_tags($description2);

                            ?>



                        </div>
                        <style>
                            .dim1 table tr td {
                                padding: 15px;
                            }

                            .dim1-mobile {
                                display: none;
                            }

                            @media(max-width: 767px) {
                                #desktop-dim1 {
                                    display: none;
                                }

                                .dim1-mobile {
                                    display: unset;
                                }
                            }

                            .dims-select-input {
                                height: 45px !important;
                                box-shadow: -3px 3px 10px lightgrey;
                                border-radius: 2px !important;
                                background: white !important;
                            }
                        </style>


                    </div>


                    <div class="col-md-12 dim1" style="padding: 0px !important;display: none" id="more-dimensions">
                        <table style="width: 100%;" id="desktop-dim1">
                            <tr>
                                <td style="width: 60%;background: #f2f2f2;vertical-align: top;">
                                    <select class="form-control mb-10 dims-select-input" id="headboard-select" onchange="headboardSelectChange(this)">
                                        <?php
                                        foreach ($headboards as $headboard) { ?>

                                            <option value="<?= $headboard->id ?>"><?= $headboard->name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <div style="background: #f2f2f2" class=" ">



                                        <script>
                                            $(document).ready(function() {
                                                $("#headboard-select").trigger("change");
                                            });

                                            function headboardSelectChange(that) {
                                                $(".headboards-item").hide();

                                                $(".headboard-" + $(that).val()).show();
                                            }
                                        </script>


                                        <table class="table">
                                            <?php
                                            foreach ($headboards as $key => $headboard) { ?>

                                                <?php
                                                if ($key == 0) { ?>
                                                    <?php
                                                    if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                        <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title1 ?></td>
                                                            <td><?= $headboard->value1 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                        <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title2 ?></td>
                                                            <td><?= $headboard->value2 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                        <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title3 ?></td>
                                                            <td><?= $headboard->value3 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                        <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title4 ?></td>
                                                            <td><?= $headboard->value4 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                        <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title5 ?></td>
                                                            <td><?= $headboard->value5 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                        <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title6 ?></td>
                                                            <td><?= $headboard->value6 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>






                                                <?php } else { ?>
                                                    <?php
                                                    if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                        <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title1 ?></td>
                                                            <td><?= $headboard->value1 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                        <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title2 ?></td>
                                                            <td><?= $headboard->value2 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                        <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title3 ?></td>
                                                            <td><?= $headboard->value3 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                        <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title4 ?></td>
                                                            <td><?= $headboard->value4 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                        <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title5 ?></td>
                                                            <td><?= $headboard->value5 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                        <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title6 ?></td>
                                                            <td><?= $headboard->value6 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>


                                                <?php }
                                                ?>

                                            <?php }
                                            ?>
                                        </table>
                                    </div>
                                </td>
                                <td>
                                    <?php

                                    $dimensionImagObj = new \App\DimensionImage();
                                    ?>
                                    <?php
                                    foreach ($headboards as $key => $headboard) {

                                        $dimImage =  $dimensionImagObj->getAll($headboard->id);
                                        if ($key == 0) { ?>
                                            <img class="headboards-item headboard-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;">

                                        <?php } else { ?>
                                            <img class="headboards-item headboard-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;display: none;">

                                        <?php }
                                        ?>



                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                        <div style="padding: 15px;">
                            <div class="dim1-mobile col-md-7 dim1-height">
                                <select class="form-control mb-10 dims-select-input" id="headboard-select" onchange="headboardSelectChange(this)">
                                    <?php
                                    foreach ($headboards as $headboard) { ?>

                                        <option value="<?= $headboard->id ?>"><?= $headboard->name ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <div style="background: #f2f2f2" class=" ">



                                    <script>
                                        $(document).ready(function() {
                                            $("#headboard-select").trigger("change");
                                        });

                                        function headboardSelectChange(that) {
                                            $(".headboards-item").hide();

                                            $(".headboard-" + $(that).val()).show();
                                        }
                                    </script>


                                    <table class="table">
                                        <?php
                                        foreach ($headboards as $key => $headboard) { ?>

                                            <?php
                                            if ($key == 0) { ?>
                                                <?php
                                                if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                    <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title1 ?></td>
                                                        <td><?= $headboard->value1 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                    <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title2 ?></td>
                                                        <td><?= $headboard->value2 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                    <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title3 ?></td>
                                                        <td><?= $headboard->value3 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                    <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title4 ?></td>
                                                        <td><?= $headboard->value4 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                    <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title5 ?></td>
                                                        <td><?= $headboard->value5 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                    <tr class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title6 ?></td>
                                                        <td><?= $headboard->value6 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>






                                            <?php } else { ?>
                                                <?php
                                                if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                    <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title1 ?></td>
                                                        <td><?= $headboard->value1 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                    <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title2 ?></td>
                                                        <td><?= $headboard->value2 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                    <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title3 ?></td>
                                                        <td><?= $headboard->value3 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                    <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title4 ?></td>
                                                        <td><?= $headboard->value4 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                    <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title5 ?></td>
                                                        <td><?= $headboard->value5 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                    <tr style="display: none" class="headboards-item headboard-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title6 ?></td>
                                                        <td><?= $headboard->value6 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>


                                            <?php }
                                            ?>

                                        <?php }
                                        ?>
                                    </table>
                                </div>

                            </div>
                            <div class="dim1-mobile col-md-5 dim1-height" style="padding: 0;">
                                <?php

                                $dimensionImagObj = new \App\DimensionImage();
                                ?>
                                <?php
                                foreach ($headboards as $key => $headboard) {

                                    $dimImage =  $dimensionImagObj->getAll($headboard->id);
                                    if ($key == 0) { ?>
                                        <img class="headboards-item headboard-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;">

                                    <?php } else { ?>
                                        <img class="headboards-item headboard-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;display: none;">

                                    <?php }
                                    ?>



                                <?php } ?>
                            </div>
                        </div>


                    </div>



                    <div class="col-md-12 dim1" style="padding: 50px  !important;display: none" id="more-delivery">


                        <h2>Delivery Process</h2>
                        <p class="text-left">
                            Here at Comfort Beds our headboards, beds and mattresses are made at our factory in the heart of Yorkshire and are shipped directly from there to your door.<br /><br />

                            <!-- We deliver to all our customers, with no middleman or courier service to keep costs down. If you have any queries regarding delivery either before or after, please get in touch and we will answer any questions you may have.<br /><br /> -->

                            We take pride in our customers' journey and we hope the transaction is smooth. With this in mind, we expect your order to be delivered within 3 - 7 working days. All deliveries must be signed for to confirm acceptance at the point of delivery.<br /><br />

                            Please keep hold of your old beds/mattresses until your new one arrives.<br /><br />

                            We deliver to all our customers, with no middleman or courier service to keep costs down. If you have any queries regarding delivery either before or after, please get in touch and we will answer any questions you may have. (In a way when out of delivery range we use a courier company)
                        </p>

                        <h2>Installation</h2>
                        <p class="text-left">
                            If you need us to install your bed, headboard and mattress in your property, then we are happy to offer an additional service for this, at a fee of £39.99 per delivery. Our trained experts will deliver your new bed to your room, build your new bed, headboard and/or mattress and ensure this is correctly and securely fitted.<br /><br />

                            We will take all rubbish away, leaving you ready to enjoy your new purchase instantly. If you have an existing bed or mattress, then we can take this away for you as an additional service for just £39.99.<br /><br />
                        </p>

                        <h2>Free UK Mainland Delivery & Charges</h2>
                        <p class="text-left">
                            Here at Comfort Beds, as well as providing amazing quality bed and mattresses for your dream bedroom makeover, we also offer free delivery with many of our purchases.<br /><br />

                            *Our delivery offer only applies to mainland U.K postcodes. A list of those postcodes we don’t include in this can be found below. If you are unsure if you are covered for your address, feel free to contact us and we’ll assist you with any queries.<br /><br />

                            Some locations within the UK are currently excluded. We do not deliver to offshore locations including the Isle of Wight, Isle of Man and the Channel Islands. See the table below for full details of where we deliver to, and excluded postcodes.<br /><br />

                            Any deliveries that are not made successfully on time will be subject to an extra fee on top of the initial order amount. If any fees are incurred before the delivery is confirmed, you must be able to pay the additional fees to have your order delivered. All deliveries must be signed for to confirm acceptance at the point of delivery.<br /><br />

                            Please ensure we can access the chosen room to deliver your order in a timely manner. If we are unable to do so, we will have to charge a return fee on your order.
                        </p>


                    </div>


                    <div class="col-md-12 dim1" style="padding: 0px !important;display: none" id="more-dimensions2">

                        <table style="width: 100%;" id="desktop-dim1">
                            <tr>
                                <td style="width: 60%;background: #f2f2f2;vertical-align: top;">
                                    <select class="form-control mb-10 dims-select-input" id="headboard-select" onchange="BedSelectChange(this)">
                                        <?php
                                        foreach ($beds as $headboard) { ?>

                                            <option value="<?= $headboard->id ?>"><?= $headboard->name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <div style="background: #f2f2f2" class=" ">



                                        <script>
                                            $(document).ready(function() {
                                                $("#bed-select").trigger("change");
                                            });

                                            function BedSelectChange(that) {
                                                $(".beds-item").hide();

                                                $(".bed-" + $(that).val()).show();
                                            }
                                        </script>


                                        <table class="table">
                                            <?php
                                            foreach ($beds as $key => $headboard) { ?>

                                                <?php
                                                if ($key == 0) { ?>
                                                    <?php
                                                    if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                        <tr class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title1 ?></td>
                                                            <td><?= $headboard->value1 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                        <tr class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title2 ?></td>
                                                            <td><?= $headboard->value2 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                        <tr class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title3 ?></td>
                                                            <td><?= $headboard->value3 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                        <tr class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title4 ?></td>
                                                            <td><?= $headboard->value4 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                        <tr class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title5 ?></td>
                                                            <td><?= $headboard->value5 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                        <tr class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title6 ?></td>
                                                            <td><?= $headboard->value6 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>






                                                <?php } else { ?>
                                                    <?php
                                                    if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                        <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title1 ?></td>
                                                            <td><?= $headboard->value1 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                        <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title2 ?></td>
                                                            <td><?= $headboard->value2 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                        <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title3 ?></td>
                                                            <td><?= $headboard->value3 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                        <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title4 ?></td>
                                                            <td><?= $headboard->value4 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                        <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title5 ?></td>
                                                            <td><?= $headboard->value5 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                        <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title6 ?></td>
                                                            <td><?= $headboard->value6 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>


                                                <?php }
                                                ?>

                                            <?php }
                                            ?>
                                        </table>
                                    </div>
                                </td>
                                <td>
                                    <?php

                                    $dimensionImagObj = new \App\DimensionImage();
                                    ?>
                                    <?php
                                    foreach ($beds as $key => $headboard) {

                                        $dimImage =  $dimensionImagObj->getAll($headboard->id);
                                        if ($key == 0) { ?>
                                            <img class="beds-item bed-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;">

                                        <?php } else { ?>
                                            <img class="beds-item bed-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;display: none;">

                                        <?php }
                                        ?>



                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                        <div style="padding: 0px;">
                            <div class="dim1-mobile col-md-7 dim1-height">
                                <select class="form-control mb-10 dims-select-input" id="headboard-select" onchange="BedSelectChange(this)">
                                    <?php
                                    foreach ($beds as $headboard) { ?>

                                        <option value="<?= $headboard->id ?>"><?= $headboard->name ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <div style="background: #f2f2f2" class=" ">



                                    <script>
                                        $(document).ready(function() {
                                            $("#bed-select").trigger("change");
                                        });

                                        function BedSelectChange(that) {
                                            $(".beds-item").hide();

                                            $(".bed-" + $(that).val()).show();
                                        }
                                    </script>


                                    <table class="table">
                                        <?php
                                        foreach ($beds as $key => $headboard) { ?>

                                            <?php
                                            if ($key == 0) { ?>
                                                <?php
                                                if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                    <tr class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title1 ?></td>
                                                        <td><?= $headboard->value1 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                    <tr class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title2 ?></td>
                                                        <td><?= $headboard->value2 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                    <tr class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title3 ?></td>
                                                        <td><?= $headboard->value3 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                    <tr class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title4 ?></td>
                                                        <td><?= $headboard->value4 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                    <tr class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title5 ?></td>
                                                        <td><?= $headboard->value5 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                    <tr class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title6 ?></td>
                                                        <td><?= $headboard->value6 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>






                                            <?php } else { ?>
                                                <?php
                                                if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                    <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title1 ?></td>
                                                        <td><?= $headboard->value1 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                    <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title2 ?></td>
                                                        <td><?= $headboard->value2 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                    <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title3 ?></td>
                                                        <td><?= $headboard->value3 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                    <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title4 ?></td>
                                                        <td><?= $headboard->value4 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                    <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title5 ?></td>
                                                        <td><?= $headboard->value5 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                    <tr style="display: none" class="beds-item bed-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title6 ?></td>
                                                        <td><?= $headboard->value6 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>


                                            <?php }
                                            ?>

                                        <?php }
                                        ?>
                                    </table>
                                </div>

                            </div>
                            <div class="dim1-mobile col-md-5 dim1-height" style="padding: 0;">
                                <?php

                                $dimensionImagObj = new \App\DimensionImage();
                                ?>
                                <?php
                                foreach ($beds as $key => $headboard) {

                                    $dimImage =  $dimensionImagObj->getAll($headboard->id);
                                    if ($key == 0) { ?>
                                        <img class="beds-item bed-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;">

                                    <?php } else { ?>
                                        <img class="beds-item bed-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;display: none;">

                                    <?php }
                                    ?>



                                <?php } ?>
                            </div>
                        </div>


                    </div>



                    <div class="col-md-12 dim1" style="padding: 0px !important;display: none" id="more-dimensions3">

                        <table style="width: 100%;" id="desktop-dim1">
                            <tr>
                                <td style="width: 60%;background: #f2f2f2;vertical-align: top;">
                                    <select class="form-control mb-10 dims-select-input" id="headboard-select" onchange="MattressSelectChange(this)">
                                        <?php
                                        foreach ($mattresses as $headboard) { ?>

                                            <option value="<?= $headboard->id ?>"><?= $headboard->name ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <div style="background: #f2f2f2" class=" ">



                                        <script>
                                            $(document).ready(function() {
                                                $("#mattress-select").trigger("change");
                                            });

                                            function MattressSelectChange(that) {
                                                $(".mattresses-item").hide();

                                                $(".mattress-" + $(that).val()).show();
                                            }
                                        </script>


                                        <table class="table">
                                            <?php
                                            foreach ($mattresses as $key => $headboard) { ?>

                                                <?php
                                                if ($key == 0) { ?>
                                                    <?php
                                                    if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                        <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title1 ?></td>
                                                            <td><?= $headboard->value1 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                        <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title2 ?></td>
                                                            <td><?= $headboard->value2 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                        <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title3 ?></td>
                                                            <td><?= $headboard->value3 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                        <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title4 ?></td>
                                                            <td><?= $headboard->value4 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                        <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title5 ?></td>
                                                            <td><?= $headboard->value5 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                        <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title6 ?></td>
                                                            <td><?= $headboard->value6 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>






                                                <?php } else { ?>
                                                    <?php
                                                    if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                        <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title1 ?></td>
                                                            <td><?= $headboard->value1 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                        <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title2 ?></td>
                                                            <td><?= $headboard->value2 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                        <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title3 ?></td>
                                                            <td><?= $headboard->value3 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                        <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title4 ?></td>
                                                            <td><?= $headboard->value4 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                        <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title5 ?></td>
                                                            <td><?= $headboard->value5 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                        <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                            <td><?= $headboard->title6 ?></td>
                                                            <td><?= $headboard->value6 ?></td>
                                                        </tr>
                                                    <?php }
                                                    ?>


                                                <?php }
                                                ?>

                                            <?php }
                                            ?>
                                        </table>
                                    </div>
                                </td>
                                <td>
                                    <?php

                                    $dimensionImagObj = new \App\DimensionImage();
                                    ?>
                                    <?php
                                    foreach ($mattresses as $key => $headboard) {

                                        $dimImage =  $dimensionImagObj->getAll($headboard->id);
                                        if ($key == 0) { ?>
                                            <img class="mattresses-item mattress-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;">

                                        <?php } else { ?>
                                            <img class="mattresses-item mattress-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;display: none;">

                                        <?php }
                                        ?>



                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                        <div style="padding: 0px;">
                            <div class="dim1-mobile col-md-7 dim1-height">
                                <select class="form-control mb-10 dims-select-input" id="headboard-select" onchange="MattressSelectChange(this)">
                                    <?php
                                    foreach ($mattresses as $headboard) { ?>

                                        <option value="<?= $headboard->id ?>"><?= $headboard->name ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <div style="background: #f2f2f2" class=" ">



                                    <script>
                                        $(document).ready(function() {
                                            $("#mattress-select").trigger("change");
                                        });

                                        function MattressSelectChange(that) {
                                            $(".mattresses-item").hide();

                                            $(".mattress-" + $(that).val()).show();
                                        }
                                    </script>


                                    <table class="table">
                                        <?php
                                        foreach ($mattresses as $key => $headboard) { ?>

                                            <?php
                                            if ($key == 0) { ?>
                                                <?php
                                                if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                    <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title1 ?></td>
                                                        <td><?= $headboard->value1 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                    <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title2 ?></td>
                                                        <td><?= $headboard->value2 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                    <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title3 ?></td>
                                                        <td><?= $headboard->value3 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                    <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title4 ?></td>
                                                        <td><?= $headboard->value4 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                    <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title5 ?></td>
                                                        <td><?= $headboard->value5 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                    <tr class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title6 ?></td>
                                                        <td><?= $headboard->value6 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>






                                            <?php } else { ?>
                                                <?php
                                                if ($headboard->title1 != "" and $headboard->title1 != null) { ?>
                                                    <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title1 ?></td>
                                                        <td><?= $headboard->value1 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title2 != "" and $headboard->title2 != null) { ?>
                                                    <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title2 ?></td>
                                                        <td><?= $headboard->value2 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title3 != "" and $headboard->title3 != null) { ?>
                                                    <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title3 ?></td>
                                                        <td><?= $headboard->value3 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title4 != "" and $headboard->title4 != null) { ?>
                                                    <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title4 ?></td>
                                                        <td><?= $headboard->value4 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title5 != "" and $headboard->title5 != null) { ?>
                                                    <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title5 ?></td>
                                                        <td><?= $headboard->value5 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($headboard->title6 != "" and $headboard->title6 != null) { ?>
                                                    <tr style="display: none" class="mattresses-item mattress-<?= $headboard->id ?>">
                                                        <td><?= $headboard->title6 ?></td>
                                                        <td><?= $headboard->value6 ?></td>
                                                    </tr>
                                                <?php }
                                                ?>


                                            <?php }
                                            ?>

                                        <?php }
                                        ?>
                                    </table>
                                </div>

                            </div>
                            <div class="dim1-mobile col-md-5 dim1-height" style="padding: 0;">
                                <?php

                                $dimensionImagObj = new \App\DimensionImage();
                                ?>
                                <?php
                                foreach ($mattresses as $key => $headboard) {

                                    $dimImage =  $dimensionImagObj->getAll($headboard->id);
                                    if ($key == 0) { ?>
                                        <img class="mattresses-item mattress-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;">

                                    <?php } else { ?>
                                        <img class="mattresses-item mattress-<?= $headboard->id ?>" src="<?= DOMAIN ?>/dimension-images/<?= $dimImage[0]->id ?>.<?= $dimImage[0]->ext ?>" style="width: 100%;display: none;">

                                    <?php }
                                    ?>



                                <?php } ?>
                            </div>
                        </div>


                    </div>












                </div>
            </div>
        </div>
        <?php

        if ($newCrossSell and count($newCrossSell) > 0) { ?>

            <div class="panel panel-default mt-20" style="padding-left: 15px;padding-right: 15px;">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="position: relative;">
                                <div style="width: 100%;height: 1px;background: #3a004a !important;margin-top: 30px;"></div>
                                <h2 style="font-weight: 600;margin-top: 0;text-align: center;transform: translate(0,-15px);background: white;width: fit-content;margin: auto;padding-right: 20px !important;padding-left: 20px !important;">Related Products</h2>
                            </div>

                        </div>
                        <?php
                        foreach ($newCrossSell as $product_id) {

                            $image = $productImageObj->getRowByFieldNotDeleted('product_id', $product_id);
                            $product = $productObj->find($product_id);

                            $categories = [];
                            $product->category_id = str_replace('"', "", $product->category_id);
                            $product->category_id = str_replace('[', "", $product->category_id);
                            $product->category_id = str_replace(']', "", $product->category_id);

                            foreach (explode(",", $product->category_id) as $cat) {

                                $data = $categoryObj->getDataById($cat)[0];

                                array_push($categories, $data->seo_url);
                                break;
                            }
                            if ($product->service == 0) {
                        ?>
                                <div class=" col-md-3 col-xs-12 col-sm-6 mb-20" style="padding: 5px;">

                                    <div class=" mb-0" style="padding: 0 !important;border-radius:0px;">

                                        <div class="mb-10">

                                            <a href="<?= DOMAIN ?>/<?= $categories[0] ?>/<?= $product->seo_url ?>">
                                                <!-- <img src="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" data-first="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" data-second="<?= DOMAIN ?>/product-images/<?= $images->id ?>.<?= $images->ext ?>" alt="<?= $images->alt ?>" alt="<?= $image->alt ?>" style="width: 100%;border-radius: 10px;"> -->

                                                <div style='background-image: url("<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>"); background-color: #cccccc;background-position: center;background-repeat: no-repeat;background-size: cover;position: relative;height: 250px;width: 100%;border-radius: 10px;'></div>

                                            </a>
                                        </div>

                                        <a class="prod-list-link" href="<?= DOMAIN ?>/<?= $categories[0] ?>/<?= $product->seo_url ?>">
                                            <p style="padding-left: 5px;font-size: 16px;font-weight: 500;" class="mb-0 text-left"><?= $product->title ?></p>

                                            <p style="padding-left: 5px;font-size: 24px;" class="orange text-left">

                                                <strong>
                                                    <?php

                                                    if ($product->special_offer_price) {

                                                        print '£' . $product->special_offer_price;
                                                    } else {

                                                        print '£' . $product->price;
                                                    }

                                                    ?>
                                                </strong>

                                            </p>
                                            <div class="">
                                                <?php
                                                $product->category_id = str_replace('"', "", $product->category_id);
                                                $product->category_id = str_replace('[', "", $product->category_id);
                                                $product->category_id = str_replace(']', "", $product->category_id);
                                                $cat = explode(",", $product->category_id);

                                                if (in_array("1", $cat) or in_array("2", $cat) or in_array("3", $cat) or in_array("4", $cat) or in_array("5", $cat) or in_array("6", $cat)) { ?>
                                                    <div class="col-xs-6" style="padding-left: 5px;">
                                                        <?php
                                                        $product->connectedObj = [];
                                                        $product->connected = str_replace('"', "", $product->connected);
                                                        $t = 0;

                                                        foreach (explode(",", $product->connected) as $q) {

                                                            $imagesAttr =  $attrImageObj->getAll($q);
                                                            if ($q != "") {
                                                                $x = $attrObj->getById($q);
                                                                if (strtoupper($x[0]->attribute) == "MATERIALS") {


                                                                    foreach ($imagesAttr as $z) {
                                                                        $t += 1;
                                                                        if ($t < 5) {
                                                        ?>
                                                                            <img src="<?= DOMAIN ?>/attribute-images/<?= $z->id ?>.<?= $z->ext ?>" style="width: 20px;border-radius: 100%;">

                                                        <?php

                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }



                                                        ?>
                                                    </div>
                                                <?php }

                                                $col = "col-xs-12";
                                                if (in_array("1", $cat) or in_array("2", $cat) or in_array("3", $cat) or in_array("4", $cat) or in_array("5", $cat) or in_array("6", $cat)) {
                                                    $col = "col-xs-6";
                                                }
                                                ?>

                                                <div class="<?= $col ?>" style="padding: 0;">
                                                    <button type="button" style="border:1px solid lightgray;padding-left: 15px;padding-right: 15px;width: 100%;transform: translate(0,2px);border-radius: 20px;background: white;font-size: 15px;">VIEW NOW</button>

                                                </div>
                                            </div>
                                        </a>
                                    </div>


                                </div>





                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>


    </div>

    </div>




    </div>

</form>

<script>
    $(function() {
        $('.same-height').matchHeight();
        $('.same-height2').matchHeight({
            byRow: false
        });
        $('.same-height3').matchHeight({
            byRow: false
        });
    });
</script>



<style>
    .main-image {
        width: 90%;
        margin: auto
    }

    @media(max-width: 991px) {
        .main-image {
            width: 100% !important;
            margin-bottom: 15px !important;
        }

        .items-item p {
            font-size: 14px;

        }

        .items-item {
            width: 90px !important;
        }
    }
</style>






<script>

    /*
    let x = setInterval(function() {
        $("#fabric-button").click();
        clearInterval(x);
    }, 1000);*/

    function scrollToDescription(that) {


        $([document.documentElement, document.body]).animate({
            scrollTop: $("#long_description").offset().top + window.innerHeight - 50
        }, 500);

    }
</script>

<?php
include('footer.php');
?>