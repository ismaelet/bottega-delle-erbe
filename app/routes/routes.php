<?php

//homepage
Route::add('/', function() {
	
	//setup page
	$view = new View('home');
	$view->loc = 'home';

	//load resources
	$view->elements = ['shop'];

	//show page
	$view->show();

});

//shop
Route::add('/shop', function() {

	//setup page
	$view = new View('shop');
	$view->title = 'Negozio';
	$view->loc = 'shop';

	//load resources
	$view->elements = ['shop'];
	
	//show page
	$view->show();
});

//item
Route::add(['/shop/item', '/item'], function() {

	//setup page
	$view = new View('item');
	$view->loc = 'shop';
	
	//show page
	$view->show();
});

//herbs
Route::add('/herbs', function() {

	//setup page
	$view = new View('herbs');
	$view->title = 'Erbe e Tisane';

	//show page
	$view->show();

});

//courses
Route::add('/courses', function() {

	//setup page
	$view = new View('courses');
	$view->title = 'Corsi';

	//show page
	$view->show();

});

//course
Route::add('/courses/course', function() {

	//setup page
	$view = new View('courses/course');

	//show page
	$view->show();

});

//blog
Route::add('/blog', function() {

	//setup page
	$view = new View('blog');
	$view->title = 'Novità';

	//show page
	$view->show();

});

//post
Route::add('/blog/post', function() {

	//setup page
	$view = new View('blog/post');

	//show page
	$view->show();

});

//contacts
Route::add('/contacts', function() {

	//setup page
	$view = new View('contacts');
	$view->title = 'Contatti';

	//show page
	$view->show();

});

//search
Route::add('/search', function() {

	//setup page
	$view = new View('search');

	//show page
	$view->show();

});