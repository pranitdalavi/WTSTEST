<?php

use App\SubCategory;

$subCategoryObj = new SubCategory;

if(isset($action)){

	$subCategoryObj->delete($id);

}

?>

<h1>SUB CATEGORIES</h1>

<a class="btn btn-primary" href="account.php?page=sub-category&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />

<?php

if( count($subCategoryObj->getAll()) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Category</strong></td><td><strong>Sub Category</strong></td><td><strong>SEO Friendly URL</strong></td><td width="200px"><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $subCategoryObj->getAll() as $row ){
	
	print '<tr><td>'.$row->title.'</td><td>'.$row->sub_category_title.'</td><td>/'.$row->seo_url.'/'.$row->sub_category_seo_url.'</td><td><a class="btn btn-primary" href="account.php?page=sub-category&action=edit&id='.$row->sub_category_id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=sub-categories&action=delete&id='.$row->sub_category_id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no ".$page.". <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>