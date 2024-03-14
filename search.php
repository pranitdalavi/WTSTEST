<?php
require __DIR__.'/includes/config.php';
use App\Product;
use App\ProductImage;

$productObj = new Product();
$productImageObj = new ProductImage();



$query = $productObj->search($_GET['q']);
$title = 'You searched for... <br />'.$_GET['q'];
$meta_title = COMPANY_NAME.' | Search';

$attrObj = new \App\Attribute();
$attrImageObj = new \App\AttributeImage();
require 'header.php';

?>

    <style>

        @media (min-width: 1025px) {

            .same-height3{ height:253px !important;overflow:hidden }
            .same-height3 img{ max-height:253px }
            .para-height{ height:60px !important;overflow:auto }

        }

        @media (min-width: 991px) and (max-width: 1024px) {

            .same-height3{ height:205px !important;overflow:hidden }
            .same-height3 img{ max-height:205px }
            .para-height{ height:60px !important;overflow:auto }

        }

        @media (max-width: 320px) {

            .same-height3{ height:110px !important;overflow:hidden }


        }

        @media (min-width: 321px) and (max-width: 375px) {

            .same-height3{ height:120px !important;overflow:hidden }


        }

        @media (min-width: 376px) and (max-width: 414px) {

            .same-height3{ height:150px !important;overflow:hidden }


        }

    </style>

    <script>
        $(function() {

            if(screen.width < 1025){

                $('.same-height').matchHeight();

            }

        });
    </script>

    <div class="container-fluid mt-30">





        <div class="container-fluid" style="padding-left:  0 !important;padding-right: 0 !important;">

            <div class="row">
                <h1 class="text-center mb-30 mt-30" style="font-weight: 600 !important;"><?= strtoupper($title) ?></h1>
                <br>

                <div class="col-lg-12">


                    <div class="">
                        <div class="panel panel-default" >
                            <div class="panel-body" style="padding: 0;">
                                <div class="col-md-12 mb-10 mt-10">
                                    <?= count($query) ?> Results

                                </div>
                                <?php foreach($query as $row){

                                    $image = $productImageObj->getRowByFieldNotDeleted('product_id', $row->id);


                                    $images =  $productImageObj->getAll( $row->id )[1];


                                    ?>

                                    <div class=" col-md-3 col-xs-12 col-sm-6 mb-20" style="padding: 5px;">

                                        <div class=" mb-0" style="padding: 0 !important;border-radius:0px;">

                                            <div class="mb-10">

                                                <a href="<?= DOMAIN ?>/product/<?= $row->seo_url ?>">
                                                    <img src="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" data-first="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" data-second="<?= DOMAIN ?>/product-images/<?= $images->id ?>.<?= $images->ext ?>" alt="<?= $images->alt ?>" alt="<?= $image->alt ?>" style="width: 100%;border-radius: 10px;">

                                                </a>
                                            </div>

                                            <a class="prod-list-link" href="<?= DOMAIN ?>/product/<?= $row->seo_url ?>">
                                                <p style="padding-left: 5px;font-size: 16px;font-weight: 500;" class="mb-0 text-left"><?= $row->title ?></p>

                                                <p style="padding-left: 5px;font-size: 24px;" class="orange text-left">

                                                    <strong>
                                                        <?php

                                                        if($row->special_offer_price){

                                                            print '£'.$row->special_offer_price;

                                                        }else{

                                                            print '£'.$row->price;

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


                                                    if(in_array("1",$cat) or in_array("2",$cat) or in_array("3",$cat) or in_array("4",$cat) or in_array("5",$cat) or in_array("6",$cat)){ ?>
                                                        <div class="col-xs-6" style="padding-left: 5px;">
                                                            <?php
                                                            $row->connectedObj = [];
                                                            $row->connected = str_replace('"',"",$row->connected);
                                                            $t = 0;

                                                            foreach (explode(",",$row->connected) as $q){

                                                                $imagesAttr =  $attrImageObj->getAll( $q );
                                                                if($q != ""){
                                                                    $x = $attrObj->getById($q);
                                                                    if(strtoupper($x[0]->attribute) == "MATERIALS"){


                                                                        foreach ($imagesAttr as $z){
                                                                            $t += 1;
                                                                            if($t < 5){
                                                                                ?>
                                                                                <img  src="<?= DOMAIN ?>/attribute-images/<?= $z->id ?>.<?= $z->ext ?>" style="width: 20px;border-radius: 100%;">

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
                                                    if(in_array("1",$cat) or in_array("2",$cat) or in_array("3",$cat) or in_array("4",$cat) or in_array("5",$cat) or in_array("6",$cat)){
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

                        <?php if(!count($query)){ ?>

                            <p class="text-center">There are no results for that query.</p>

                        <?php } ?>



                    </div>
                </div>
            </div>



        </div>

    </div>

<?php require 'footer.php'; ?>