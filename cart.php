<?php

require __DIR__ . '/includes/config.php';

use App\PromoCode;

$promoObj = new PromoCode;
$productImageObj = new App\ProductImage;
$productObj = new \App\Product();
$cartObj = new \App\Cart();
if (isset($_POST["installation"]) and $_POST["installation"] == "on") {
    $installation = $productObj->getById(2);
    $cartObj->addExtra($installation[0]->id, 1, $installation[0]->price,'#installationSKU');
}
if (isset($_POST["removal"]) and $_POST["removal"] == "on") {
    $removal = $productObj->getById(3);

    $cartObj->addExtra($removal[0]->id, 1, $removal[0]->price,'#removalSKU');
}

if (isset($_POST['cart'])) {

    unset($_SESSION[SESSION . 'shipping']);
    $cartObj->updateCart();
}

if (isset($_POST['code'])) {

    $promoObj->checkPromoCode();
}


if (isset($_GET['delete'])) {

    unset($_SESSION[SESSION . 'shipping']);
    $cartObj->delete($_GET['delete']);
}

if (isset($_POST['shipping'])) {

    $cartObj->setShipping($_POST['shipping']);
}

$meta_title = COMPANY_NAME . ' | Shopping Cart';
$doorstep = 0;
foreach ($cartObj->getAll() as $item) {
    if ($item->installation == 1) {
        $doorstep += 1;
    }
}

$categoryObj = new \App\Category();
$bedsCounter = 0;
$mattressCounter = 0;

$bedIds = [];
$mattressIds = [];
/*
$discountItems = [];
foreach ($cartObj->getAll() as $item){
    if($item->product_id != "2" and $item->product_id != "3"){
        $categories = $productObj->getProductCategories($item->product_id);
        $categories = str_replace("[","",$categories);
        $categories = str_replace("]","",$categories);
        $categories = str_replace('"',"",$categories);

        $categoryItem = $categoryObj->getDataById($categories);

        if($categoryItem[0]->seo_url == "mattresses"){
            $mattressCounter ++;
            array_push($mattressIds, $item->cart_id);
        }
        else if($categoryItem[0]->seo_url != "mattresses" and $categoryItem[0]->seo_url != "bed-frames" and $categoryItem[0]->seo_url != "headboards"){
            $bedsCounter ++;
            array_push($bedIds, $item->cart_id);
        }
    }


}




$discountAppliable = 0;
if($bedsCounter < $mattressCounter){
    $discountAppliable = $bedsCounter;
}
else{
    $discountAppliable = $mattressCounter;
}

$actualDiscount = [];

foreach ($bedIds as $key=>$i){
    if($key <= ($discountAppliable - 1)){
        array_push($actualDiscount,$i);
    }

}

foreach ($mattressIds as $key=>$i){
    if($key <= ($discountAppliable - 1)){
        array_push($actualDiscount,$i);
    }

}


foreach ($actualDiscount as $toDiscount){
    $cartitem = $cartObj->getItem($toDiscount);
    $categories = $productObj->getProductCategories($cartitem->product_id);
    $categories = str_replace("[","",$categories);
    $categories = str_replace("]","",$categories);
    $categories = str_replace('"',"",$categories);

    $categoryItem = $categoryObj->getDataById($categories);

    if($categoryItem[0]->seo_url == "mattresses"){
        $cartObj->updateDiscount($toDiscount);

    }
}
*/

require 'header.php';

?>

<script>
    $(function() {

        $('#shipping').change(function() {

            $('#shipping-form').submit();

        });

    });
</script>




<div class="container pt-30 pb-40">

    <?php if (!$cartObj->countItems()) { ?>

        <h1 class="text-center" style="font-weight: 600 !important;">Shoppig Cart</h1>
        <br>
        <br>
        <?php if (count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes())) {   ?>

            <div class="container mt-10" style="padding: 0;">

                <?php require __DIR__ . '/includes/flash-messages.php'; ?>

            </div>

        <?php } ?>
        <div class="panel panel-default">

            <div class="panel-body text-center">

                <p class="mb-0">Your shopping cart is currently empty.</p>

            </div>
        </div>

    <?php } else { ?>
        <h1 class="text-center" style="font-weight: 600 !important;">Shopping Cart</h1>

        <?php if (count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes())) {   ?>
            <br>
            <div class=" mt-10" >
                <div class="row">
                    <div class="col-md-12">
                        <?php require __DIR__ . '/includes/flash-messages.php'; ?>

                    </div>
                </div>


            </div>

        <?php } ?>
        <br>
        <br>
        <div class="panel panel-default">
            <div class="panel-body" style="padding: 5px;">
                <table class="table table-striped">
                    <tr>
                        <td style="vertical-align: middle;background: white;border:none;"></td>
                        <td style="vertical-align: middle;background: white;border:none;"></td>
                        <td class="mobile-remove" style="vertical-align: middle;background: white;border:none;width: 80px;font-size: 16px;">Price</td>
                        <td class="mobile-remove" style="vertical-align: middle;background: white;border:none;width: 80px;font-size: 16px;">Total</td>

                    </tr>
                    <form action="" method="post">
                        <input type="hidden" name="cart">

                        <style>
                            .before::before {
                                content: "- ";
                                transform: translate(-10px, 0);
                                position: absolute;
                                margin-right: 5px;
                                display: inline-block;
                            }
                        </style>
                        <?php
                        $TOTAL = 0;
                        ?>
                        <?php foreach ($cartObj->getAll() as $row) {
                            $TOTAL += $row->quantity * $row->cart_price;
                        ?>

                            <tr>
                                <td class="cart-img-block">
                                    <div style="position: relative">
                                        <img src="product-images/<?= $productImageObj->getRowByFieldNotDeleted('product_id', $row->products2_id)->id . '.' . $productImageObj->getRowByFieldNotDeleted('product_id', $row->products2_id)->ext ?>" alt="<?= $row->title ?>" class="mt-8 img-responsive cart-img" />

                                        <div style="border:2px solid white;width: 25px;height: 25px;background: #3a004a !important;color:white;font-size: 13px;position: absolute;top:-8px;right:-5px;text-align: center;font-weight: 600;line-height: 20px;border-radius: 100%;"><?= $row->quantity ?></div>
                                    </div>



                                </td>
                                <td style="vertical-align: middle">
                                    <div style="margin-bottom: 15px;font-size: 17px;">
                                        <?= $row->title ?> <span class="mobile-show" style="display: none">(<b>£<?= number_format($row->quantity * $row->cart_price, 2) ?>)</b></span>
                                        <?php
                                        if ($row->discounted_amount != null and $row->discounted_amount  > 0) { ?>
                                            <p style="font-size: 16px;color:#dc3434;font-weight: 500;">50% OFF!</p>
                                        <?php }
                                        ?>
                                    </div>

                                    <?php
                                    if ($row->extra != "" and $row->extra != null) { ?>

                                        <?php
                                        foreach (explode(",", $row->extra) as $item) { ?>
                                            <p class="mb-0 before" style="font-size: 14px;"><?= $item ?></p>
                                        <?php } ?>

                                    <?php } ?>

                                    <div>
                                        <p onclick="$(this).parent().find('.change-qty').show();$(this).remove();" style="margin-right: 15px;margin-bottom: 0px;display: inline-block;color:#3490dc;cursor: pointer;font-size: 13px;margin-top: 15px;">change quantity</p>

                                        <nobr>
                                            <a style="border-radius: 100%;font-size: 13px;color:#dc3434 !important;;" class="" title="Remove" href="cart.php?delete=<?= $row->cart_id ?>">
                                                remove from cart
                                            </a>

                                        </nobr>


                                        <div class="change-qty" style="display: none;margin-top: 15px;">
                                            <div style="position: relative;max-width: 150px;">
                                                <input style="border-radius:0;display: inline-block;text-align: left !important;padding-right: 65px;" type="number" class="form-control text-center" name="quantity<?= $row->cart_id ?>" value="<?= $row->quantity ?>">

                                                <button style="position: absolute;right:0;bottom:0;height: 34px;" title="Update" type="submit" class="btn btn-default btn-sm">update</button>

                                            </div>



                                        </div>

                                    </div>
                                </td>
                                <td class="mobile-remove" style="vertical-align: middle;font-size: 16px;">
                                    £<?= number_format($row->cart_price, 2) ?>
                                </td>

                                <td class="mobile-remove" style="vertical-align: middle;font-size: 16px;">
                                    £<?= number_format($row->quantity * $row->cart_price, 2) ?>
                                </td>

                            </tr>



                        <?php } ?>

                        <tr>

                            <td colspan="4" style="text-align: right;padding-right: 20px;font-weight: 500 !important;">Total - £<?= number_format($TOTAL, 2) ?></td>
                        </tr>
                    </form>

                </table>

                <?php
                if ($doorstep <= 0) { ?>
                    <p style="color:#dc3434;text-align: right;font-size: 15px;margin-right: 10px;margin-top: 30px;">Please note that the order will be delivered to the doorstep unless installation is selected!</p>
                <?php } ?>

                <p style="color:black;text-align: right;font-size: 15px;margin-right: 10px;margin-top: 30px;">Expect your order to be delivered within 3 - 7 working days - <a href="<?= DOMAIN ?>/delivery-information" style="color:#dc3434">View our Delivery Policy</a></p>

                <a href=" checkout?type=quest" class="btn btn-default pull-right" style="border-radius: 20px;margin-right: 5px;margin-top: 15px;">CHECKOUT <i class="fa fa-chevron-right"></i></a>
                    <br />
                    <br />

                <div style="text-align: right; margin-top: 15px;">
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

        <style>
            .cart-img-block {
                width: 100px;
            }

            .cart-img {
                max-width: 75px;
            }

            @media(max-width: 600px) {
                .mobile-remove {
                    display: none;
                }

                .mobile-show {
                    display: inline-block !important;
                }

                .cart-img {
                    max-width: 50px;
                }

                .cart-img-block {
                    width: 75px;
                }
            }
        </style>


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
        <div class="mt-20 addons" style="position: relative;background: #f2f2f2;padding: 10px;border-radius: 10px;font-size: 15px;">
            <?php
            $productObj = new \App\Product();
            $installation = $productObj->getById(2);

            ?>
            <?= $installation[0]->title ?> (£<?= $installation[0]->price ?>)

            <div class="right-btns" style="font-size: 15px !important;">

                <form action="" method="POST" class="mb-0" style="margin-bottom: 0 !important;">
                    <input type="checkbox" name="installation" id="installation" checked style="display: none">
                    <button onclick="" id="mattress-yes" class="btn btn-primary btn-yes" type="submit">Add</button>

                </form>
            </div>

        </div>
        <!-- <div class="mt-20 addons" style="position: relative;background: #f2f2f2;padding: 10px;border-radius: 10px;padding-right: 80px;font-size: 15px !important; display:none; ">
        <php
        $productObj = new \App\Product();
        $installation = $productObj->getById(3);

        ?>
        <= $installation[0]->title ?> (£<= $installation[0]->price ?>)

        <div class="right-btns">

            <form action="" method="POST" class="mb-0" style="margin-bottom: 0 !important;">
                <input type="checkbox" name="removal" id="removal" checked style="display: none">
                <button onclick="" id="mattress-yes" class="btn btn-primary btn-yes" type="submit">Add</button>

            </form>
        </div>

    </div> -->
    <?php } ?>

</div>


<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body">

                <a href="login" class="btn btn-default form-control">SIGN IN</a><br /><br />
                <a href="checkout?type=guest" class="btn btn-primary form-control">CHECKOUT AS A GUEST</a><br /><br />
                <a href="checkout" class="btn btn-primary form-control">CHECKOUT &amp; CREATE ACCOUNT</a>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<?php require 'footer.php'; ?>