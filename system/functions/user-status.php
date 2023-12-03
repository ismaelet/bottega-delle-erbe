<?php

//check if the user is logged in
function logged() {

	global $user;

	return ($user->id && !$user->guest) ? true : false;

}

//check if the user is a guest
function guest() {

	global $user;

	return $user->guest;

}

//check if the user is an admin
function admin() {

	global $user;

	return $user->admin ? true : false;

}


//check if the user a manager
function manager() {

	global $user;

	return $user->admin == 2;

}

//check if user has a cart open
function order_count() {

	global $user;

	$orderCount = 0;

	if ($user->id && DB::table('ecommerce_carts'))
		$orderCount = DB::sum('quantity FROM ecommerce_carts WHERE buyerID=? AND status=0', [$user->id]);

	return $orderCount;
	
}