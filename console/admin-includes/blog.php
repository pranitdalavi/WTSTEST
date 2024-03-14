<?php

$blogObj = new App\Blog;
$blogimageObj = new App\BlogImage;

if($action == 'delete-image'){

	$blogimageObj->delete($_GET['image_id']);

}

if($action == 'edit'){

	$row = $blogObj->find($id);
	$blog_images = $blogimageObj->getAll();

}

if( isset($_POST['title']) ){

	if($action == 'add'){
	
		$blogObj->add();
	
	} else {
	
		$blogObj->update($id);
	
	}

}

?>

<script>

$(function(){

	$.get('account.php?page=blog&action=add&get=sessions', function(data){
		
		var data = jQuery.parseJSON(data);
		
		$('#form input[type=text], #form input[type=email], #form textarea').each(function(){
			
			if (typeof data[this.id] !== 'undefined') {
			
				$('#' + this.id).val(data[this.id]);
				
			}
		
		});
		
		$('#form select').each(function(){
		
			$('#' + this.id + ' option[value='+data[this.id]+']').prop('selected', true);
		
		});

	});

});

</script>
<script src="tinymce/js/tinymce/tinymce.min.js"></script>
<script>

tinymce.init({
  selector: "textarea",
  plugins: "code, lists, advlist"
});

</script>

<h1>BLOG</h1>

<p>Once uploaded, to delete the image, just click it.</p>

	<form enctype="multipart/form-data" class="form-horizontal" <?php if($action == 'add'){ print 'id="form"'; } ?> method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> BLOG</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title" id="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Blog URL</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="seo_url" id="seo_url" value="<?php if(isset($row)){ print $row->seo_url; } ?>">
										<br />
										eg. my-blog-title
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Blog Content</label>
									<div class="col-md-6">
										<textarea class="form-control" rows="20" name="content" id="content"><?php if(isset($_SESSION[SESSION.'content'])){ print $_SESSION[SESSION.'content']; } else if(isset($row)){ print $row->content; } ?></textarea>
									</div>
								</div>
								
								<?php for($i = 1; $i < 2; $i++){ ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Alt Tag</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="alt-<?= $i; ?>" name="alt-<?= $i; ?>" value="<?php if(isset($blog_images[$i-1]->alt)){ print $blog_images[$i-1]->alt; } ?>">										
									</div>
								</div>
								
								<?php if(isset( $blog_images[$i-1]->id )){ ?>
								
								<input type="hidden" name="id-<?= $i; ?>" value="<?= $blog_images[$i-1]->id ?>">
								<input type="hidden" name="ext-<?= $i; ?>" value="<?= $blog_images[$i-1]->ext ?>">
								
								<?php } ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image (JPG, PNG or GIF)</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="file-<?= $i; ?>">
										
										<?php
										
										if(isset($blog_images[$i-1]->ext)){
										
	print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=blog&action=delete-image&image_id=".$blog_images[$i-1]->id."'><img style='width:150px' src='../blog-images/".$blog_images[$i-1]->id.".".$blog_images[$i-1]->ext."'></a>";
										
										}
										
										?>
										
									</div>
								</div>
								
								<?php } ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> BLOG </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

