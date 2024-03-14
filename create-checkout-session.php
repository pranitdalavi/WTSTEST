<?php

require __DIR__.'/includes/config.php';

$orderObj = new App\Order();
$cartObj = new App\Cart();

require 'stripe/vendor/autoload.php';

  \Stripe\Stripe::setApiKey('');

header('Content-Type: application/json');


$discounts = [];
$customer = \Stripe\Customer::create([
    "name" => $_SESSION["shipping_name"],
    "email" => $_SESSION["shipping_email"],
    "address" => [
        "city" => $_SESSION["shipping_address1"],
        "line1" => $_SESSION["shipping_address2"],
        "line2" => $_SESSION["shipping_city"],
        "postal_code" => $_SESSION["shipping_postcode"]
    ],
    "shipping" => [
        "name" => $_SESSION["shipping_name"],
        "phone" => $_SESSION["shipping_phone"],
        "address" => [
            "city" => $_SESSION["shipping_address1"],
            "line1" => $_SESSION["shipping_address2"],
            "line2" => $_SESSION["shipping_city"],
            "postal_code" => $_SESSION["shipping_postcode"]
        ]
    ]
]);


foreach( $cartObj->getAll() as $row ){
    $extra = " ";

    if($row->extra != null and $row->extra != ""){
        foreach (explode(",",$row->extra) as $item){
            $extra .= " - " .$item;
        }
        $extra = substr($extra,2);
    }



	$line_items[] =   [
	    'price_data' => [
	      'currency' => 'gbp',
	      'unit_amount' => $row->cart_price * 100,
	      'product_data' => [
              'name' => $row->title,
              'images' => [],
              'description' => $extra,

	      ],
	    ],
	    'quantity' => $row->quantity
	  ];

  }




	  if( $cartObj->shipping() ){

		$line_items[] = [];

	  }


$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card','klarna','afterpay_clearpay'],
  'customer' => $customer->id,
  'line_items' => $line_items,
    'shipping_address_collection' => [
        'allowed_countries' => ['GB']
    ],
  'mode' => 'payment',
  'discounts' => $discounts,
  'success_url' => DOMAIN.'/complete?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => DOMAIN.'/cart',
]);

$stripe_checkout_session_id = $checkout_session->id;

//print_r($checkout_session);

/*  add unique identifier $stripe_checkout_session_id to the order so we can reference this on the complete page and set the order to New. This session id will be in the url  */

$orderObj->updateRow('orders', ['stripe_session_id' => $stripe_checkout_session_id], 'id = :id LIMIT 1 ', [ 'id' => $_SESSION[SESSION.'order_id'] ] );

echo json_encode(['id' => $stripe_checkout_session_id]);
