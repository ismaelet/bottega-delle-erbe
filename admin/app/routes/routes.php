<?php

//home
Route::add('/', function() {

	//setup view
	$view = new View('home');
	$view->template = 'admin';
	$view->middlewares = ['admin'];

	//render view
	$view->show();

});

//sections
$sections = DB::select('* FROM admin_sections');

while ($section = $sections->fetch_assoc()) {
	
	Route::add('/'.$section['category'].'/'.$section['slug'], function($section) {

		//setup view
		$view = new View('section-'.$section['category'].'/'.$section['slug']);
		$view->title = $section['name'];
		$view->template = $section['template'];
		$view->middlewares = ['admin'];

		//show view
		$view->show();

	}, $section);

}