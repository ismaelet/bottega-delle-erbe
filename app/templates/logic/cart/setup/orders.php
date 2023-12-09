<?php

function cart_orders($cart) {
	
	$orders = DB::select('id, itemID, colorID FROM ecommerce_orders WHERE cartID=?', $cart->id);

	return $orders;

}

//functions
function remove_order($orderID) {
	
	if ($order = DB::row('* FROM ecommerce_orders WHERE id=?', [$orderID])) {
		
		//get cart data
		$cartID = $order['cartID'];

		//delete order
		DB::delete('ecommerce_orders WHERE id=?', [$orderID]);

		//update cart or delete it if empty
		if (DB::exists('ecommerce_orders WHERE cartID=?', [$cartID]))
			DB::update('ecommerce_carts SET quantity=quantity-?, tot=tot-? WHERE id=?', [$order['quantity'], $order['price'], $cartID]);
		else
			DB::delete('ecommerce_carts WHERE id=?', [$cartID]);
		
		//refresh
		redirect('#items-anch');
		
	}

}