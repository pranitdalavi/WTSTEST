<?php

$teamObj = new \App\Page();
if($action == 'edit'){

    $row = $teamObj->find($id);

}

if($action == 'delete-image'){

    $row = $teamObj->deleteImage($_GET['img']);

}

if( isset($_POST['name']) ){

    if($action == 'add'){

        $teamObj->add();

    } else {

        $teamObj->update($id);

    }

}

if(isset($_POST['file']) ){

    if($action == 'addimg'){

        $teamObj->addimg();

    } else {
        $teamObj->updateimg();

    }

}

?>
<script src="tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        plugins: "code, lists, advlist"
    });
</script>
<h1>Edit Page</h1>


<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">

    <div class="panel panel-default">
        <div class="panel-heading"><?= strtoupper($action) ?> PAGE</div>
        <div class="panel-body">


            <div class="form-group">
                <label class="col-md-4 control-label">Title</label>
                <div class="col-md-6">
                    <input type="text"  class="form-control" name="name" id="name" value="<?php if(isset($row)){ print $row->name; } ?>">
                </div>
            </div>
            <div class="form-group" style="display: none">
                <label class="col-md-4 control-label">position</label>
                <div class="col-md-6">
                    <input type="text"  class="form-control" name="position" id="position" value="<?php if(isset($row)){ print $row->position; } ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Description</label>
                <div class="col-md-6">
                    <textarea class="form-control" name="description" id="description"><?php if(isset($row)){ print $row->description; } ?></textarea>
                </div>
            </div>



            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> PAGE </button>
                </div>
            </div>

        </div>
    </div>

</form>

