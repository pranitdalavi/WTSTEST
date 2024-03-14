<?php

namespace App;

class PromoCode extends ObjectModel
{

    protected $table = 'promo_codes';
    protected $fillable = ['code', 'percentage', 'value'];
    protected $uniqueID;
    protected $user;


    public function __construct()
    {

	$this->user = new User;

	if($this->user->uniqueId()){
	
		$this->uniqueID = $this->user->uniqueId();
	
	}

    }


    public function getAll()
    {
	return $this->execute("SELECT * FROM promo_codes WHERE promo_codes.deleted_at IS NULL ", [] );		
    }


    public function add()
    {
	
	parent::add();

	return redirect('account.php?page=promos', 'The promo code has been added');

    }
		
		
    public function delete($id)
    {

	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	
	return redirect('account.php?page=promos', 'The promo code has been deleted');

    }


    public function update($id, $whereValues = null)
    {

	parent::update('id = :id', ['id' => $id]);

	return redirect('account.php?page=promos', 'The promo code has been updated');

    }
		
		
    public function checkPromoCode()
    {

	$row = $this->getRowByFieldNotDeleted('code', $_POST['code']);
	
	if( isset($row->id) ){
		
		setcookie(SESSION.'promo_code', $row->id, time()+604800, '/');
		$_SESSION[SESSION.'promo_code'] = $row->id;
		
		return redirect( 'cart.php', 'The promotional code has been accepted' );
	
	}
	
	else {
	
		setcookie(SESSION.'promo_code', '', time()-3600, '/');
		unset($_SESSION[SESSION.'promo_code']);
		
		return redirect( 'cart.php', 'The promotional code was incorrect', 'e' );
	
	}


    }
    
    public function getPromoCodeAmount()
    {

	if($this->getPromoCodeId()){
	
		if($this->find($this->getPromoCodeId())->value){
		
			return $this->find($this->getPromoCodeId())->value;
		
		} else {
		
			return $this->find($this->getPromoCodeId())->percentage;
		
		}
	
	}
	
	return null;

    }
    
    /*
    
    public function getPromoCodePercentage()
    {

	if(isset($_SESSION[SESSION.'promo_code']) && is_numeric($_SESSION[SESSION.'promo_code']) && $_SESSION[SESSION.'promo_code'] > 0 ){
	
		return $this->find($_SESSION[SESSION.'promo_code'])->percentage;
	
	}
	
	if(isset($_COOKIE[SESSION.'promo_code']) && is_numeric($_COOKIE[SESSION.'promo_code']) && $_COOKIE[SESSION.'promo_code'] > 0 ){

		return $this->find($_COOKIE[SESSION.'promo_code'])->percentage; 
	
	}
	
	return null;

    }
    
    */
    
    
    public function getPromoCodeId()
    {

	if(isset($_SESSION[SESSION.'promo_code']) && is_numeric($_SESSION[SESSION.'promo_code']) && $_SESSION[SESSION.'promo_code'] > 0 ){
	
		return $this->find($_SESSION[SESSION.'promo_code'])->id;
	
	}
	
	if(isset($_COOKIE[SESSION.'promo_code']) && is_numeric($_COOKIE[SESSION.'promo_code']) && $_COOKIE[SESSION.'promo_code'] > 0 ){

		return $this->find($_COOKIE[SESSION.'promo_code'])->id; 
	
	}
	
	return null;

    }
    
    public function getPromoType()
    {

	if($this->getPromoCodeId()){
	
		if($this->find($this->getPromoCodeId())->percentage){
		
			return 'percentage';
		
		} else {
		
			return 'value';
		
		}
	
	}
	
	return false;

    }


}












