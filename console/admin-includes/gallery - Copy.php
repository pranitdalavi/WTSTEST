<?php

use App\Helpers\Tools;

$galleryimageObj = new App\GalleryImage;

if($action == 'delete-image'){

	$galleryimageObj->delete($_GET['image_id']);

}

if( isset($_POST['post']) ){

	Tools::validateImages();
	Tools::updateImages( $id = null, 'gallery-images', $galleryimageObj );
	redirect( 'account.php?page=gallery&action=add', 'The image has been uploaded' );

}

?>

<h1>GALLERY IMAGES</h1>

<p>Once uploaded, to delete an image, just click it. Best image size 800px X 800px (square)</p>

	<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">
	<input type="hidden" name="post">
						<div class="panel panel-default">
						<div class="panel-heading">GALLERY IMAGES</div>
						<div class="panel-body">

								
								<?php
								
								$i = 1;
								
								foreach( $galleryimageObj->getAll() as $gallery_image ){
								
								?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="alt-<?= $i; ?>" name="alt-<?= $i; ?>" value="<?php if(isset($gallery_image->alt)){ print $gallery_image->alt; } ?>">										
									</div>
								</div>
								
								<input type="hidden" name="id-<?= $i ?>" value="<?= $gallery_image->id ?>">
								<input type="hidden" name="ext-<?= $i ?>" value="<?= $gallery_image->ext ?>">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image (JPG, PNG or GIF)</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="file-<?= $i; ?>">
										
<?php print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=gallery&action=delete-image&image_id=".$gallery_image->id."'><img style='height:50px' src='../gallery-images/".$gallery_image->id.".".$gallery_image->ext."'></a>";  ?>
										
									</div>
								</div>
								
								<?php $i++; } ?>
								
								
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="alt-<?= $i ?>" name="alt-<?= $i ?>">										
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image (JPG, PNG or GIF)</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="file-<?= $i ?>">
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> UPLOAD </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

