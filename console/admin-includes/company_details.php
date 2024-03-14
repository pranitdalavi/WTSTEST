<?php

$teamObj = new App\Companydetails();
if(isset($action)){

    $teamObj->delete($id);

}

?>

    <h1>Company Details</h1>


<?php

if( count($teamObj->getAll()) ){

    ?>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <tr><td><strong>Title</strong></td><td><strong>Value</strong></td><td width="190px"><strong>Action</strong></td></tr>

            <?php

            foreach( $teamObj->getAll() as $row ){

                print '<tr><td>'.$row->name.'</td><td>'.$row->description.'</td><td><a class="btn btn-primary" href="account.php?page=company_detail&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a></td></tr>';

            }

            ?>

        </table>

    </div>

    <?php

} else { print "<p>There are currently no company details <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>