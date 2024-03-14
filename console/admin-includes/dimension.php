<?php

$blogObj = new App\Dimension();
$blogimageObj = new App\DimensionImage();

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

<h1>Dimensions</h1>

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
            <div class="form-group" style="display:none; " >
                <label class="col-md-4 control-label">Product</label>
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
                    $productObj = new \App\Product();
                    ?>


                    <select class="form-control" name="product" id="product" onchange="openOther(this)" >
                        <option value="" selected disabled>Please select</option>
                        <?php foreach ($productObj->getAll() as $item){ ?>
                            <option <?php if(isset($row) and $item->product_id == $row->product){ print "selected";} ?> value="<?= $item->product_id ?>"><?= $item->product_title ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-md-4 control-label">Category</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="category" id="category2" value="<?php if(isset($row)){ print $row->category; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Title/Value</label>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="title1" value="<?php if(isset($row)){ print $row->title1; } ?>">
                </div>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="value1" value="<?php if(isset($row)){ print $row->value1; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Title/Value</label>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="title2" value="<?php if(isset($row)){ print $row->title2; } ?>">
                </div>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="value2" value="<?php if(isset($row)){ print $row->value2; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Title/Value</label>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="title3" value="<?php if(isset($row)){ print $row->title3; } ?>">
                </div>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="value3" value="<?php if(isset($row)){ print $row->value3; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Title/Value</label>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="title4" value="<?php if(isset($row)){ print $row->title4; } ?>">
                </div>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="value4" value="<?php if(isset($row)){ print $row->value4; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Title/Value</label>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="title5" value="<?php if(isset($row)){ print $row->title5; } ?>">
                </div>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="value5" value="<?php if(isset($row)){ print $row->value5; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Title/Value</label>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="title6" value="<?php if(isset($row)){ print $row->title6; } ?>">
                </div>
                <div class="col-md-3 mb-10">
                    <input type="text" class="form-control" name="value6" value="<?php if(isset($row)){ print $row->value6; } ?>">
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

                            print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=dimension&action=delete-image&image_id=".$blog_images[$i-1]->id."'><img style='width:150px' src='../dimension-images/".$blog_images[$i-1]->id.".".$blog_images[$i-1]->ext."'></a>";

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

