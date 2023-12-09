<?php

//item
Route::add('/shop/item', function() {
	
	//setup page
	$view = new View('item');
	$view->loc = 'shop';

	//show page
	$view->show();
	
});

//list
Route::add('/shop/list', function() {
	
	//setup page
	$view = new View('shop/list');
	$view->loc = 'shop';

	//show page
	$view->show();
	
});

//cart
Route::add('/cart', function() {
	
	//get step
	$step = $_GET['step'] ?? 1;

	//setup page
	$view = new View('cart');
	$view->title = 'Carrello';
	$view->template = 'cart';

	//show page
	$view->show();

});

//cart
Route::add('/cart/empty', function() {

	//setup page
	$view = new View('cart/empty');
	$view->title = 'Carrello';
	$view->styles[] = __ROOT__.'/app/templates/styles/cart.css';

	//show page
	$view->show();

});

//pay with paypal
Route::add('/pay/paypal', function() {

	//setup page
	$view = new View('cart/paypal');
	$view->title = 'Pagamento';
	$view->template = 'void';
	
	//show page
	$view->show();

});

//payment success page
Route::add('/cart/success', function() {

	//setup page
	$view = new View('cart/success');
	$view->title = 'Processando il Pagamento';

	//show page
	$view->show();

});

//order completed
Route::add('/order', function() {

	//setup page
	$view = new View('order/completed');
	$view->styles[] = __ROOT__.'/app/templates/styles/cart.css';

	//show page
	$view->show();

});