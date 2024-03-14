<?php 

require __DIR__.'/includes/config.php';

if( isset($_POST['email']) ){

	$user->requestPasswordReset($_POST['email']);

}

if( isset($_GET['get']) ){

	foreach($_SESSION as $key => $session){

		$key = str_replace(SALT, '', $key);

		$results[$key] = $session;

	}

print json_encode($results); exit;

}
$meta_title = COMPANY_NAME.' | Forgotten Password';
include('header.php'); ?>

<script>

$(function(){

	$.get('forgot-password.php?get=sessions', function(data){
		
		var data = jQuery.parseJSON(data);
		
		$('#form input[type=text], input[type=email').each(function(){
			
			if (typeof data[this.id] !== 'undefined') {
			
				$('#' + this.id).val(data[this.id]);
				
			}
		
		});

	});

});

</script>


<div class="container pt-30 pb-50">
    <h1 class="text-center" style="font-weight: 600 !important;">Forgotten Password?</h1>
    <br>

<?php require __DIR__.'/includes/flash-messages.php'; ?>
    <Br>
		
		<form class="form-horizontal form-light" id="form" method="post" action="">

					<div class="panel panel-default">
						<div class="panel-heading">ENTER YOUR EMAIL ADDRESS</div>
						<div class="panel-body">
                            <p class="mt-10 mb-10" style="font-size: 16px;">Just enter your email address and we will send you a link where you can reset your password.</p>
                            <input placeholder="Email address..." type="text" class="form-control" id="email" name="email">

                            <button type="submit" class="btn btn-default" style="border-radius: 15px;margin-top: 20px;"> REQUEST LINK </button>
							
						</div>
					</div>
			

		
		</form>

            </div>


    

<?php include('footer.php'); ?>