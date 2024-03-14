<?php

if(isset($_GET['action']) && $_GET['action'] == 'delete'){

	$user->delete($id);

}

?>

<h1>CUSTOMERS</h1>

<div class="table-responsive">

	<table class="table table-striped table-hover">
	
	<?php
	
	$i = 0;
	
	$memberArray = [];
	
	foreach( $user->getAll() as $row ){

	
	if(!in_array($memberType, $memberArray)){

	$memberArray[] = $memberType;
	
	print '<tr style="background:#D6D6D6"><td style="vertical-align: middle;width: 150px;">Registered At</td><td style="vertical-align: middle;width: 250px;min-width: 250px;">Full Name<td>Opt In</td style="vertical-align: middle"></td><td></td><td style="vertical-align: middle"></td></tr>';
	
	}
	
	print '<tr><td style="vertical-align: middle">'.date('d/m/Y H:i:s', strtotime($row->created_at)).'</td><td style="vertical-align: middle">'.$row->first_name.' '.$row->last_name.'</td><td style="vertical-align: middle">';

    foreach (explode(",",$row->contacts) as $contact){
        print $contact . "<br>";
    }

print '</td><td></td><td style="vertical-align: middle;width: 150px;"><a class="btn btn-primary" href="account.php?page=customer&action=edit&id='.$row->id.'">View <i class="fa fa-arrow-circle-right"></i></a> <a onclick="return confirm(\'Are you sure you want to delete this customer?\')" class="btn btn-danger" href="account.php?page=customers&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	
	$i++;
	
	}

	
	?>

	</table>

</div>