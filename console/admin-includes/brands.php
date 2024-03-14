<?php

$teamObj = new App\Brand();
if(isset($action)){

    $teamObj->delete($id);

}

?>

    <h1>Brands</h1>
    <a class="btn btn-primary" href="account.php?page=brand&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />


<?php

if( count($teamObj->getAll()) ){

    ?>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <tr><td><strong>Brand Name</strong></td><td width="190px"><strong>Action</strong></td></tr>

            <?php

            foreach( $teamObj->getAll() as $row ){

                print '<tr><td>'.$row->name.'</td><td><a class="btn btn-primary" href="account.php?page=brand&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=brands&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';

            }

            ?>

        </table>

    </div>

    <?php

} else { print "<p>There are currently no brands <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>