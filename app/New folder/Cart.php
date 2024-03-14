<?php

namespace App;

use App\Helpers\Tools;

class Cart extends ObjectModel
{

    protected $table = 'cart';
    protected $fillable = ['product_id', 'quantity', 'cart_price', 'unique_id', 'discount', 'options'];
    protected $uniqueID;
    protected $user;
    protected $product_id;
    protected $quantity;
    protected $cart_price;

    public function __construct()
    {
		
	$this->user = new User;
	$this->promo_code = new PromoCode;

	if($this->user->uniqueId()){
	
		$this->uniqueID = $this->user->uniqueId();
	
	}

	
    }	

	
    public function getAll()
    {
		
	return $this->execute("SELECT *, cart.id AS cart_id FROM cart 
					LEFT JOIN products ON products.id = cart.product_id 
					WHERE cart.unique_id = ? AND cart.quantity > '0' AND cart.deleted_at IS NULL ", [$this->uniqueID] );
		
    }
    
    
    public function shippingFromProducts()
    {
	
	$shipping = 0;

	foreach($this->getAll() as $row){
	
		$shipping += $row->delivery * $row->quantity;
	
	}
	
	return $shipping;

    }


    public function countItems()
    {

	$total = 0;

	foreach($this->getAll() as $row){
	
		$total += $row->quantity;
	
	}
	
	return $total;

    }
    

    public function subTotal()
    {

	$subTotal = 0;

	foreach($this->getAll() as $row){
	
		$subTotal += ( $row->quantity * $row->cart_price );
	
	}
	
	return $subTotal;
		
    }


    public function total()
    {
   
	if($this->discountedPrice()){
	
		return $this->discountedPrice() + $this->shipping();
	
	}
	
	return $this->subTotal() + $this->shipping();
    
	
    }
		
		
    public function vat()
    {
		
	if( ( $this->user->auth() && $this->user->auth()->member_type == 1 ) || !$this->user->auth() ){
	
		return 1.2;
	
	}
	
	return 1;
		
    }
    
    

		
    public function shipping()
    {
		
	if(isset($_SESSION[SESSION.'shipping']) && $_SESSION[SESSION.'shipping'] != ''){
	
		return $_SESSION[SESSION.'shipping'];
	
	}

	return '4.95';

    }
    

		
    public function setShipping($amount, $redirect = true)
    {
    
	if( $amount == '' ){
	
		$_SESSION[SESSION.'shipping'] = '3.95';
	
	}
		
	$_SESSION[SESSION.'shipping'] = $amount;
	
	if( $redirect ){
	
		return redirect('cart.php', 'Your shipping option has been changed');
	
	}
		
    }
    
    
    public function add($price = null)
    {
    
	/*
		
	if( isset($_POST['option_title']) ){
	
	$options = '';
	
		for( $i = 0; $i < count($_POST['option_title']); $i++ ){
		
			$options .= $_POST['option_title'][$i].': '.$_POST['option_values'][$i].' <br /> ';
		
		}
	
	}
	
	*/
	
	$this->cart_price = $price;
	//$this->options = $options;
	$this->unique_id = $this->uniqueID;
	
	parent::add();

	return redirect($_SERVER['REQUEST_URI'], 'The product has been added to your cart');
		
    }
		
		
    public function cartReOrder()
    {
		
	$order_id = $_POST['order_id'];
	
	$query = $this->execute("SELECT * FROM products_from_order WHERE products_from_order.order_id = ?  ", [$order_id] );
	
	foreach($query as $row){
	
		$this->product_id = $row->product_id;
		$this->quantity = $row->quantity;
		$query2 = $this->execute("SELECT * FROM products WHERE id = ?  ", [$row->product_id] );
		
		/*  DON'T ADD THE PRODUCT IF IT HAS SINCE BEEN DELETED  */
		
		if($query2[0]->deleted_at != NULL){ continue; }
		
		/*  GET THE PRICE OF THE PRODUCT, NOT THE PRICE IT WAS ORIGINALLY BOUGHT FOR, INCASE IT HAS CHANGED  */
		
		$this->cart_price = $query2[0]->price;
		
		$this->add();
	
	}
		
    }
		
		
    public function delete($id)
    {
		
	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id AND unique_id = :unique_id  ', [ 'id' => $id, 'unique_id' => $this->uniqueID ] );
	
	return redirect('cart.php', 'The item has been deleted');
		
    }


    public function updateCart()
    {
		
	foreach($_POST as $key => $value){
	
		if(strstr($key, 'quantity')){
		
			$id = preg_replace("/[^0-9]/", '', $key);
			
			$this->updateRow($this->table, ['quantity' => $_POST[$key]], 'id = :id AND unique_id = :unique_id  ', [ 'id' => $id, 'unique_id' => $this->uniqueID ] );
		
		}
	
	}
	
	return redirect('cart.php', 'The cart has been updated');
		
    }
		
		
    public function setOrderEmailHtml($html)
    {
	$_SESSION[SESSION.'order-for-email'] = $html;
    }

		
    public function updateCartWithMemberType($member_type)
    {
		
	foreach($this->getAll() as $row){
	
		$this->updateRow($this->table, ['cart_member_type' => $member_type, 'discount' => $this->discount()], 'id = :id AND unique_id = :unique_id  ', [ 'id' => $row->cart_id, 'unique_id' => $this->uniqueID ] );
	
	}
		
    }
		
		
    public function updateCartWithNoMemberType()
    {
		
	foreach($this->getAll() as $row){
	
		$this->updateRow($this->table, ['cart_member_type' => 0, 'discount' => 1], 'id = :id AND unique_id = :unique_id  ', [ 'id' => $row->cart_id, 'unique_id' => $this->uniqueID ] );
	
	}
		
    }
		
		
    public function getPromoDiscountCodeId()
    {
		
	if(isset($_SESSION[SESSION.'promo_code']) && $_SESSION[SESSION.'promo_code'] != '' ){
	
		$this->table = 'promo_codes';
		
		$row = $this->getRowByFieldNotDeleted('id', $_SESSION[SESSION.'promo_code']);
		
		return $row->id;
	
	} elseif (isset( $_COOKIE[SESSION.'promo_code'] ) && $_COOKIE[SESSION.'promo_code'] != '' ) {
	
		$this->table = 'promo_codes';
		
		$row = $this->getRowByFieldNotDeleted('id', $_COOKIE[SESSION.'promo_code']);
		
		return $row->id;
	
	} else {
	
		return null;
	
	}
		
    }
		
		
    public function getPromoDiscount()
    {
		
	if(isset($_SESSION[SESSION.'promo_code']) && $_SESSION[SESSION.'promo_code'] != '' ){
	
		$this->table = 'promo_codes';
		
		$row = $this->getRowByFieldNotDeleted('id', $_SESSION[SESSION.'promo_code']);
		
		return ( 100 - $row->percentage )  / 100;
	
	} elseif (isset( $_COOKIE[SESSION.'promo_code'] ) && $_COOKIE[SESSION.'promo_code'] != '' ) {
	
		$this->table = 'promo_codes';
		
		$row = $this->getRowByFieldNotDeleted('id', $_COOKIE[SESSION.'promo_code']);
		
		return ( 100 - $row->percentage )  / 100;
	
	} else {
	
		return 1;
	
	}
		
    }

		
    public function deletePromoCodeIfExists()
    {
		
	if( isset($_SESSION[SESSION.'promo_code']) ){
	
		unset($_SESSION[SESSION.'promo_code']);
	
	}
	
	if( isset($_COOKIE[SESSION.'promo_code']) ){
	
		setcookie(SESSION.'promo_code', '', time()-3600, '/');
	
	}
		
    }

	
    public function discountedPrice()
    {
    
	if($this->promo_code->getPromoCodeId()){
    
		$sub_total = $this->subTotal();

		$promo_code = $this->promo_code->find($this->promo_code->getPromoCodeId());
		
		if($this->promo_code->getPromoType() == 'percentage'){
		
			return Tools::showDiscountPricePercentage($sub_total, $promo_code->percentage);
		
		} else {
		
			return Tools::showDiscountPriceValue($sub_total, $promo_code->value);	
		
		}
	
	}
	
	return false;

    }





}













