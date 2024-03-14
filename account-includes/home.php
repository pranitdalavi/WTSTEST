
<div class="panel panel-default mb-50">
<div class="panel-heading"><i class="fa fa-home"></i> ACCOUNT | WELCOME <?= strtoupper($user->auth()->first_name); ?></div>
	<div class="panel-body">
		
		<div class="row mb-50 mt-50">
		
		
			<div  class="col-md-3 mb-10"> <a style="font-size: 15px;" class="btn btn-default full-width font-bigger" href="account?page=orders"><i class="fa fa-shopping-cart"></i> MY ORDERS</a> </div>
			
			<div  class="col-md-3 mb-10"> <a style="font-size: 15px;" class="btn btn-default full-width font-bigger" href="account?page=details"><i class="fa fa-user"></i> MY DETAILS</a> </div>
			
			<div  class="col-md-3 mb-10"> <a style="font-size: 15px;" class="btn btn-default full-width font-bigger" href="account?page=change-password"><i class="fa fa-cog"></i> CHANGE PASSWORD</a> </div>
			
			<div  class="col-md-3"> <a style="font-size: 15px;" class="btn btn-default full-width font-bigger " href="login?log=out"><i class="fa fa-sign-out"></i> SIGN OUT</a> </div>
		
		
		</div>
		
</div>
</div>