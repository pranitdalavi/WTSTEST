<?php

$teamObj = new \App\Brand();
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

<h1>Add an Brand</h1>


<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">

    <div class="panel panel-default">
        <div class="panel-heading"><?= strtoupper($action) ?> Brand</div>
        <div class="panel-body">


            <div class="form-group">
                <label class="col-md-4 control-label">Brand</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($row)){ print $row->name; } ?>">
                </div>
            </div>

            <div class="form-group" style="display: none">
                <label class="col-md-4 control-label">Value</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="description" id="description" value="<?php if(isset($row)){ print $row->description; } ?>">
                </div>
            </div>

            <div class="form-group" style="display: none">
                <label class="col-md-4 control-label">position</label>
                <div class="col-md-6">
                    <input type="text"  class="form-control" name="position" id="position" value="<?php if(isset($row)){ print $row->position; } ?>">
                </div>
            </div>



            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> BRAND </button>
                </div>
            </div>

        </div>
    </div>


</form>

