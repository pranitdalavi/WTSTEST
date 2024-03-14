<?php
if( count(get_included_files()) == 1 ){
	header('Location: /');
	exit();
}
?>

<?php

if(!isset($_GET['id']) || ( isset($_GET['id']) && $_GET['id'] == '' ) ){

	return redirect( 'account.php?page=home', 'There was an error with your page URL', 'e' );

}

$id = $_GET['id'];
?>
<div class="page-block">
	<?php
	include('console/admin-includes/order.php');
	?>
	<style>
		.page-block *{
			font-size: 15px !important;
		}
	</style>

</div>
