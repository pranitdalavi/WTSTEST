<?php

ob_start();

require __DIR__.'/includes/config.php';

$user->checkAuth();

if( $user->isAdmin() ){
	
	redirect( 'console/account.php?page=home' );

}

if(empty($_GET['page'])){ redirect('account.php?page=home'); }

$page = $_GET['page'];
$meta_title = COMPANY_NAME.' | My Account';
require __DIR__.'/header.php';

?>

<style>.alert{ margin-bottom:20px }</style>

            <div class="container pt-40">

<?php

require __DIR__.'/includes/flash-messages.php';
		
		switch($_GET['page']){

			case 'details':
			include('includes/details.php');
			break;
			
			case 'change-password':
			include('includes/change-password.php');
			break;
			
			case 'error':
			include('account-includes/error.php');
			break;
			
			case 'orders':
			include('account-includes/orders.php');
			break;
			
			case 'order':
			include('account-includes/order.php');
			break;
			
			default:
			include('account-includes/home.php');

		}
		
		?>		

            </div>


<?php require __DIR__.'/footer.php'; ?>