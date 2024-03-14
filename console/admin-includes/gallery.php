<?php

use App\Helpers\Tools;
use App\GalleryImage;

$galleryimageObj = new GalleryImage;

if($action == 'delete-image'){

	$galleryimageObj->delete($_GET['image_id']);

}

if( isset($_POST['post']) ){

	Tools::validateImages();
	Tools::updateImages( $id = null, 'gallery-images', $galleryimageObj );
	redirect( 'account.php?page=gallery&action=add', 'The image has been uploaded' );

}

?>

<h1>BANNER IMAGES</h1>

<p>Once uploaded, to delete an image, just click it. Best image size 1920px X 674px. File types allowed -  JPG, GIF or PNG</p>

	<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">
	<input type="hidden" name="post">
						<div class="panel panel-default">
						<div class="panel-heading">BANNER IMAGES</div>
						<div class="panel-body">

								
								<?php
								
								$i = 1;
								
								foreach( $galleryimageObj->getAll() as $gallery_image ){
								
								?>
								
								<div class="form-group">

									<div class="col-md-3 mb-15">
										
									<input placeholder="Link URL..." type="text" class="form-control" id="alt-<?= $i; ?>" name="alt-<?= $i; ?>" value="<?php if(isset($gallery_image->alt)){ print $gallery_image->alt; } ?>">										
									
									</div>
                                    <div class="col-md-3 mb-15">

                                        <input placeholder="First line..." type="text" class="form-control" id="line1-<?= $i ?>" name="line1-<?= $i ?>" value="<?php if(isset($gallery_image->line1)){ print $gallery_image->line1; } ?>">

                                    </div>
                                    <div class="col-md-3 mb-15">

                                        <input placeholder="Second line..." type="text" class="form-control" id="line2-<?= $i ?>" name="line2-<?= $i ?>" value="<?php if(isset($gallery_image->line2)){ print $gallery_image->line2; } ?>">

                                    </div>
                                    <div class="col-md-3 mb-15">

                                        <input placeholder="Button text..." type="text" class="form-control" id="btntext-<?= $i ?>" name="btntext-<?= $i ?>" value="<?php if(isset($gallery_image->btntext)){ print $gallery_image->btntext; } ?>">

                                    </div>
									
								<input type="hidden" name="id-<?= $i ?>" value="<?= $gallery_image->id ?>">
								<input type="hidden" name="ext-<?= $i ?>" value="<?= $gallery_image->ext ?>">
									
									<div class="col-md-3 mb-15">
									
									<input type="file" class="form-control" name="file-<?= $i; ?>">
									
									</div>
									
									<div class="col-md-4">
									
<?php print "<a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=gallery&action=delete-image&image_id=".$gallery_image->id."'><img style='height:50px' src='../gallery-images/".$gallery_image->id.".".$gallery_image->ext."'></a>";  ?>
									
									</div>
									
								</div>
                                    <hr style="margin-bottom: 40px;margin-top: 30px;">


								
								
								<?php $i++; } ?>
								
								
								<div class="form-group">
								
									<div class="col-md-3 mb-15">
									
									<input placeholder="Link URL..." type="text" class="form-control" id="alt-<?= $i ?>" name="alt-<?= $i ?>">
										
									</div>
                                    <div class="col-md-3 mb-15">

                                        <input placeholder="First line..." type="text" class="form-control" id="line1-<?= $i ?>" name="line1-<?= $i ?>">

                                    </div>
                                    <div class="col-md-3 mb-15">

                                        <input placeholder="Second line..." type="text" class="form-control" id="line2-<?= $i ?>" name="line2-<?= $i ?>">

                                    </div>
                                    <div class="col-md-3 mb-15">

                                        <input placeholder="Button text..." type="text" class="form-control" id="btntext-<?= $i ?>" name="btntext-<?= $i ?>">

                                    </div>
									<div class="col-md-3 mb-15">
									
									<input type="file" class="form-control" name="file-<?= $i; ?>">
									
									</div>
									
								</div>
								
								<br /><br />
								
								<div class="form-group">
									<div class="col-md-6 col-md-offset-2">
										<button type="submit" class="btn btn-primary pull-right"> UPLOAD </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

