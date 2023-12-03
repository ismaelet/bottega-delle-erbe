<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/system/setup/setup.php');

$ord_str = '';

$cartID = $_POST['cartID'];
$user->id = $_POST['buyer'];

$res_cart = mysqli_query($con, "SELECT ID FROM ecommerce_carts WHERE id=$cartID AND buyer='$user->id' AND status=0");
if (mysqli_num_rows($res_cart)) {

	include_once('shared.php');
	$_SESSION['payment_cartID'] = $cartID;
	$_SESSION['payment_type'] = 'buy';
	echo 'success';

} else {
	$_SESSION['err_stripe'] = 'err';
	echo 'error';
}