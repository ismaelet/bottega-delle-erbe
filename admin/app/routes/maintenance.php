<?php

//offline page
Route::add('/offline', function() {

	//setup view
	$view = new View('errors/offline');
	$view->title = 'Offline';
	$view->template = 'void';
	$view->middlewares = ['not_public'];

	//render view
	$view->show();

});