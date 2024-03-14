<?php

ob_start();

require __DIR__.'/../includes/config.php';

$user->checkAuth();

if( !$user->isAdmin() ){

	redirect( '../login.php', 'You are not authourised to view that page.', 'e' );

}

if(empty($_GET['page'])){ redirect('account.php?page=home'); }

$page = $_GET['page'];
 
if(isset($_GET['id'])){ $id = $_GET['id']; }
if(isset($_GET['action'])){ $action = $_GET['action']; }

if( isset($_GET['get']) ){

	$results = [];

	foreach($_SESSION as $key => $session){

		$key = str_replace(SESSION, '', $key);

		$results[$key] = $session;

	}


print json_encode($results); exit;

}

?>

<?php include(dirname(__FILE__).'/header.php'); ?>

<div class="container-fluid" style="padding-left:5%;padding-right:5%">

<?php require __DIR__.'/../includes/flash-messages.php'; ?>

		<?php
		
		switch($_GET['page']){

			
			case 'change-password':
			include('../includes/change-password.php');
			break;

			case 'customers':
			include('admin-includes/customers.php');
			break;
			
			case 'gallery':
			include('admin-includes/gallery.php');
			break;
			
			case 'customer':
			include('admin-includes/customer.php');
			break;
			
			case 'products':
			include('admin-includes/products.php');
			break;
			
			case 'product':
			include('admin-includes/product.php');
			break;

			case 'cartTotal':
				include('admin-includes/cartTotal.php');
				break;
	

            case 'attributes':
			include('admin-includes/attributes.php');
			break;

			case 'attribute':
			include('admin-includes/attribute.php');
			break;

            case 'dimensions':
			include('admin-includes/dimensions.php');
			break;

			case 'dimension':
			include('admin-includes/dimension.php');
			break;

            case 'brands':
                include('admin-includes/brands.php');
                break;

            case 'brand':
                include('admin-includes/brand.php');
                break;

			case 'sub-categories':
			include('admin-includes/sub-categories.php');
			break;
			
			case 'sub-category':
			include('admin-includes/sub-category.php');
			break;
			
			case 'categories':
			include('admin-includes/categories.php');
			break;
			
			case 'category':
			include('admin-includes/category.php');
			break;
			
			case 'orders':
			include('admin-includes/orders.php');
			break;
			
			case 'order':
			include('admin-includes/order.php');
			break;

            case 'company_details':
                include('admin-includes/company_details.php');
                break;

            case 'company_detail':
                include('admin-includes/company_detail.php');
                break;


            case 'pages':
                include('admin-includes/pages.php');
                break;

            case 'page':
                include('admin-includes/page.php');
                break;


            case 'contents':
                include('admin-includes/contents.php');
                break;

            case 'content':
                include('admin-includes/content.php');
                break;
			
			case 'error':
			include('admin-includes/error.php');
			break;
			
			case 'promos':
			include('admin-includes/promos.php');
			break;
			
			case 'cross-sell':
			include('admin-includes/cross-sell.php');
			break;
			
			case 'promo':
			include('admin-includes/promo.php');
			break;
			
			case 'blogs':
			include('admin-includes/blogs.php');
			break;
	
			case 'blog':
			include('admin-includes/blog.php');
			break;
			
			default:
			include('admin-includes/home.php');

		}
		
		?>		

</div>


<?php require __DIR__.'/footer.php'; ?>