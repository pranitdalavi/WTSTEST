<?php

$teamObj = new \App\Content();
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

<h1>Add Content</h1>

<p>Once uploaded, to delete an image, just click it.</p>
<script src="tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        plugins: "code, lists, advlist"
    });
</script>
<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">

    <div class="panel panel-default">
        <div class="panel-heading"><?= strtoupper($action) ?> CONTENT</div>
        <div class="panel-body">


            <div class="form-group">
                <label class="col-md-4 control-label">Title</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($row)){ print $row->name; } ?>">
                </div>
            </div>



            <?php
            if($row->id != 4 and $row->id != 5 and $row->id != 7){ ?>
                <div class="form-group">
                    <label class="col-md-4 control-label">Description</label>
                    <div class="col-md-6">
                        <textarea type="text" class="form-control" name="description" id="description"><?php if(isset($row)){ print $row->description; } ?></textarea>
                    </div>
                </div>

            <?php } ?>
            <?php
            if($row->id == 4 or $row->id == 5){ ?>
                <div class="form-group">
                    <label class="col-md-4 control-label">Link To</label>
                    <div class="col-md-6">

                        <input class="form-control" rows="1" name="link1" id="link1" placeholder="Link..." value="<?php if(isset($row)){ print $row->link1; } ?>">

                    </div>
                </div>

            <?php } ?>





            <div class="form-group" style="display: none">
                <label class="col-md-4 control-label">Position</label>
                <div class="col-md-6">

                    <input class="form-control" rows="1" name="position" id="position" placeholder="Position" value="<?php if(isset($row)){ print $row->position; } ?>">

                </div>
            </div>


            <div class="form-group" style="display: none">
                <label class="col-md-4 control-label">Email</label>
                <div class="col-md-6">

                    <textarea class="form-control" rows="1" name="link2" id="link2"><?php if(isset($row)){ print $row->link2; } ?></textarea>

                </div>
            </div>


            <div class="form-group" style="display: none">
                <label class="col-md-4 control-label">Phone</label>
                <div class="col-md-6">

                    <textarea class="form-control" rows="1" name="link3" id="link3"><?php if(isset($row)){ print $row->link3; } ?></textarea>

                </div>
            </div>
            <?php
            if($row->id != 1 and $row->id != 2 and $row->id != 3){ ?>
                <?php for($i = 1; $i < 2; $i++){ ?>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Image <?= $i; ?> (JPG, PNG or GIF)</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="file-<?= $i; ?>">

                            <?php

                            if(isset($id) && file_exists('../content-images/'.$id.'.png')){

                                print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=content&action=delete-image&id=".$id."&img=".$id.".png'><img class='img-responsive-admin' src='../content-images/".$id.".png'></a>";

                            } else

                                if(isset($id) && file_exists('../content-images/'.$id.'.jpg')){
                                    print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=content&action=delete-image&id=".$id."&id=".$id."&img=".$id.".jpg'><img class='img-responsive-admin' src='../content-images/".$id.".jpg'></a>";

                                } else

                                    if(isset($id) && file_exists('../content-images/'.$id.'.gif')){

                                        print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=content&action=delete-image&id=".$id."&id=".$id."&img=".$id.".gif'><img class='img-responsive-admin' src='../content-images/".$id.".gif'></a>";

                                    }

                            ?>

                        </div>
                    </div>

                <?php } ?>
            <?php } ?>



            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> CONTENT </button>
                </div>
            </div>

        </div>
    </div>


</form>

