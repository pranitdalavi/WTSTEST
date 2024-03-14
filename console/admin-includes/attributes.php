<?php

$teamObj = new App\Attribute();

if(isset($_POST["category"])) {
    redirect(DOMAIN . "/console/account?page=attributes&category=" . $_POST["category"]);
}
if(isset($action)){

    $teamObj->delete($id);

}
$categories = $teamObj->getCategories();

?>

    <h1>Attributes</h1>
    <a class="btn btn-primary" href="account.php?page=attribute&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />


    <form action="" method="POST">
        <div class="row mb-20">
            <div class="col-md-2">
                <select class="form-control" name="category">
                    <option value="all">All</option>
                    <?php
                    foreach ($categories as $category){ ?>
                        <option <?php if($_GET["category"] == $category->category){ print "selected"; } ?>><?= $category->category ?></option>

                    <?php }
                    ?>
                </select>
            </div>
            <div class="col-md-2">

                <button class="btn btn-primary">Search</button>
            </div>
        </div>

    </form>
<?php

if( count($teamObj->getAllSearch($_GET["category"])) ){

    ?>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <tr><td><strong>Name</strong></td><td><strong>Group</strong></td><td><strong>Category</strong></td><td><strong>Price</strong></td><td><strong>Order</strong></td><td width="190px"><strong>Action</strong></td></tr>

            <?php

            foreach( $teamObj->getAllSearch($_GET["category"]) as $row ){

                print '<tr><td>'.$row->name.'</td><td>'.$row->attribute.'</td><td>'.$row->category.'</td><td>£'.$row->price.'</td><td>'.$row->order_num.'</td><td><a class="btn btn-primary" href="account.php?page=attribute&action=edit&id='.$row->id.'&category='. $_GET["category"] .'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=attributes&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';

            }

            ?>

        </table>

    </div>

    <?php

} else { print "<p>There are currently no attributes <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>