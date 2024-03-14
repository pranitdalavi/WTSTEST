<?php

require __DIR__.'/includes/config.php';
use App\Helpers\Tools;

if(empty($_GET['remember_token'])){

	Tools::error('There has been an error with the reset link. Please try clicking the link again from your email.');

}

if(isset($_POST['remember_token']) && $_POST['remember_token'] != ''){

	$user->resetPassword($_POST['remember_token']);

}

$meta_title = COMPANY_NAME.' | Change Password';

?>

<?php include('header.php'); ?>



<div class="container pt-30 pb-50">
    <h1 class="text-center" style="font-weight: 600 !important;">Change Password</h1>

    <?php require __DIR__.'/includes/flash-messages.php'; ?>
    <Br>

		
		<form class="form-horizontal form-light" method="post" action="">
		<?php if(!empty($_GET['remember_token'])){ ?><input type="hidden" name="remember_token" value="<?= $_GET['remember_token']; ?>">	<?php } ?>



					<div class="panel panel-default">
						<div class="panel-heading">CHANGE PASSWORD</div>
						<div class="panel-body">
                            <p style="font-size: 16px;" class="mt-10 mb-20">You will then be able to login with your email address and new password.</p>

                            <label>New password</label>
                            <input type="password" class="form-control mb-20" name="password">

                            <label>Repeat password</label>
                            <input type="password" class="form-control" name="repeat_password">



                            <button type="submit" class="btn btn-default mt-10" style="border-radius: 15px;">CHANGE PASSWORD</button>
						</div>
					</div>
			

		
		</form>		

</div>


<?php include('footer.php'); ?>