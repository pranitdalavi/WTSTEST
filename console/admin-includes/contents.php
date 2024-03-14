<?php

$teamObj = new App\Content();
if(isset($action)){

    $teamObj->delete($id);

}

?>

    <h1>Content</h1>
    <a class="btn btn-primary" href="account.php?page=content&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />
<?php

if( count($teamObj->getAll()) ){

    ?>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <tr><td><strong>Name</strong></td><td style="width: 125px !important;max-width: 125px !important;"><strong>Page</strong></td><td width="190px"><strong>Action</strong></td></tr>

            <?php

            foreach( $teamObj->getAll() as $row ){

                print '<tr><td>'.$row->name.'</td><td style="width: 125px !important;max-width: 125px !important;">'.$row->link2.'</td><td><a class="btn btn-primary" href="account.php?page=content&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a></td></tr>';

            }

            ?>

        </table>

    </div>

    <?php

} else { print "<p>There are currently no team members <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>