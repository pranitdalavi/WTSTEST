<?php

$categoryObj = new App\Category;

if($action == 'edit'){

	$row = $categoryObj->find($id);

}

if( isset($_POST['title']) ){

	if($action == 'add'){

		$categoryObj->add();
	
	} else {
	
		$categoryObj->update($id);
	
	}

}

?>

<script>

$(function(){

	$.get('account.php?page=category&action=add&get=sessions', function(data){
		
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

<h1>CATEGORY</h1>


	<form class="form-horizontal" <?php if($action == 'add'){ print 'id="form"'; } ?> method="post" action="" enctype='multipart/form-data'>

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> CATEGORY</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" required class="form-control" name="title" id="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Description</label>
                                    <div class="col-md-6">
                                        <input type="text" required class="form-control" name="info" id="info" value="<?php if(isset($row)){ print $row->info; } ?>">
                                    </div>
                                </div>

                            <div class="form-group">
									<label class="col-md-4 control-label">Sort Order</label>
									<div class="col-md-6">
										<input type="text" required class="form-control" name="sort_order" id="sort_order" value="<?php if(isset($row)){ print $row->sort_order; } ?>">
									</div>
								</div>								
								
								<div class="form-group" style="display: none">
									<label class="col-md-4 control-label">SEO Friendly URL</label>
									<div class="col-md-6">
										<input type="text" required class="form-control" name="seo_url" id="seo_url" value="<?php if(isset($row)){ print $row->seo_url; } ?>">
									</div>
								</div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Image</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="image" id="image" value="">
                                        <?php
                                            if($action != "add"){ ?>
                                                <img src="<?= DOMAIN ?>/category-images/<?= $row->id ?>.jpg" style="width: 100%;max-width: 200px;margin-top: 10px;">

                                            <?php }
                                        ?>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">SEO</label>
                                    <div class="col-md-6">

                                        <textarea class="form-control" rows="10" name="seo_block" id="seo_block"><?php  if(isset($row)){ print $row->seo_block; } elseif(isset($_SESSION[SESSION.'seo_block'])){ print $_SESSION[SESSION.'seo_block']; } ?></textarea>

                                    </div>
                                </div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> CATEGORY </button>
									</div>
								</div>



						</div>
					</div>
		
		
	</form>		

