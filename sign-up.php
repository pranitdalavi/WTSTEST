<?php
require __DIR__.'/includes/config.php';


$userObj = new \App\User();
$meta_title = COMPANY_NAME.' | Sign Up';


if(isset($_POST["password"])){

    $newEmail = $_POST['email'];


    $userObj->add();
    return redirect('login?new-account-registered=true&email='.$newEmail);

    // return redirect(DOMAIN . "/login");
}
include('header.php');
?>
<style>
    label{
        font-size: 15px !important;
    }
</style>
    <style>
        .page-block * {
            font-size: 15px;
        }
    </style>
<form id="form" action="" method="post" class="page-block">

    <?php if( count( App\Helpers\Validation::errors() ) ){   ?>

        <div class="container mt-10">


            <?php require __DIR__.'/includes/flash-messages.php'; ?>

        </div>

    <?php } ?>

    <div class="container pt-30 pb-50">

        <div class="panel panel-default">
            <div class="panel-heading">Create an Account</div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-6 col-md-6">
                        <div class="form-group">
                            <label for="email">* Email Address</label>
                            <input type="text" class="form-control" name="email" id="email" value="">
                        </div>
                    </div>


                        <div class="col-md-6 col-md-6">
                            <div class="form-group">
                                <label for="email">* Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>


                </div>



                <div class="row">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="first_name">* First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="last_name">* Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="">
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="">
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="address_1">* Address 1</label>
                            <input type="text" class="form-control" name="address_1" id="address_1" value="<?php if(isset($user->auth()->address_1)){ print ucwords($user->auth()->address_1); } ?>">
                        </div>
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="address_2">Address 2</label>
                            <input type="text" class="form-control" name="address_2" id="address_2" value="<?php if(isset($user->auth()->address_2)){ print ucwords($user->auth()->address_2); } ?>">
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="town">* Town</label>
                            <input type="text" class="form-control" name="town" id="town" value="<?php if(isset($user->auth()->town)){ print ucwords($user->auth()->town); } ?>">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="postcode">* Postcode</label>
                            <input type="text" class="form-control" name="postcode" id="postcode" value="<?php if(isset($user->auth()->postcode)){ print strtoupper($user->auth()->postcode); } ?>">
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="<?php if(isset($user->auth()->country)){ print strtoupper($user->auth()->country); } ?>">
                        </div>
                    </div>


                </div>

                <button type="submit" class="btn btn-default submit-button " style="border-radius: 15px;">CREATE ACCOUNT <i class="fa fa-chevron-right"></i> </button>
            </div>
        </div>


    </div>


</form>

<?php
include('footer.php');

?>
