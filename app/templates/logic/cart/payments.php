<?php

//setup theme
$this->styles->add(__ROOT__.'/app/templates/styles/cart/payments.css');
$this->scripts->add(__ROOT__.'/app/templates/scripts/cart/payments.js');

//setup variables
$error = false;

//select payments type data
$payments = $cart->prices()['tot'] ? DB::select('* FROM ecommerce_payments WHERE active=1 ORDER BY id ASC') : DB::select('* FROM ecommerce_payments WHERE id=1 LIMIT 1');

//setup warnings
$warning = DB::find('value FROM variables WHERE name=?', ['warning']);
$warning_color = DB::find('value FROM variables WHERE name=?', ['warning_color']);

//checkout
if (isset($_POST['submit'])) {

	$paymentID = $_POST['paymentID'][0];

	$url = DB::find('url FROM ecommerce_payments WHERE id=?', [$paymentID]);
	
	DB::update('ecommerce_carts SET paymentID=? WHERE id=?', [$paymentID, $cart->id]);
	
	redirect('pay/' . $url);

}

//store variables
$this->set('payments', $payments);