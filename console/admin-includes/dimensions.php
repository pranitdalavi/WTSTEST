<?php

$teamObj = new App\Dimension();

if(isset($action)){

    $teamObj->delete($id);

}
?>

    <h1>Dimensions</h1>
    <a class="btn btn-primary" href="account.php?page=dimension&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />


<?php

if( count($teamObj->getAll()) ){

    ?>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <tr><td style="width: 350px;"><strong>Name</strong></td><td><strong>Group</strong></td><td><strong>Category</strong></td><td width="190px"><strong>Action</strong></td></tr>

            <?php

            foreach( $teamObj->getAll() as $row ){

                print '<tr><td>'.$row->name.'</td><td>'.$row->attribute.'</td><td>'.$row->category.'</td><td><a class="btn btn-primary" href="account.php?page=dimension&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=dimensions&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';

            }

            ?>

        </table>

    </div>

    <?php

} else { print "<p>There are currently no dimensions <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>