<?php

if($action == 'edit'){

	$row = $user->find($id);

}

if( isset($_POST['first_name']) ){
	
	$user->updateCustomer($id);
		
}

?>

<h1>CUSTOMER</h1>

	<form id="form" class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> CUSTOMER</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">First Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="first_name" name="first_name" value="<?= $row->first_name; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Last Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="last_name" name="last_name" value="<?= $row->last_name; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email Address</label>
									<div class="col-md-6">
										<input type="email" class="form-control" id="email" name="email" value="<?= $row->email; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Phone</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="phone" name="phone" value="<?= $row->phone; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address 1</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="address_1" name="address_1" value="<?= $row->address_1; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address 2</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="address_2" name="address_2" value="<?= $row->address_2; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Town</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="town" name="town" value="<?= $row->town; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Country</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="country" name="country" value="<?= $row->country; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Postcode</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="postcode" name="postcode" value="<?= $row->postcode; ?>">
									</div>
								</div>
								


								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> CUSTOMER </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

