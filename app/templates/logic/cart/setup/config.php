<?php

$cart_config = [
	'fb_login' => false,
	
	'ship_abroad' => false,
	'discount_code' => false,

	'addr_num' => false,

	'pp_address' => 'online@bottegadelleerbe.com',
	'pp_return' => false,
];

$cart_flow = [
	['Spedizione', 'address'],
	['Pagamento', 'payments'],
	['Completato', ''],
];

bump($cart_flow);