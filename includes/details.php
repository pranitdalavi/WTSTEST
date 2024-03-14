<?php
if( count(get_included_files()) == 1 ){
	header('Location: /');
	exit();
}
?>

<?php

if( isset($_POST['first_name']) && !$user->isAdmin() ){

	$user->updateCustomer();

}

?>
<style>
    .control-label{
        font-size: 15px;
    }
</style>


	<form class="form-horizontal form-light" method="post" action="">

					<div class="panel panel-default mb-30">
						<div class="panel-heading"><a href="account?page=home"><i class="fa fa-home"></i> ACCOUNT HOME</a> | UPDATE DETAILS</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">First Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user->auth()->first_name; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Last Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user->auth()->last_name; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email Address</label>
									<div class="col-md-6">
										<input type="email" class="form-control" id="email" name="email" value="<?= $user->auth()->email; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Phone</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="phone" name="phone" value="<?= $user->auth()->phone; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address 1</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="address_1" name="address_1" value="<?= $user->auth()->address_1; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address 2</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="address_2" name="address_2" value="<?= $user->auth()->address_2; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Town</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="town" name="town" value="<?= $user->auth()->town; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Country</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="country" name="country" value="<?= $user->auth()->country; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Postcode</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="postcode" name="postcode" value="<?= $user->auth()->postcode; ?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-default" style="border-radius: 15px;"> UPDATE DETAILS </button>
									</div>
								</div>

							
						</div>
					</div>
		
		
	</form>



		
	