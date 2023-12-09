<?php

include_once(__ROOT__.'/vendor/PHPMailer/src/Exception.php');
include_once(__ROOT__.'/vendor/PHPMailer/src/PHPMailer.php');
include_once(__ROOT__.'/vendor/PHPMailer/src/SMTP.php');

//send email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

//get cart data
$row_cart = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM ecommerce_carts WHERE id=$cartID"));
$user->id = $row_cart['buyer'];
$shipID = $row_cart['shipID'];
$cart_amnt = $row_cart['quantity'];
$code_str = $row_cart['code'];
$code = ($code_str == 'none') ? false : $code_str;
$credit = round($row_cart['credit'], 2);

//get special code data
$codNoga = false;

if ($code) {$row_code = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM codes WHERE id='$code'"));}

//get shipping data
$row_ship = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM sys_shipping WHERE id=$shipID"));
$ship_str = strtoupper($row_ship['name']);

//update date
mysqli_query($con, "UPDATE carts SET time=DATE_ADD(NOW(), INTERVAL 6 HOUR) WHERE id=$cartID");

//update credit
if ($credit) mysqli_query($con, "UPDATE stores SET credit=credit-$credit WHERE userID='$user->id'");

//add paypal code
$txnID = isset($_POST['txn_id']) ? $_POST['txn_id'] : 0;

mysqli_query($con, "UPDATE addresses SET txnID='$txnID' WHERE cartID=$cartID");

$res_ord = mysqli_query($con, "SELECT ID FROM ecommerce_orders WHERE cartID=$cartID ORDER BY ID ASC");

//ADD SALE CART
while ($row_ord = mysqli_fetch_assoc($res_ord)) {
	
	$order = new Order($row_ord['ID'], '*');
	$item = $order->item;

	//get variabiles data
	$qty = 1;

	if ($item->desID) {

		//ADD SALE
		//calculate gain
		$gain = ($order->gain - $order->gain_disc) * $qty;
		$gain = round($gain, 2);
		$gain_credit = round($gain / 10, 2);

		//add sale
		$saleID = DB::add('sales (desID, storID, amount, typeID, colorID, gain, code) VALUES (?, ?, ?, ?, ?, ?, ?)', [$item->desID, $item->sellerID, $qty, $item->type->id, $item->color->id, $gain, $code]);

		DB::add('feed (feedID, userID, type) VALUES (?, ?, ?)', [$saleID, $item->sellerID, 2]);

		//add gain
		mysqli_query($con, "UPDATE stores SET total=total+$gain WHERE userID=$item->sellerID");
		mysqli_query($con, "UPDATE stores SET credit=credit+$gain_credit WHERE userID=$item->sellerID");

		//update sale number
		mysqli_query($con, "UPDATE stores SET sales=sales+$qty WHERE userID=$item->sellerID");
		mysqli_query($con, "UPDATE designs SET sales=sales+$qty WHERE id=$item->desID");
		mysqli_query($con, "UPDATE items SET sales=sales+$qty WHERE id=$item->id");

		//remove from inventory
		if ($order->extID) $invID = DB::find('ID FROM inventory WHERE desID=? AND class=? AND colorID=? AND sizeID=? AND posID=? AND (extID=? OR extID=0)', [$item->desID, $item->type->class, $order->colorID, $order->sizeID, $order->posID, $order->extID]);

		else $invID = DB::find('ID FROM inventory WHERE desID=? AND class=? AND colorID=? AND sizeID=? AND posID=?', [$item->desID, $item->type->class, $order->colorID, $order->sizeID, $order->posID]);

		if ($invID) {
			DB::delete('inventory WHERE id=?', [$invID]);
			DB::update('orders SET inventory=1 WHERE id=?', $order->id);
		}
	}
}

//REMOVE BONUS CODE
if ($code) mysqli_query($con, "DELETE FROM codes WHERE id='$code' AND permanent=0");

//PROCESS ORDERS
mysqli_query($con, "UPDATE carts SET status=1, step=4 WHERE id=$cartID AND status=0");

//send confirmation email
load_module('send_mail');

send_mail($mail, $cartID);