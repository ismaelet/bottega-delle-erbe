<?php

function item_add($desID, $typeID) {

	$type = new Type($typeID);

	//get the seller
	$sellID = DB::find('userID FROM designs WHERE id=?', [$desID]);

	write_log($sellID);
	
	//set as the main item if it's tshirt
	$main = $typeID == 1 ?: 0;
	
	//get colors
	if (empty($type->colors)) {

		$colors = ['emp'];
		$colorID = 0;

	} else {

		$colors = [];

		foreach ($type->colors as $color) if (DB::exists('items_colors WHERE tag=? and hidden=0', [$color])) $colors[] = $color;

		$colorID = empty($colors) ? 0 : DB::find('ID FROM items_colors WHERE tag=?', [$colors[0]]);
	}

	$colors = implode(',', $colors);
	
	//set default mockup data
	$mock_base = in_array('_m', $type->mockups) && in_array('_f', $type->mockups) ? $type->tag.'_m' : $type->tag;

	$row_mock = DB::row('* FROM items_mockups WHERE base=?', [$mock_base]);
	
	$posY = $row_mock['pos_y_def'] ?? 0;
	$sizX = $row_mock['siz_x_def'] ?? 0;

	//create item
	$itemID = DB::add(
		'items (userID, desID, typeID, colorID, colors, main, pos_y, size, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)',
		[$sellID, $desID, $typeID, $colorID, $colors, $main, $posY, $sizX]);

	//get the prices of the shop
	$row_price = DB::row('* FROM prices_stores WHERE storeID=? AND typeID=?', [$sellID, $typeID]);

	$price = $row_price['price'];
	$gain_w = $row_price['gain_w'];
	$gain_c = $row_price['gain_c'];

	//add the price
	DB::add('items_prices (itemID, price, gain_w, gain_c) VALUES (?, ?, ?, ?)', [$itemID, $price, $gain_w, $gain_c]);
}