<?php

function add_code($cart) {

	global $con;

	$error = false;

	$code = $_POST['code'];

	$code = strtoupper(trim($_POST['code']));
	
	$res_code = mysqli_query($con, "SELECT * FROM codes WHERE code='$code'");
	
	if (mysqli_num_rows($res_code)) {
		$row_code = mysqli_fetch_assoc($res_code);
		
		if (strtotime($row_code['time_end']) < strtotime('now')) $error = 'code_exp';
		else if (strtotime($row_code['time_start']) > strtotime('now')) $error = 'code_ear';
		else {
			
			DB::update('carts SET step=2, code=? WHERE id=?', [$code, $cart->id]);

			calculate_code($cart, $code);

			redirect('#code');
		}
		
	} else $error = 'code_bad';

	return $error;
}

function remove_code($cart) {

	global $con;

	DB::update("carts SET code='' WHERE id=?", [$cart->id]);
	DB::update('orders SET price_disc=0, gain_disc=0 WHERE cartID=?', [$cart->id]);

	redirect();
}

function calculate_code($cart, $code) {

	global $con;

	$codUsable = true;

	$res_code = mysqli_query($con, "SELECT * FROM codes WHERE code='$code'");

	//calculate code
	if ($row_code = mysqli_fetch_assoc($res_code)) {

		$codShip = $row_code['shipping'] ? true : false;
		$codZero = $row_code['zero'] ? true : false;

		//remove shipping cost if code active
		if ($codShip) mysqli_query($con, "UPDATE carts SET shipID=1 WHERE id=$cart->id");
		
		//update orders
		$res_code_ord = mysqli_query($con, "SELECT * FROM ecommerce_orders WHERE cartID=$cart->id");
		$ordN = mysqli_num_rows($res_code_ord);

		while ($row_ord = mysqli_fetch_assoc($res_code_ord)) {
			
			$discThem = $discUs = 0;
			
			//get item data
			$ordID = $row_ord['ID'];
			$itemID = $row_ord['itemID'];
			$row_item = mysqli_fetch_assoc(mysqli_query($con, "SELECT userID, desID, typeID FROM items WHERE id=$itemID"));
			$desID = $row_item['desID'];
			$storeID = $row_item['userID'];
			$typeID = $row_item['typeID'];

			//check matches
			$codDes = (!$row_code['desID'] || $row_code['desID'] == $desID) ? true : false;
			$codStor = (!$row_code['storID'] || $row_code['storID'] == $storeID) ? true : false;
			$codType = (!$row_code['typeID'] || $row_code['typeID'] == $typeID) ? true : false;
			$codcolor = (!$row_code['colorID'] || $row_code['colorID'] == $row_ord['colorID']) ? true : false;

			//calculate discount amount
			if ($codDes && $codStor && $codType && $codcolor && $codUsable) {

				//calc discount when equal to the artist gain
				if ($codZero) $discThem = $row_ord['gain'];
				
				//calc standard discount
				else {
					//percentage
					$modUs1 = $row_code['mod_us'] / 100;
					$modThem1 = $row_code['mod_them'] / 100;
					$modUs2 = $row_code['mod_us2'] / 100;
					$modThem2 = $row_code['mod_them2'] / 100;
					$modUs3 = $row_code['mod_us3'] / 100;
					$modThem3 = $row_code['mod_them3'] / 100;

					if ($modUs3 && $ordN > 2) $modUs = $modUs3;
					else if ($modUs2 && $ordN > 1) $modUs = $modUs2;
					else $modUs = $modUs1;
					
					if ($modThem3 && $ordN > 2) $modThem = $modThem3;
					else if ($modThem2 && $ordN > 1) $modThem = $modThem2;
					else $modThem = $modThem1;

					//falt
					$flatUs1 = $row_code['flat_us'];
					$flatThem1 = $row_code['flat_them'];
					$flatUs2 = $row_code['flat_us2'];
					$flatThem2 = $row_code['flat_them2'];
					$flatUs3 = $row_code['flat_us3'];
					$flatThem3 = $row_code['flat_them3'];

					if ($flatUs3 && $ordN > 2) $flatUs = $flatUs3;
					else if ($flatUs2 && $ordN > 1) $flatUs = $flatUs2;
					else $flatUs = $flatUs1;
					if ($flatThem3 && $ordN > 2) $flatThem = $flatThem3;
					else if ($flatThem2 && $ordN > 1) $flatThem = $flatThem2;
					else $flatThem = $flatThem1;

					//total
					$discUs = ($row_ord['price'] * $modUs) + $flatUs;
					$discThem = ($row_ord['price'] * $modThem) + $flatThem;
				}
			
				$discThem = round($discThem, 2);
				$discitem = round($discUs + $discThem, 2);

				//make the gain 0 if code is selected
				$discGain = $row_code['nogain'] ? $row_ord['gain'] : $discThem;

				//set used code
				if (!$row_code['multiple']) $codUsable = false;

				if ($codUsable) $discitem *= $row_ord['quantity'];

				mysqli_query($con, "UPDATE orders SET price_disc=$discitem, gain_disc=$discGain WHERE id=$ordID");
			}
		}
	}
}