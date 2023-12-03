<?php

//dependencies
include_once('logic/element_shop_class.php');
include_once('logic/element_shop_setup.php');
include_once('logic/element_shop_layout.php');
include_once('logic/element_shop_original.php');

//add to cart
if (isset($_POST['add-to-cart'])) {

	$item = new Item($_POST['itemID']);

	$data = [
		'itemId' => $item->id,
		'price' => $item->price,
		'quantity' => 1,
	];

	Cart::add($data);

}

//load shop function
function element_shop() {

	$shop = new Shop_setup();

	$shop->setup_shop();
	
	view_shop($shop);
}