<?php

function load_middleware($name, $user, $view) {

	$middleware = false;

	if (file_exists($file = __ROOT__.'/app/middlewares/'.$name.'.php')) $middleware = $file;
	else if (file_exists($file = __ROOT__.'/system/middlewares/'.$name.'.php')) $middleware = $file;

	require_once($middleware);
	
}