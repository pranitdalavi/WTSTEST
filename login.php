<?php

require __DIR__.'/includes/config.php';

if( isset($_POST['email']) ){

	$user->login($user_role_id = 1);

}

if( isset($_GET['log']) ){

	App\User::logout();

}

if($user->auth()){

	redirect( 'account.php?page=home');

}

$meta_title = COMPANY_NAME.' | Login';
require __DIR__.'/header.php';

?>



	<?php if( count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes()) ){   ?>

	<div class="container mt-10 mb-10">

<?php require __DIR__.'/includes/flash-messages.php'; ?>

	</div>

	<?php } ?>

<style>
    .page-block * {
        font-size: 15px;
    }
</style>
<div class="container pt-30 pb-50 page-block">

		<form class="form-horizontal form-light" id="form" method="post" action="">

					<div class="panel panel-default">
					<div class="panel-heading">PLEASE LOGIN TO YOUR ACCOUNT HERE <?php if( $_GET['new-account-registered'] == 'true') {
					echo "<span style='color:green;'> - New Account Registered, please login using the details below.</span>";
			} ?></div>
						<div class="panel-body">

								<div class="form-group">
									<label class="col-md-4 control-label">Email Address</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="email" name="email" value="<?php if( $_GET['email'] != '') { echo $_GET['email']; } else ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="password">
									</div>
								</div>


								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-default" style="margin-right: 10px;border-radius: 15px;min-width: 120px;margin-bottom: 20px;margin-top: 15px;">LOGIN</button>

                                        <nobr>
                                            <a href="<?= DOMAIN ?>/forgot-password.php" style="font-size: 15px;margin-bottom: 20px;">Forgotten Your Password?</a>

                                        </nobr>
									</div>
								</div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <hr>
                                    <p style="font-size: 16px;">New customer? <a href="<?= DOMAIN ?>/sign-up" style="font-size: 15px;">Create an account</a></p>
                                </div>
                            </div>


						</div>
					</div>


		</form>


</div>

<?php require __DIR__.'/footer.php'; ?>
