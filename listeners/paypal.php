<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/system/setup/setup.php');

//setup page
$ord_str = '';
$i = 1;
$codUsed = false;

//get raw data from POST
$raw_post_data = file_get_contents('php://input');

//convert raw data tu array
$raw_post_array = explode('&', $raw_post_data);

//separate variabile and value in array
$myPost = array();

foreach ($raw_post_array as $keyval) {
	$keyval = explode('=', $keyval);

	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}

//
$req = 'cmd=_notify-validate';

foreach ($myPost as $key => $value) {
    $value = urlencode($value);
    $req .= "&$key=$value";
}

//post IPN data back to paypal to validate
$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

if (!($res = curl_exec($ch))) {
	curl_close($ch);
	exit;
}
curl_close($ch);


//GET TRANSACTION DATA
if (strcmp ($res, "VERIFIED") == 0) {
	
	//get status and mail
	$status = $_POST['payment_status'];
	
	//////////////*EDITABLE*//////////////
	if ($status == 'Completed') {
		
		//GET PAYMENT DATA DATA
		$custom = isset($_POST['custom']) ? $_POST['custom'] : '';
		$cust_array = explode('&', $custom);
		
		$cartID = $cust_array[0];
		
		//refund or change
		if (isset($cust_array[1]) && $cust_array[1] == 'ship') mysqli_query($con, "UPDATE refunds SET status=4, payed=1 WHERE cartID=$cartID");

		else if (isset($cust_array[0]) && $cust_array[0] == 'neos') {

			$to      = 'info@shippingdog.com';
			$subject = 'Vendita Neos';

			$headers =
				'From: ShippingDogSite@info.com' . "\r\n" .
				'Reply-To: '.$mail."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			$headers .= 'MIME-Version: 1.0' . "\r\n";  
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";  

			$message = 'Vendita effettuata sul sito di Daniel';
			
			mail($to, $subject, $message, $headers);
		}
			
		//normal payment 
		else if (isset($cust_array[1])) {
			$lang = $cust_array[2];

			include_once('shared.php');
		}
	}
	
}
?>