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

	$orderObj->createOrder();

}

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

<form id="form" action="" method="post">

	<div class="container mb-0 mt-30">
			<div class="col-md-4 hidden-xs hidden-sm" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
			<div class="col-md-4 text-center">  <h1 class="mt-10"><i class="fa fa-shopping-basket"></i> CHECKOUT</h1> </div>
			<div class="col-md-4" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
	</div>

	<div class="container mt-10">
	
<?php require __DIR__.'/includes/flash-messages.php'; ?>
	
	</div>

<div class="container pt-30 pb-50">
				
				<div class="row">
				
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="email">* Email Address</label>
                                            <input type="text" class="form-control" name="email" id="email" value="<?php if(isset($user->auth()->email)){ print strtolower($user->auth()->email); } ?>">
                                        </div>
                                    </div>
				    
				<?php if( !$user->auth() ){ ?>
				    
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="email">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Optional to create an account...">
                                        </div>
                                    </div>
				    
				<?php } ?>				    

				</div>
	    
		<br /><h3 style="color:#333333">CHECKOUT - DELIVERY ADDRESS</h3> <br />


                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="first_name">* First Name</label>
		<input type="text" class="form-control" name="first_name" id="first_name" value="<?php if(isset($user->auth()->first_name)){ print ucwords($user->auth()->first_name); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="last_name">* Last Name</label>
		<input type="text" class="form-control" name="last_name" id="last_name" value="<?php if(isset($user->auth()->last_name)){ print ucwords($user->auth()->last_name); } ?>">
                                        </div>
                                    </div>
				    
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
		<input type="text" class="form-control" name="phone" id="phone" value="<?php if(isset($user->auth()->phone)){ print $user->auth()->phone; } ?>">
                                        </div>
                                    </div>				    
				    
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="address_1">* Address 1</label>
		<input type="text" class="form-control" name="address_1" id="address_1" value="<?php if(isset($user->auth()->address_1)){ print ucwords($user->auth()->address_1); } ?>">
                                        </div>
                                    </div>

				    
				</div>
				
				<div class="row">
				
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="address_2">Address 2</label>
		<input type="text" class="form-control" name="address_2" id="address_2" value="<?php if(isset($user->auth()->address_2)){ print ucwords($user->auth()->address_2); } ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="town">* Town</label>
		<input type="text" class="form-control" name="town" id="town" value="<?php if(isset($user->auth()->town)){ print ucwords($user->auth()->town); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="postcode">* Postcode</label>
		<input type="text" class="form-control" name="postcode" id="postcode" value="<?php if(isset($user->auth()->postcode)){ print strtoupper($user->auth()->postcode); } ?>">
                                        </div>
                                    </div>
				    
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="country">Country</label>
			<input type="text" class="form-control" name="country" id="country" value="<?php if(isset($user->auth()->country)){ print strtoupper($user->auth()->country); } ?>">
                                        </div>
                                    </div>


                                </div>
                                <!-- /.row -->
				
		<br /><h3 style="color:#333333;margin-bottom:0px">CHECKOUT - NOTES</h3> 				
				
				<div class="row">
				
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address_2"></label>
					<textarea name="notes" rows="5" class="form-control" id="notes" placeholder="Please send any delivery or special requirements you may have..."></textarea>
                                        </div>
                                    </div>
				    
                                </div>
                                <!-- /.row -->
				
				
				<div class="row">
				
                                    <div class="col-sm-6 col-md-3">
				    
				<input type="checkbox" id="terms_check" name="terms_check"> <label for="terms_check">I agree to Get Goods' </label> <a target="_blank" href="terms-conditions.php">T&amp;Cs</a>
                                       
                                    </div>

                                    <div class="col-sm-6 col-md-3">
				    

                                  
                                    </div>

                                    <div class="col-sm-6 col-md-3">

                             
                                    </div>
				    
                                    <div class="col-sm-6 col-md-3 mb-50">
					
				<button type="submit" class="btn btn-default submit-button full-width" > PAYMENT <i class="fa fa-chevron-right"></i> </button>
				    
                                    </div>


                                </div>
                                <!-- /.row -->


	
            </div>


</form>
    

<?php include('footer.php'); ?>