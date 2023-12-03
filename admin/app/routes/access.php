<?php

//login
Route::add('/login', function() {

	//setup view
	$view = new View('login');
	$view->title = 'Login';
	$view->middlewares = ['not_admin'];

	//render view
	$view->show();

});

//logout
Route::add('/logout', function() {

	//setup view
	$view = new View('logout');
	$view->title = 'Logout';
	$view->middlewares = ['admin'];

	//render view
	$view->show();

});