<?php

use App\Blog;

$blogObj = new Blog;

if(isset($action)){

	$blogObj->delete($id);

}

?>

<h1>BLOG POSTS</h1>

<a class="btn btn-primary" href="account.php?page=blog&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />

<?php

if( count($blogObj->getAll()) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Date Added</strong></td><td><strong>Title</strong></td><td><strong>Blog URL</strong></td><td><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $blogObj->getAll() as $row ){
	
	print '<tr><td>'.date('d.m.Y', strtotime($row->created_at)).'</td><td>'.$row->title.'</td><td>/blog/'.$row->seo_url.'</td><td><a class="btn btn-primary" href="account.php?page=blog&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a> <a onclick="return confirm(\'Are you sure you want to delete this post? \')" class="btn btn-primary" href="account.php?page=blogs&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no ".$page.". <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>