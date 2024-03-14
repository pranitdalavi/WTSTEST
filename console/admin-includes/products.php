<?php

use App\Product;

$productObj = new Product;

if(isset($action)){

	$productObj->delete($id);

}


$query = $productObj->getAll();

if(isset($_GET['s'])){

	$query = $productObj->getAllSearchAdmin($_GET['s']);	

}



?>

<h1>PRODUCTS</h1>

<div class="row">

	<div class="col-md-6 col-xs-3"> <a class="btn btn-primary" href="account.php?page=product&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />  </div>
	<form action="" method="get">
	<input type="hidden" name="page" value="products">
	<div class="col-md-3 col-md-offset-2 col-xs-6">
	
		<input required type="text" name="s" class="form-control" placeholder="Search product title, product code, sku..." value="<?php if(isset($_GET['s'])){ print $_GET['s']; } ?>">
	
	</div>
	
	<div class="col-md-1 col-xs-1">  <button type="submit" class="btn btn-primary"><span class="hidden-xs">SEARCH </span><i class="fa fa-search"></i></button> </div>
	
	</form>

</div>



<?php

if( count($query) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Title</strong></td><td><strong>SEO Friendly URL</strong></td><td><strong>Category</strong></td><td width="270px"><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $query as $row ){
	
	$status = $row->product_status ? '' : 'OUT OF STOCK';
	
	$categories = '';
	$sub_categories = '';
	$category_json = json_decode($row->category_id);
	
	foreach($category_json as $category_id){
	
		$categories .= '['.$categoryObj->find($category_id)->title.']<br />';
	
	}


    if($row->service == 0){
        print '<tr><td>'.$row->product_title.'</td><td>/'.$row->product_seo_url.'</td><td>'.$categories.'</td><td><a class="btn btn-primary" href="account.php?page=product&action=edit&id='.$row->product_id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=cross-sell&id='.$row->product_id.'">Cross Sell</a> <a onclick="return confirm(\'Are you sure you want to delete this product?\')" class="btn btn-primary" href="account.php?page=products&action=delete&id='.$row->product_id.'">Delete</a></td></tr>';

    }else{
        print '<tr><td>'.$row->product_title.'</td><td>/'.$row->product_seo_url.'</td><td>'.$categories.'</td><td><a class="btn btn-primary" href="account.php?page=product&action=edit&id='.$row->product_id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=cross-sell&id='.$row->product_id.'">Cross Sell</a></td></tr>';

    }
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no ".$page." for that request. <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>