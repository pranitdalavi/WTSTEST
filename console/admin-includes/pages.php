<?php

$teamObj = new App\Page();
if(isset($action)){

    $teamObj->delete($id);

}

?>

    <h1>Pages</h1>



<?php

if( count($teamObj->getAll()) ){

    ?>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <tr><td><strong>Title</strong></td><td width="190px"><strong>Action</strong></td></tr>

            <?php

            foreach( $teamObj->getAll() as $row ){

                print '<tr><td>'.$row->name.'</td><td><a class="btn btn-primary" href="account.php?page=page&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a> </td></tr>';

            }

            ?>

        </table>

    </div>

    <?php

} else { print "<p>There are currently no pages <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>