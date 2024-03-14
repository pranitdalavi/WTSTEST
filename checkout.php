<?php

require __DIR__.'/includes/config.php';

if( $user->isAdmin() ){

	redirect( 'console/account?page=home', 'You cannot checkout as a logged in Admin User', 'e' );

}

use App\Order;
$orderObj = new Order;

if( isset($_GET['get']) ){

	foreach($_SESSION as $key => $session){

		$key = str_replace(SESSION, '', $key);

		$results[$key] = $session;

	}


print json_encode($results); exit;

}

if( isset($_POST['first_name']) ){

	if(!isset($_POST['subscribe'])){
	
		unset($_SESSION[SESSION.'subscribe']);
	
	}


    if($_POST["billing"] == "off"){
        $_POST["billing_address_1"] = $_POST["address_1"];
        $_POST["billing_address_2"] = $_POST["address_2"];
        $_POST["billing_town"] = $_POST["town"];
        $_POST["billing_postcode"] = $_POST["postcode"];
        $_POST["billing_country"] = $_POST["country"];
    }

    if($_POST["payment_method"] == "paypal"){
        $orderObj->createOrder();
    }
    if($_POST["payment_method"] == "cash"){
        $orderObj->createOrderCash();
    }
    if($_POST["payment_method"] == "card" or $_POST["payment_method"] == "klarna" or $_POST["payment_method"] == "clearpay" or $_POST["payment_method"] == "googlepay" or $_POST["payment_method"] == "applepay"){
        $_SESSION["shipping_name"] = $_POST["first_name"] . " ". $_POST["first_name"];
        $_SESSION["shipping_email"] = $_POST["email"];
        $_SESSION["shipping_phone"] = $_POST["phone"];
        $_SESSION["shipping_address1"] = $_POST["address1"];
        $_SESSION["shipping_address2"] = $_POST["address2"];
        $_SESSION["shipping_city"] = $_POST["town"];
        $_SESSION["shipping_postcode"] = $_POST["postcode"];
        $orderObj->createOrderCard();
    }



}

$meta_title = COMPANY_NAME.' | Checkout';
include('header.php');

?>

<script>

$(function(){

	$.get('checkout.php?get=sessions', function(data){
		
		var data = jQuery.parseJSON(data);
		
		$('#form input[type=text], input[type=email], textarea').each(function(){
			
			if (typeof data[this.id] !== 'undefined') {
			
				$('#' + this.id).val(data[this.id]);
				
			}
		
		});

	});

});

window.onload = function () {

    if (document.images) {
      preload_image = new Image();
      preload_image.src="images/loading6.gif";
      preload_image = new Image();
      preload_image.src="images/pp.jpg";
      preload_image = new Image();
      preload_image.src="images/cc.jpg";
    }

}

</script>

<style>
    label{
        font-size: 16px;
        font-weight: 600 !important;
    }
    input{
        border-radius: 5px !important;
    }
</style>

<form id="form" action="" method="post">



<div class="container pt-30 pb-50">
    <h1 class="text-center" style="font-weight: 600 !important;">Checkout</h1>
    <br>
    <br>
    <?php if( count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes()) ){   ?>

        <div class="container mt-10" style="padding: 0;">

            <?php require __DIR__.'/includes/flash-messages.php'; ?>

        </div>

    <?php }  ?>
					<div class="panel panel-default">

						<div class="panel-body" style="box-shadow: -5px 5px 20px lightgrey">
				
				            <div class="row">
                                <div class="col-md-12">
                                    <h3 style="font-weight: 500;"><div style="width: 30px;height: 30px;background: #3a004a !important;border-radius: 100%;text-align: center;line-height: 30px;display: inline-block;color:white;font-weight: 600;font-size: 18px;margin-right: 10px;transform: translate(0,-1px)">1</div> Contact Information</h3>
                                    <hr>
                                </div>

                                <div class="col-sm-6 mb-10">
                                    <label for="email">* Email Address</label>
                                    <input required type="text" class="form-control" name="email" id="email" value="<?php if(isset($user->auth()->email)){ print strtolower($user->auth()->email); } ?>">
                                </div>

                                <div class="col-sm-6 mb-10">
                                    <div class="form-group">
                                        <label for="phone">* Phone</label>
                                        <input required type="text" class="form-control" name="phone" id="phone" value="<?php if(isset($user->auth()->phone)){ print $user->auth()->phone; } ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-10">
                                    <div class="form-group">
                                        <label for="first_name">* First Name</label>
                                        <input required type="text" class="form-control" name="first_name" id="first_name" value="<?php if(isset($user->auth()->first_name)){ print ucwords($user->auth()->first_name); } ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-10">
                                    <div class="form-group">
                                        <label for="last_name">* Last Name</label>
                                        <input required type="text" class="form-control" name="last_name" id="last_name" value="<?php if(isset($user->auth()->last_name)){ print ucwords($user->auth()->last_name); } ?>">
                                    </div>
                                </div>



				            </div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 style="font-weight: 500;"><div style="width: 30px;height: 30px;background: #3a004a !important;border-radius: 100%;text-align: center;line-height: 30px;display: inline-block;color:white;font-weight: 600;font-size: 18px;margin-right: 10px;transform: translate(0,-1px)">2</div> Shipping Information</h3>
                                        <hr>
                                    </div>


				    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address_1">* Address 1</label>
		<input required type="text" class="form-control" name="address_1" id="address_1" value="<?php if(isset($user->auth()->address_1)){ print ucwords($user->auth()->address_1); } ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address_2">Address 2</label>
                                            <input type="text" class="form-control" name="address_2" id="address_2" value="<?php if(isset($user->auth()->address_2)){ print ucwords($user->auth()->address_2); } ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="town">* Town</label>
                                            <input required type="text" class="form-control" name="town" id="town" value="<?php if(isset($user->auth()->town)){ print ucwords($user->auth()->town); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="postcode">* Postcode</label>
                                            <input required type="text" class="form-control" name="postcode" id="postcode" value="<?php if(isset($user->auth()->postcode)){ print strtoupper($user->auth()->postcode); } ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="country">* Country</label>
                                            <input required type="text" class="form-control" name="country" id="country" value="<?php if(isset($user->auth()->country)){ print strtoupper($user->auth()->country); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-30">
                                        <script>
                                            function checkBilling(that){
                                                if ($(that).is(':checked')) {
                                                    $("#billings").hide();
                                                    $("#step-note").text("3");
                                                    $("#step-payment").text("4");

                                                    $("#billing_address_1").removeAttr("required")
                                                    $("#billing_town").removeAttr("required")
                                                    $("#billing_postcode").removeAttr("required")
                                                    $("#billing_country").removeAttr("required")
                                                    $("#billing_input").val("off");
                                                }
                                                else{
                                                    $("#billings").show();
                                                    $("#step-note").text("4");
                                                    $("#step-payment").text("5");

                                                    $("#billing_address_1").attr("required","required")
                                                    $("#billing_town").attr("required","required")
                                                    $("#billing_postcode").attr("required","required")
                                                    $("#billing_country").attr("required","required")
                                                    $("#billing_input").val("on");
                                                }
                                            }
                                        </script>
                                        <input onchange="checkBilling(this)" style="margin-left: 5px;" type="checkbox" checked> Billing same as shipping
                                        <input name="billing" id="billing_input" value="off" type="hidden">
                                    </div>
				    
				</div>
                            
                            <div class="row" style="display: none;" id="billings">
                                <div class="col-md-12">
                                    <h3 style="font-weight: 500;"><div style="width: 30px;height: 30px;background: #3a004a !important;border-radius: 100%;text-align: center;line-height: 30px;display: inline-block;color:white;font-weight: 600;font-size: 18px;margin-right: 10px;transform: translate(0,-1px)">3</div> Billing Information</h3>
                                    <hr>
                                </div>



                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address_1">* Address 1</label>
                                        <input type="text" class="form-control" name="billing_address_1" id="billing_address_1" value="<?php if(isset($user->auth()->billing_address_1)){ print ucwords($user->auth()->billing_address_1); } ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address_2">Address 2</label>
                                        <input type="text" class="form-control" name="billing_address_2" id="billing_address_2" value="<?php if(isset($user->auth()->billing_address_2)){ print ucwords($user->auth()->billing_address_2); } ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="town">* Town</label>
                                        <input type="text" class="form-control" name="billing_town" id="billing_town" value="<?php if(isset($user->auth()->billing_town)){ print ucwords($user->auth()->billing_town); } ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="postcode">* Postcode</label>
                                        <input type="text" class="form-control" name="billing_postcode" id="billing_postcode" value="<?php if(isset($user->auth()->billing_postcode)){ print strtoupper($user->auth()->billing_postcode); } ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="country">* Country</label>
                                        <input type="text" class="form-control" name="billing_country" id="billing_country" value="<?php if(isset($user->auth()->billing_country)){ print strtoupper($user->auth()->billing_country); } ?>">
                                    </div>
                                </div>


                            </div>
                                <!-- /.row -->
				

				
				<div class="row">
                    <div class="col-md-12">
                        <h3 style="font-weight: 500;"><div style="width: 30px;height: 30px;background: #3a004a !important;border-radius: 100%;text-align: center;line-height: 30px;display: inline-block;color:white;font-weight: 600;font-size: 18px;margin-right: 10px;transform: translate(0,-1px)" id="step-note">3</div> Notes</h3>
                        <hr>
                    </div>
                    <div class="col-md-12 mb-20">
                        <textarea name="notes" rows="5" class="form-control" id="notes" placeholder="Please send us any delivery notes or special requirements you may have..."></textarea>
                    </div>


                </div>

				
				<div class="row mt-0">
                    <div class="col-md-12">
                        <h3 style="font-weight: 500;"><div style="width: 30px;height: 30px;background: #3a004a !important;border-radius: 100%;text-align: center;line-height: 30px;display: inline-block;color:white;font-weight: 600;font-size: 18px;margin-right: 10px;transform: translate(0,-1px)" id="step-payment">4</div> Payment Method</h3>
                        <hr>
                        <select class="form-control" onchange="selectMethod(this);" required>
                            <option value="" selected disabled>Select Payment Method</option>
                            <option value="credit">Debit/Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="klarna">Klarna</option>
                            <option value="clearpay">Clearpay</option>
                            <option value="googlepay">Google Pay</option>
                            <option value="applepay">Apple Pay</option>
                            <option value="cash">Cash on Delivery</option>
                        </select>
                    </div>

                    <script>
                        function selectMethod(that){
                            if($(that).val() == "cash"){
                                $('#payment_method').val('cash');
                            }

                            if($(that).val() == "credit"){
                                $('#payment_method').val('card');
                            }
                            if($(that).val() == "klarna"){
                                $('#payment_method').val('klarna');
                            }
                            if($(that).val() == "clearpay"){
                                $('#payment_method').val('clearpay');
                            }
                            if($(that).val() == "googlepay"){
                                $('#payment_method').val('googlepay');
                            }
                            if($(that).val() == "applepay"){
                                $('#payment_method').val('applepay');
                            }

                            if($(that).val() == "paypal"){
                                $('#payment_method').val('paypal');
                            }
                        }
                    </script>
                    <div class=" col-md-12 mb-10 mt-20">
                        <p style="font-size: 15px;">Tick the relevant box if you wish to receive sale and other information relating to Comfort Beds.</p>
                        <div style="font-size: 14px;">
                            <input type="checkbox" onclick="contactsAdd('post')"> Post<br>
                            <input type="checkbox" onclick="contactsAdd('telephone')"> Telephone<br>
                            <input type="checkbox" onclick="contactsAdd('sms')"> SMS<br>
                            <input type="checkbox" onclick="contactsAdd('email')"> E-mail<br>

                            <script>
                                var contacts = [];
                                function contactsAdd(value){
                                    if(!contacts.includes(value)){
                                        contacts.push(value);
                                    }
                                    else{
                                        for (let i = 0; i < contacts.length; i++) {
                                            if(contacts[i] == value){
                                                contacts.splice(i,1);
                                            }
                                        }
                                    }

                                    let x = "";
                                    for (let i = 0; i < contacts.length; i++) {
                                        x += "," + contacts[i];
                                    }
                                    x = x.substring(1);
                                    $("#contacts").val(x);
                                }
                            </script>
                            <input name="contacts" id="contacts" type="hidden">

                        </div>
                    </div>

                    <?php

                    $cookie_name = "CustomerSource";

                    if (isset($_COOKIE[$cookie_name])) {
                        $customerSource = $_COOKIE[$cookie_name];
                    } else {
                        $customerSource = 'none';
                    }
                    ?>


                    <input type="hidden" class="form-control" name="customerSourceOrder" id="customerSourceOrder" value="<?= $customerSource ?>">

                    <div class=" col-md-6 mb-10">

                        <input name="payment_method" id="payment_method" value="card" type="hidden">
                        <button id="cash-submit" type="submit" class="btn btn-default submit-button mt-10" style="border-radius: 15px;">Complete Payment <i class="fa fa-chevron-right"></i> </button>

                    </div>






                                </div>

                                <!-- /.row -->
		</div>
		</div>

	
            </div>


</form>

    

<?php include('footer.php'); ?>