<?php

use App\Product;

$productObj = new Product;

$cross_sell_ids = $productObj->find($id)->cross_sell_ids;

if(isset($_POST['id'])){

	$productObj->updateCrossSells($id);

}

$query = $productObj->getAllCrossell();

if(isset($_GET['s'])){

	$query = $productObj->getAllSearchAdmin($_GET['s']);	

}

?>

<div class="row">

	<div class="col-md-6 col-xs-3"> <h1>CROSS SELL PRODUCTS FOR - <?= strtoupper($productObj->find($id)->title) ?></h1> <br /> <br />  </div>
	<form action="" method="get">
	<input type="hidden" name="page" value="cross-sell">
	<input type="hidden" name="id" value="<?= $id ?>">
	<div class="col-md-3 col-md-offset-2 col-xs-6">
	
		<input required type="text" name="s" class="form-control" placeholder="Search product title, product code, sku..." value="<?php if(isset($_GET['s'])){ print $_GET['s']; } ?>">
	
	</div>
	
	<div class="col-md-1 col-xs-1">  <button type="submit" class="btn btn-primary"><span class="hidden-xs">SEARCH </span><i class="fa fa-search"></i></button> </div>
	
	</form>

</div>

<?php

if( count($query) ){

?>

<form action="" method="post">
<input type="hidden" name="id" value="<?= $id ?>">
<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Title</strong></td><td><strong>SEO Friendly URL</strong></td><td><strong>Category</strong></td><td width="90px"><strong>Select</strong></td></tr>
	
	<?php
	
	foreach( $query as $row ){
	
	$checked = strstr($cross_sell_ids, '"'.$row->product_id.'"') ? 'checked' : '';
	
	print '<tr><td>'.$row->product_title.'</td><td><a target="_blank" style="color:#359DB6" href="'.DOMAIN.'/product/'.$row->product_seo_url.'">'.DOMAIN.'/product/'.$row->product_seo_url.'</a></td><td>'.$row->category_title.'</td><td><input '.$checked.' type="checkbox" name="ids[]" value="'.$row->product_id.'"></td></tr>';
	
	}
	
	?>
	
	<tr><td></td><td></td><td></td><td><button type="submit" class="btn btn-primary">SUBMIT</button></td></tr>

	</table>

</div>		

</form>

<?php

} else { print "<p>There are currently no ".$page.". <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }



?>

