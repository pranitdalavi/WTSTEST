<?php

$blogObj = new App\Attribute();
$blogimageObj = new App\AttributeImage();

if($action == 'delete-image'){

    $blogimageObj->delete($_GET['image_id']);

}


if($action == 'edit'){

    $row = $blogObj->find($id);
    $blog_images = $blogimageObj->getAll();

}

if( isset($_POST['name']) ){

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

<h1>Attribute</h1>

<p>Once uploaded, to delete the image, just click it.</p>

<form enctype="multipart/form-data" class="form-horizontal" <?php if($action == 'add'){ print 'id="form"'; } ?> method="post" action="">

    <div class="panel panel-default">
        <div class="panel-heading"><?= strtoupper($action) ?> Attribute</div>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-md-4 control-label">Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($row)){ print $row->name; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Group</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="attribute" id="attribute" value="<?php if(isset($row)){ print $row->attribute; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Category</label>
                <div class="col-md-6">
                    <script>
                        function openOther(that){
                            if($(that).val() == "other"){
                                $(that).attr("name","");
                                $("#category2").attr("name","category");
                                $("#a").show();

                            }
                        }
                    </script>
                    <?php
                    $categoryObj = new \App\Category();
                    ?>
                    <select class="form-control" name="category" id="category" onchange="openOther(this)">
                        <?php foreach ($categoryObj->getAll() as $item){ ?>
                            <option <?php if(isset($row) and $item->title == $row->category){ print "selected";} ?> value="<?= $item->title ?>"><?= $item->title ?></option>
                            <?php } ?>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group" id="a" style="display: none">
                <label class="col-md-4 control-label">Other</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="" id="category2" value="<?php if(isset($row)){ print $row->category; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Price</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="price" id="price" value="<?php if(isset($row)){ print $row->price; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Order</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="order_num" id="order_num" value="<?php if(isset($row)){ print $row->order_num; } ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Storage Limit</label>
                <div class="col-md-6">
                    <select class="form-control" name="storage_limit" id="storage_limit" >

                            <option <?php if(isset($row) and $row->storage_limit == "all"){ print "selected";} ?> value="all">All</option>
                            <option <?php if(isset($row) and $row->storage_limit == "limiter"){ print "selected";} ?> value="limiter">Limiter</option>
                            <option <?php if(isset($row) and $row->storage_limit == "limited"){ print "selected";} ?> value="limited">Limited</option>

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">
                    Trigger Code <span class="badge bg-primary" style="background: #722282;color:white;">new</span>
                </label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="show_mattress" id="show_mattress" value="<?php if(isset($row)){ print $row->show_mattress; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">
                    Target Code <span class="badge bg-primary" style="background: #722282;color:white;">new</span>
                </label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="trigger_mattress" id="trigger_mattress" value="<?php if(isset($row)){ print $row->trigger_mattress; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Material Group</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="material_group" id="material_group" value="<?php if(isset($row)){ print $row->material_group; } ?>">
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

                            print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=attribute&action=delete-image&image_id=".$blog_images[$i-1]->id."'><img style='width:150px' src='../attribute-images/".$blog_images[$i-1]->id.".".$blog_images[$i-1]->ext."'></a>";

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

