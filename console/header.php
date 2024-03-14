<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="<?= DOMAIN ?>/images/COMFORT%20BEDS%20favicon.png" rel="icon">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= COMPANY_NAME ?> - Admin</title>
	<link rel="stylesheet" href="<?= DOMAIN ?>/font-awesome/css/font-awesome.min.css">
	<link href="<?= DOMAIN;  ?>/css/admin-styles.css" rel="stylesheet">
	<script src="<?= DOMAIN;  ?>/js/jquery-1.11.3.min.js"></script>
	<script src="<?= DOMAIN;  ?>/js/bootstrap.min.js"></script>
	<script>
		$(function(){

			$('#status').change(function(){

				$('#status_form').submit();

			});


		});
	</script>
</head>
<body>
	<nav class="navbar navbar-default no-border">
		<div class="container-fluid bg-main" style="padding-left:5%;padding-right:5%">

				<div class="navbar-header">
					<a class="pull-left mt-10 ml-10 hidden-lg hidden-md mb-10" href="<?= DOMAIN ?>/console/account?page=home"><?= strtoupper(COMPANY_NAME); ?> ADMIN</a>
					<?php if( $user->auth() ){  ?>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php } ?>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav visible-lg visible-md">
						<li><a href="<?= DOMAIN ?>/console/account?page=home"><?= strtoupper(COMPANY_NAME); ?> ADMIN</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">

					<?php if( $user->auth() ){  ?>

							<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome <?php print ucwords($user->auth()->first_name); ?> <span class="caret"></span></a>
								<ul class="dropdown-menu">
									

									<li><a href="<?= DOMAIN;  ?>/console/account.php?page=home">Dashboard</a></li>
									<li><a target="_blank" href="<?= DOMAIN ?>/">View Website</a></li>

									<br />

									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=company_details">Company Details</a></li>

									<br />
									
									<li ><a href="<?= DOMAIN;  ?>/console/account.php?page=categories">Categories</a></li>
								
									<br />

									<li><a href="<?= DOMAIN;  ?>/console/account.php?page=products">Products</a></li>
									<li><a href="<?= DOMAIN;  ?>/console/account.php?page=attributes&category=all">Attributes</a></li>
									<li><a href="<?= DOMAIN;  ?>/console/account.php?page=dimensions">Dimensions</a></li>

									<br />

									<li><a href="<?= DOMAIN;  ?>/console/account.php?page=orders&status=New">Orders</a></li>
									<li><a href="<?= DOMAIN;  ?>/console/account.php?page=customers">Customers</a></li>
									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=cartTotal">Cart Activity</a></li>
									
									<br />

									<li><a href="<?= DOMAIN;  ?>/console/account.php?page=change-password">Change Password</a></li>
									<li><a href="<?= DOMAIN;  ?>/console/login.php?log=out">Logout</a></li>



									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=pages">Pages</a></li>
									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=brands">Brands</a></li>
									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=contents">Contents</a></li>
									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=sub-categories">Sub Categories</a></li>
									<!--<li><a href="<?= DOMAIN;  ?>/console/account.php?page=blogs">Blog</a></li>-->
									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=promos">Promo Codes</a></li>
									<li style="display: none"><a href="<?= DOMAIN;  ?>/console/account.php?page=gallery&action=add">Banners</a></li>
								</ul>
							</li>

					<?php } ?>

					</ul>
				</div>

		</div>
	</nav>
