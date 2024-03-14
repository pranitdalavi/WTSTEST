<?php

use App\SubCategory;
use App\Category;

$subCategoryObj = new SubCategory;
$categoryObj = new Category;

if ($action == 'edit') {

	$row = $subCategoryObj->find($id);

}

if (isset($_POST['title'])) {

	if ($action == 'add') {

		$subCategoryObj->add();

	} else {

		$subCategoryObj->update($id);

	}

}

?>

<script>

$(function(){

	$.get('account.php?page=sub-category&action=add&get=sessions', function(data){
		
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

<h1>SUB CATEGORY</h1>

    <form class="form-horizontal" <?php if($action == 'add'){ print 'id="form"'; } ?> method="post" action="">

                        <div class="panel panel-default">
                        <div class="panel-heading"><?=strtoupper($action)?> SUB CATEGORY</div>
                        <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Title</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="title" name="title" value="<?php if (isset($row)) {print $row->title;}?>">
                                    </div>
                                </div>

			<div class="form-group">
				<label class="col-md-4 control-label">SEO Friendly URL</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="seo_url" id="seo_url" value="<?php if(isset($row)){ print $row->seo_url; } ?>">
				</div>
			</div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Category</label>
                                    <div class="col-md-6">

                                        <select class="form-control" name="category_id">
                                        <?php

					foreach ($categoryObj->getAll() as $category) {

						$selected = isset($row) && $category->id == $row->category_id ? 'selected' : '';

						print "<option value='" . $category->id . "' $selected>" . $category->title . "</option>";

					}

				?>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary"> <?=strtoupper($action)?> SUB CATEGORY </button>
                                    </div>
                                </div>

                        </div>
                    </div>


    </form>

