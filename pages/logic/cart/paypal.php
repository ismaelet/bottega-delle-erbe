<?php

//load resources
include_once(__ROOT__.'/app/templates/logic/cart/setup/config.php');
include_once(__ROOT__.'/app/templates/logic/cart/setup/orders.php');
include_once(__ROOT__.'/app/templates/logic/cart/setup/shipping.php');

//fetch user
global $user;

//setup cart
$cartID = DB::find('id FROM ecommerce_carts WHERE buyerID=? and status=0', $user->id);

if (!$cartID) redirect('cart/empty');

$cart = new Cart($cartID, '*');

//redirect if the payment type isn't paypal
if ($cart->paymentID != 2) redirect('cart');

//fetch orders
$orders = cart_orders($cart);

//fetch address data
$address = DB::row('* FROM ecommerce_addresses WHERE cartID=?', [$cart->id]);

//store variables
$this->set('cart', $cart);
$this->set('orders', $orders);
$this->set('address', $address);
$this->set('cart_config', $cart_config);