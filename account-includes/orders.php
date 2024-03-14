<?php
if( count(get_included_files()) == 1 ){
	header('Location: /');
	exit();
}
?>

<?php

$_GET['status'] = "All";

?>

<div class="panel panel-default mb-30">
<div class="panel-heading"><a href="account?page=home"><i class="fa fa-home"></i> ACCOUNT HOME</a> | MY ORDERS</div>
	<div class="panel-body">

<br />

        <style>
            table tr td, table tr th{
                font-size: 15px;
            }
            table .btn-default{
                border-radius: 15px;
            }
            .table-responsive tr:first-child td:nth-child(5){
                width: 30px !important;
            }
        </style>
<?php

include('console/admin-includes/orders.php');

?>

<br /><br />

</div>
</div>