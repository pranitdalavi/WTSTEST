<?php

$nowDate = date('Y-m-d'); 


?>

<?php

	$orderObj = new App\Order;

	$cartObj = new App\Cart;

?>

<h1>DASHBOARD</h1>

<style>
	.white {
		color: #fff
	}

	.font-big {
		font-size: 50px
	}

	.opacity {
		opacity: 0.5
	}
</style>

<br class="hidden-xs" />
<br class="hidden-xs" />
<div class="row">

<a href="<?= DOMAIN ?>/console/account?page=orders&status=Paid" style="text-decoration:none"> 

	<div class="col-md-4">

		<h5 style="background:#722282;color:#fff;padding:10px;margin-bottom:0px"><strong>TOTAL PAID ORDERS</strong></h5>

		<div class="col-md-12" style="background:#EAEAEA">

			<div class="row">

				<div class="col-md-3 col-sm-3 col-xs-3" style="padding-top:20px;padding-bottom:20px"> <i class="fa fa-shopping-cart black font-big opacity"></i> </div>
				<div class="col-md-9 col-sm-9 col-xs-9 black font-big text-right" style="padding-top:10px;padding-bottom:20px;color:#722282"><?= $orderObj->totalOrders() ?></div>

			</div>

		</div>

	</div>
</a>


<a href="<?= DOMAIN ?>/console/account?page=orders&status=Paid" style="text-decoration:none">


	<div class="col-md-4">

		<h5 style="background:#722282;color:#fff;padding:10px;margin-bottom:0px"><strong>TOTAL SALES</strong></h5>

		<div class="col-md-12" style="background:#EAEAEA">

			<div class="row">

				<div class="col-md-3 col-sm-3 col-xs-3" style="padding-top:20px;padding-bottom:20px"> <i class="fa fa-gbp black font-big opacity"></i> </div>
				<div class="col-md-9 col-sm-9 col-xs-9 black font-big text-right" style="padding-top:10px;padding-bottom:20px;color:#722282">£<?= number_format($orderObj->orderTotal(), 2) ?></div>

			</div>

		</div>

	</div>
</a>



<a href="<?= DOMAIN ?>/console/account?page=orders&status=Pending" style="text-decoration:none">

	<div class="col-md-4">

		<h5 style="background:#722282;color:#fff;padding:10px;margin-bottom:0px"><strong>TOTAL PENDING ORDERS (Duplicates removed)</strong></h5>

		<div class="col-md-12" style="background:#EAEAEA">

			<div class="row">

				<div class="col-md-3 col-sm-3 col-xs-3" style="padding-top:20px;padding-bottom:20px"> <i class="fa fa-shopping-cart black font-big opacity"></i> </div>
				<div class="col-md-9 col-sm-9 col-xs-9 black font-big text-right" style="padding-top:10px;padding-bottom:20px;color:#722282"><?= $orderObj->totalPendingOrders() ?></div>

			</div>

		</div>

	</div>
</a>

	

	
<a href="<?= DOMAIN ?>/console/account?page=orders&status=Paid" style="text-decoration:none">

	<div class="col-md-4">

		<h5 style="background:#722282;color:#fff;padding:10px;margin-bottom:0px"><strong><?= strtoupper(date('F')); ?> PAID ORDERS</strong></h5>

		<div class="col-md-12" style="background:#EAEAEA">

			<div class="row">

				<div class="col-md-3 col-sm-3 col-xs-3" style="padding-top:20px;padding-bottom:20px"> <i class="fa fa-shopping-cart black font-big opacity"></i> </div>
				<div class="col-md-9 col-sm-9 col-xs-9 black font-big text-right" style="padding-top:10px;padding-bottom:20px;color:#722282"><?= $orderObj->totalOrdersMonth($nowDate) ?></div>

			</div>

		</div>

	</div>

</a>


<a href="<?= DOMAIN ?>/console/account?page=orders&status=Paid" style="text-decoration:none">

	<div class="col-md-4">

		<h5 style="background:#722282;color:#fff;padding:10px;margin-bottom:0px"><strong><?= strtoupper(date('F')); ?> SALES</strong></h5>

		<div class="col-md-12" style="background:#EAEAEA">

			<div class="row">

				<div class="col-md-3 col-sm-3 col-xs-3" style="padding-top:20px;padding-bottom:20px"> <i class="fa fa-gbp black font-big opacity"></i> </div>
				<div class="col-md-9 col-sm-9 col-xs-9 black font-big text-right" style="padding-top:10px;padding-bottom:20px;color:#722282">£<?= number_format($orderObj->orderTotalMonth(), 2) ?></div>

			</div>

		</div>

	</div>
</a>

	


	<a href="<?= DOMAIN ?>/console/account?page=cart" style="text-decoration:none">
		<div class="col-md-4">

			<h5 style="background:#722282;color:#fff;padding:10px;margin-bottom:0px"><strong>CART ACTIVITY (includes paid orders) </strong></h5>

			<div class="col-md-12" style="background:#EAEAEA">

				<div class="row">

					<div class="col-md-12 col-sm-12 col-xs-12 black font-big text-left" style="padding-top:10px;padding-bottom:20px;color:#722282"><?= $cartObj->totalCart() ?> <small style="font-size:12px;font-weight:400;padding: 0;margin: 0;line-height: 0;">Products added basket-<?= date('F'); ?></small></div>

				</div>

			</div>

		</div>
	</a>
	

	

</div>