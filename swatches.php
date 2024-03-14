<?php
require __DIR__ . '/includes/config.php';
$meta_title = COMPANY_NAME . ' | About Us';


if(isset($_POST["swatches"]) and $_POST["swatches"] != ""){
    \App\Helpers\Mail::swatches();
}

require 'header.php';
?>

    <style>
        p{
            font-size: 16px;
            font-weight: 400;
        }
        h2{
            font-weight: 500;
            font-size: 20px;
        }
        li{
            font-weight: 400;
            font-size: 14px;
        }
        h1{
            font-size: 25px;
            font-weight: 600 !important;
        }
        email{
            text-transform: lowercase;
            word-spacing: -3px;
        }
        label{
            font-size: 16px;
            font-weight: 500;
        }
        .page input{
            background: white !important;
            border-radius: 0 !important;
            box-shadow: -2px 2px 10px lightgrey;
            padding-top: 20px !important;
            padding-bottom: 20px !important;
        }
        .page input::placeholder{
            font-size: 13px !important;
            font-weight: 500 !important;
        }
        @media(max-width: 767px){
            .items-item{
                width: 75px !important;
            }
        }
    </style>
    <div class="container page" style="padding-bottom: 40px;padding-top: 30px; color:black;">

        <?php if( count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes()) ){   ?>


            <div class="mb-20">
                <?php require __DIR__.'/includes/flash-messages.php'; ?>

            </div>



        <?php } ?>
        <form action="" method="post">
            <div class="row">
                <div class="col-md-12 mb-10">
                    <h1>Order Swatches</h1>
                    <p style="font-size: 15px;">
                        Select up to 5 FREE samples and get them delivered right to your door. With our quick and easy sample service, just fill in your details below and you're a few easy steps away from finding your ideal Bed for your home...
                    </p>
                    <hr>
                </div>
                <div class="col-md-12 mb-10">
                    <h1 style="font-size: 18px;margin-bottom: 0;">Contact & Shipping</h1>
                </div>
                <div class="col-md-12 mb-10">
                    <label>Full Name</label>
                    <input class="form-control" placeholder="Full name..." name="name" required>
                </div>
                <div class="col-md-6 mb-10">
                    <label>Email</label>
                    <input class="form-control" placeholder="E-mail..." name="email" required>
                </div>
                <div class="col-md-6 mb-10">
                    <label>Phone <small>(optional)</small></label>
                    <input class="form-control" placeholder="Phone..." name="phone">
                </div>
                <div class="col-md-6 mb-10">
                    <label>Address 1</label>
                    <input class="form-control" placeholder="Address 1..." name="address1" required>
                </div>
                <div class="col-md-6 mb-10">
                    <label>Address 2 <small>(optional)</small></label>
                    <input class="form-control" placeholder="Address 2..." name="address2">
                </div>
                <div class="col-md-6 mb-10">
                    <label>City</label>
                    <input class="form-control" placeholder="City..." name="city" required>
                </div>
                <div class="col-md-6 mb-10">
                    <label>Postcode</label>
                    <input class="form-control" placeholder="Postcode..." name="postcode" required>
                </div>
                <div class="col-md-6 mb-10">
                    <label>Country</label>
                    <input class="form-control" placeholder="Country..." name="country" required>
                </div>
                <input name="swatches" id="swatches" type="hidden">

            </div>
            <div class="row mt-30">
                <div class="col-md-12 mt-10">
                    <h1 style="font-size: 18px;margin-bottom: 0;">Available Swatches <span id="count-swatches"></span></h1>
                    <small>Selected up to 5 swatches</small>
                    <div class="mb-15"></div>
                    <script>


                        var selected = [];

                        function attributeAdd(name,group,that){

                            if(selected.includes(name+ " ("+ group +")")){
                                console.log("includes")
                                $(that).find(".checks").hide();
                                for (let i = 0; i < selected.length; i++) {
                                    if(selected[i] == name+ " ("+ group +")"){
                                        selected.splice(i,1);
                                    }
                                }
                            }
                            else{

                                if(selected.length < 5){
                                    selected.push(name + " ("+ group +")");

                                    $(that).find(".checks").show();

                                }


                            }


                            if(selected.length > 0){
                                $("#count-swatches").text("("+selected.length+")")
                            }
                            else{
                                $("#count-swatches").text("")
                            }

                            let string = "";
                            for (let i = 0; i < selected.length; i++) {
                                string += ","+selected[i];
                            }
                            string = string.substr(1);
                            $("#swatches").val(string);


                        }
                    </script>
                    <?php
                    $attrImageObj = new \App\AttributeImage();
                    $attrObj = new \App\Attribute();
                    $productObj = new \App\Product();
                    $products = $productObj->getAll();

                    $addonsIndex = [];
                    foreach ($products as $row){
                        $row->connected = str_replace('"',"",$row->connected);

                        $connected = explode(",",$row->connected);
                        $row->connected = $connected;
                        $attributeObj = new \App\Attribute();
                        $attributeImageObj = new \App\AttributeImage();

                        $addons = [];

                        $raw = [];

                        if($row->connected[0] != "false"){
                            foreach ($connected as $item){
                                array_push($raw,$attributeObj->getById($item));

                            }
                            foreach ($raw as $item){
                                if(!in_array($item[0]->attribute,$addonsIndex) and strtoupper($item[0]->attribute) == "MATERIALS" or !in_array($item[0]->attribute,$addonsIndex) and strtoupper($item[0]->attribute) == "MATERIAL"){

                                    array_push($addonsIndex,$item[0]->attribute);
                                    array_push($addons,[
                                        "attribute" => $item[0]->attribute,
                                        "items" => [

                                        ]
                                    ]);
                                }

                            }

                            $track = [];
                            foreach ($addons as $key=>$addon){
                                foreach ($raw as $item){

                                    if($addon["attribute"] == $item[0]->attribute){
                                        array_push($addons[$key]["items"],$item[0]);
                                    }
                                }


                            }
                        }





                        foreach ($addons as $key=>$addon){
                            if(strtoupper($addon["attribute"]) == "MATERIALS" or strtoupper($addon["attribute"]) == "MATERIAL"){ ?>
                                <?php
                                $materialsGroups = [];
                                $categories = $attrObj->getMaterialGroups();
                                foreach ($categories as $ca){
                                    array_push($materialsGroups,[
                                        "name" => $ca->material_group,
                                        "items" => []
                                    ]);
                                }
                                foreach ($addon["items"] as $item){
                                    foreach ($materialsGroups as $keyA=>$groupItem){
                                        if($groupItem["name"] == $item->material_group){
                                            array_push($materialsGroups[$keyA]["items"], $item);
                                        }
                                    }
                                }
                                foreach ($materialsGroups as $q){
                                    ?>

                                    <?php
                                    if(count($q["items"]) > 0){ ?>
                                        <h4 class="ml-5"><?= $q["name"] ?></h4>

                                    <?php }
                                    ?>
                                    <?php
                                    foreach ($q["items"] as $item){

                                        $image = $attributeImageObj->getRowByFieldNotDeleted('blog_id', $item->id);
                                        ?>
                                        <div data-storage="<?= $item->storage_limit ?>" class="items-item q-<?= $key ?>"  style="min-height: 165px;padding: 0px;margin-right: 10px;width: 100px;display: inline-block" onclick="attributeAdd('<?= $item->name ?>','<?= $q["name"] ?>',this)">
                                            <div class="item" style="position: relative;padding-top: 0px;">
                                                <div class="checks" style="display: none;color:White;font-size: 9px;text-align: center;line-height: 20px;width: 20px;height: 20px;background: #3a004a !important;border-radius: 100%;position: absolute;right:-5px;top:-5px;z-index: 112;">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                                <div style="width: 100%;position: relative">
                                                    <?php
                                                    if(strtoupper($item->attribute) == "MATERIAL" or strtoupper($item->attribute) == "MATERIALS"){ ?>
                                                        <img draggable="false" src="<?php echo DOMAIN ?>/images/white-border.png" style="width: 100%;position: absolute;z-index: 111;left:0;top:0;">

                                                    <?php }
                                                    ?>
                                                    <img draggable="false" src="<?php echo DOMAIN ?>/attribute-images/<?= $image->id ?>.<?= $image->ext ?>" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div style="font-size: 14px;">
                                                <p class="text-center mt-10" style="font-size: 14px;font-weight: 600;"><?= $item->name ?></p>
                                            </div>

                                        </div>
                                    <?php } ?>

                                    <?php

                                }



                                ?>
                            <?php  }
                            break;
                        }
                    }
                    ?>
                </div>



            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-default" style="margin-right: 10px;border-radius: 15px;min-width: 120px;margin-bottom: 20px;margin-top: 15px;padding-right: 20px;padding-left: 20px;">SUBMIT ORDER</button>
                </div>
            </div>
        </form>



    </div>


<?php require 'footer.php'; ?>