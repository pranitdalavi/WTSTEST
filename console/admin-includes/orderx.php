<?php

use App\Order;
use App\ProductsFromOrder;

$orderObj = new Order;
$productsFromOrderObj = new ProductsFromOrder;

if( !$orderObj->canView($id) && !$user->isAdmin() ){

	return redirect( 'account.php?page=home', 'You are not authourised to view that page!', 'e' );

}
	
	$row = $orderObj->find($id);
	$query = $productsFromOrderObj->getAll($id);
	
	if( isset($_POST['status']) && $user->isAdmin() & isset($id) ){
	
		$orderObj->updateStatus($id);
	
	}

?>

<h1>VIEW ORDER</h1>

					<form class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading">ORDER STATUS</div>
						<div class="panel-body">
						
						<?php  if( $user->isAdmin() ){  ?>
						
								<div class="form-group">
									<label class="col-md-4 control-label">Status</label>
									<div class="col-md-6">
									<select class="form-control" name="status">
									<option value="New" <?php if(isset($row) && $row->status == 'New'){ print 'selected'; } ?>>New</option>
									<option value="Completed" <?php if(isset($row) && $row->status == 'Completed'){ print 'selected'; } ?>>Completed</option>
									<option value="Pending" <?php if(isset($row) && $row->status == 'Pending'){ print 'selected'; } ?>>Pending</option>
									</select>
									</div>
								</div>
						
						<?php } else { ?>
						
								<div class="form-group">
									<label class="col-md-4 control-label">Status</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->status; } ?>
									</div>
								</div>
						
						<?php }  ?>
						

						
								<div class="form-group">
									<label class="col-md-4 control-label">Date</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print date('d/m/Y H:i', strtotime($row->created_at)); } ?>
									</div>
								</div>
								
								<!--
								
								<div class="form-group">
									<label class="col-md-4 control-label">Promo Code</label>
									<div class="col-md-6 pt-7">
										<?= $row->promo_code_id ? strtoupper($promoObj->find($row->promo_code_id)->code).' - '.$promoObj->find($row->promo_code_id)->percentage.'%' : '-' ?>
									</div>
								</div>
								
								-->
								
								<div class="form-group">
									<label class="col-md-4 control-label">Order Cost</label>
									<div class="col-md-6 pt-7">
										£<?=  number_format(($row->cost + $row->shipping), 2) ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Shipping</label>
									<div class="col-md-6 pt-7">
										£<?=  $row->shipping ?>
									</div>
								</div>								


								<?php if($user->isAdmin()){ ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> EDIT STATUS </button>
									</div>
								</div>
								
								<?php } ?>
							
						</div>
					</div>
		
		
				</form>	

<?php

	$row = $user->find($row->user_id);

?>


						<div class="panel panel-default form-horizontal">
						<div class="panel-heading">CUSTOMER DETAILS</div>
						<div class="panel-body">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Customer Name</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print ucwords($row->first_name).' '.ucwords($row->last_name); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address</label>
									<div class="col-md-6 pt-7">
<?php if(isset($row)){ print ucwords($row->address_1); } if(isset($row->address_2) && $row->address_2 != ''){ print ', '.ucwords($row->address_2); } print ', '.ucwords($row->town).', '.strtoupper($row->postcode); if(isset($row->country)){ print ', '.strtoupper($row->country); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print strtolower($row->email); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Phone</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->phone; } ?>
									</div>
								</div>
							
						</div>
						</div>
				


						<div class="panel panel-default form-horizontal">
						<div class="panel-heading">ORDER DETAILS</div>
						<div class="panel-body">
						
						<?php $i = 0; foreach($query as $row){ ?>
						
							<?php if($i > 0){ print "<hr />"; } ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Product</label>
									<div class="col-md-6 pt-7">
										<?= $row->title ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Options</label>
									<div class="col-md-6 pt-7">
										<?= $row->options ?>
									</div>
								</div>								
								
								<div class="form-group">
									<label class="col-md-4 control-label">Quantity</label>
									<div class="col-md-6 pt-7">
										<?= $row->quantity ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Individual Price</label>
									<div class="col-md-6 pt-7">
										<?= $row->price ?>
									</div>
								</div>

								
							<?php $i++; } ?>
							
						</div>
						</div>