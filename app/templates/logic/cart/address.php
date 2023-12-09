<?php

//setup theme
$this->styles->add(__ROOT__.'/app/templates/styles/cart/address.css');

//setup variables
$error = false;
$methods = [];

//setup warnings
$warning = DB::find('value FROM variables WHERE name=?', ['warning']);
$warning_color = DB::find('value FROM variables WHERE name=?', ['warning_color']);

//fetch shipping data
if ($cart_config['ship_abroad']) {

	$countries = DB::select('* FROM ecommerce_countries WHERE active=1 ORDER BY name ASC');
	$zone = DB::find('zone FROM ecommerce_countries WHERE id=?', [$cart->country]);
	$res_methods = DB::select('* FROM ecommerce_shipping WHERE FIND_IN_SET(tag, ?)>0 ORDER BY tier DESC', [$zone]);

} else $res_methods = DB::select('* FROM ecommerce_shipping WHERE active=1 ORDER BY tier DESC');

//generate shipping methods
$first = true; while ($row = $res_methods->fetch_assoc()) {

	$method['id'] = $row['id'];
	$method['name'] = $row['name'];
	$method['text'] = $row['text'];
	$method['date'] = ship_days($cart->shippingID);
	$method['price'] = ship_price($method['id'], $cart->quantity, $cart->id);

	if ($cart->shippingID == $method['id'] || (!$cart->shippingID && $first)) {

		$first = false;
		$method['checked'] = true;

	} else $method['checked'] = false;

	$methods[] = $method;

}
					
//fetch address
$address = DB::row('* FROM ecommerce_addresses WHERE cartID=?', [$cart->id]);

if (!$address) $address = DB::row('* FROM ecommerce_addresses WHERE buyerID=? ORDER BY id DESC', [$user->id]);

//remove item
if (isset($_POST['remove'])) {

	$ordID = $_POST['ordID'];

	remove_order($ordID);

}

//add code
if (isset($_POST['add_code'])) {

	$error = add_code($cart);

}

//remove code
if (isset($_POST['del_code'])) {

	remove_code($cart);

}

//checkout
if (isset($_POST['submit'])) {
	
	$method = $_POST['method'][0];

	DB::update('ecommerce_carts SET shippingID=?, tot=?, price_shipping=? WHERE id=?', [$method, $cart->prices()['tot'], $cart->prices()['shipping'], $cart->id]);
	
	if ($cart->step == $loc) DB::update('ecommerce_carts SET step=? WHERE id=?', [$loc + 1, $cart->id]);
	
	//save address
	$name = ucwords(strtolower(trim($_POST['name'])));
	$street = ucwords(strtolower(trim($_POST['street'])));
	$num = isset($_POST['number']) ? trim($_POST['number']) : '';
	$zip = strtoupper(trim($_POST['zip']));
	$city = ucwords(strtolower(trim($_POST['city'])));
	$reg = strtoupper(trim($_POST['region']));
	$mail = strtolower(trim($_POST['mail']));
	$phone = trim($_POST['phone']);

	$security = random_string();
	
	if (DB::exists('ecommerce_addresses WHERE cartID=?', [$cart->id]))

		DB::update('ecommerce_addresses SET name=?, street=?, number=?, zip=?, city=?, region=?, mail=?, phone=?, security=? WHERE cartID=?',
			[$name, $street, $num, $zip, $city, $reg, $mail, $phone, $security, $cart->id]);

	else
		DB::add('ecommerce_addresses (cartID, buyerID, name, street, number, zip, city, region, mail, phone, security) VALUES
			(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			[$cart->id, $user->id, $name, $street, $num, $zip, $city, $reg, $mail, $phone, $security]);
	
	redirect('cart?step='.($loc + 1));
}

//store variables
$this->set('methods', $methods);
$this->set('address', $address);
if ($cart_config['ship_abroad']) $this->set('countries', $countries);