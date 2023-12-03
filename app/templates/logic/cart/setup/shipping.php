<?php

function ship_days($shippingID, $dateNow = false) {

	$dates = [];

	$row_shipM = DB::row('* FROM ecommerce_shipping WHERE id=?', [$shippingID]);

	date_default_timezone_set('Europe/Rome');
	if (!$dateNow) $dateNow = date('Y/m/d/', time());
	$dayWeek = date('N', strtotime($dateNow));

	$day_str_it = array('lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica');
	$day_str_en = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	$mont_str_it = array('gen.', 'feb.', 'mar.', 'apr.', 'mag.', 'giu.', 'lug.', 'ago.', 'set.', 'ott.', 'nov.', 'dic.');
	$mont_str_en = array('Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'Jun.', 'Jul.', 'Aug.', 'Sep.', 'Oct.', 'Nov.', 'Dec.');

	$holi = array('25-12', '26-12', '15-08');

	$passAll = $passWork = 0;
	
	$daysWMin = 2;
	$daysWMax = 3;

	if ($shippingID == 11) $daysWMin = $daysWMax = 0;

	$daysSMin = $row_shipM['days_min'];
	$daysSMax = $row_shipM['days_max'];

	$daysMin = $daysWMin + $daysSMin;
	$daysMax = $daysWMax + $daysSMax;

	while ($passWork < $daysMin) {

		$dayWeek++;
		if ($dayWeek > 7) $dayWeek = 1;

		$passAll++;
		
		$curr = date('d-m', strtotime($dateNow.' +'.$passAll.' days'));

		if (!in_array($dayWeek, array(6, 7)) && !in_array($curr, $holi)) $passWork++;
	}

	$dateRaw = strtotime($dateNow.' +'.$passAll.' days');
	$resDayW = date('N', $dateRaw);
	$resDayN = date('d', $dateRaw);
	$resMont = date('m', $dateRaw);

	$dates[] = ucfirst(${'day_str_it'}[$resDayW - 1]).' <span class="txt-bold txt-2">'.$resDayN.'</span class="txt-bold txt-2"> '.${'mont_str_it'}[$resMont - 1];

	while ($passWork < $daysMax) {

		$dayWeek++;
		if ($dayWeek > 7) $dayWeek = 1;

		$passAll++;
		
		$curr = date('d-m', strtotime($dateNow.' +'.$passAll.' days'));

		if (!in_array($dayWeek, array(6, 7)) && !in_array($curr, $holi)) $passWork++;
	}

	$dateRaw = strtotime($dateNow.' +'.$passAll.' days');
	$resDayW = date('N', $dateRaw);
	$resDayN = date('d', $dateRaw);
	$resMont = date('m', $dateRaw);

	$dates[] = ${'day_str_it'}[$resDayW - 1].' <span class="txt-bold txt-2">'.$resDayN.'</span class="txt-bold txt-2"> '.${'mont_str_it'}[$resMont - 1];

	return $dates;
}

function ship_price($id, $quantity, $cartID) {

	$method = DB::row('* FROM ecommerce_shipping WHERE id=?', [$id]);

	//calculate price
	$price = $method['price_base'] + $method['price_more'] * ($quantity - 1);

	//stop at max price
	if ($price > $method['price_max']) $price = $method['price_max'];

	//free shipping for orders above 150€
	$tot = DB::sum('price*quantity FROM ecommerce_orders WHERE cartID=?', [$cartID]);

	if ($tot >= 150) $price = 0;

	return format($price);
}