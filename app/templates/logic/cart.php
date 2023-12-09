<?php

//setup template
$this->add_logic('main', 'template');
$this->styles->add(__ROOT__.'/app/templates/styles/cart.css');

//fetch user
$user = $this->get('user');

//get variables
$loc = $_GET['step'] ?? 1;

//load resources
include_once('cart/setup/config.php');
include_once('cart/setup/orders.php');
include_once('cart/setup/flow.php');
include_once('cart/setup/recap.php');
include_once('cart/setup/items.php');
include_once('cart/setup/shipping.php');
include_once('cart/setup/codes.php');

//set page
$page = $cart_flow[$loc][1];

//fetch cart ID
$cartID = DB::find('id FROM ecommerce_carts WHERE buyerID=? and status=0', $user->id);

//redirect if the cart doesn't exists
if (!$cartID) redirect('cart/empty');

//generate cart
$cart = new Cart($cartID, '*');

//clean and redirect if the cart is empty
if (!$cart->quantity) {

	DB::delete('carts WHERE id=?', $cartID);

	redirect('cart/empty');

}

//redirect if at the wrong step
if ($cart->step < $loc) redirect('cart?step='.$cart->step);

//load page resources
include_once("cart/$page.php");

//store variables
$this->set('loc', $loc);
$this->set('cart', $cart);
$this->set('page', $page);
$this->set('cart_flow', $cart_flow);
$this->set('cart_config', $cart_config);