<?php

function send_mail($mail, $cartID) {

	//generate email text
	$buyer = DB::find('buyer FROM ecommerce_carts WHERE id=?', [$cartID]);
		
	$row_addr = DB::row('* FROM addresses WHERE cartID=?', [$cartID]);

	$addr_aname = $row_addr['aname'];
	$addr_strt = $row_addr['address'];
	$addr_num = $row_addr['number'];
	$addr_zip = $row_addr['zip'];
	$addr_city = $row_addr['city'];
	$addr_reg = $row_addr['region'];
	
	$security = $row_addr['security'];
	$toMail = $row_addr['mail'];

	$orders = '';
	$res_ord = DB::select('ID FROM ecommerce_orders WHERE cartID=? ORDER BY ID ASC', [$cartID]);

	while ($row_ord = $res_ord->fetch_assoc()) {

		$order = new Order($row_ord['ID'], '*');

		$orders .= $order->text[0].'<br>';
	}

	$address =
		$addr_aname.'<br>'.
		$addr_strt.', '.$addr_num.'<br>'.
		$addr_zip.' '.$addr_city.' ('.$addr_reg.')';

	$txt = file_get_contents(__ROOT__.'/app/modules/mail/order_confirmation.html');

	$txt = str_replace('{{cartID}}', $cartID, $txt);
	$txt = str_replace('{{address}}', $address, $txt);
	$txt = str_replace('{{address_link}}', 'https://shippingdog.com/order/address?id='.$cartID.'&key='.$security, $txt);
	$txt = str_replace('{{orders}}', $orders, $txt);
	$txt = str_replace('{{order_link}}', 'https://shippingdog.com/order?id='.$cartID.'&buyer='.$buyer, $txt);

$mail->isSMTP();

$mail->Host = $sysData['mail-host'];
$mail->SMTPAuth = true;
$mail->Username = $sysData['mail-username'];
$mail->Password = $sysData['mail-password'];
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

	$mail->setFrom('noreply@shippingdog.com', 'Shipping Dog');
	$mail->addAddress($toMail);
	$mail->addReplyTo('info@shippingdog.com', 'Shipping Dog Info');

	$mail->isHTML(true);
	$mail->Subject = 'Conferma ordine';
	$mail->Body = $txt;

	$mail->Send();
}