<?php

use App\Category;

$categoryObj = new Category;

if(isset($action)){

	$categoryObj->delete($id);

}

?>

<h1>CATEGORIES</h1>


<?php

if( count($categoryObj->getAll()) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Title</strong></td><td><strong>SEO Friendly URL</strong></td><td><strong>Sort Order</strong></td><td><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $categoryObj->getAll() as $row ){
	
	print '<tr><td>'.$row->title.'</td><td>/'.$row->seo_url.'</td><td>'.$row->sort_order.'</td><td><a class="btn btn-primary" href="account.php?page=category&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a></td></tr>';
	
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no ".$page.". <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>