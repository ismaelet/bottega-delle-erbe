<?php

//general redirect
function redirect($path = false) {
	
	if ($path === false)
		$url = $_SERVER['REQUEST_URI'];
	else
		$url = strlen($path) && $path[0] == '#' ? $path : html_link($path);

	header('Location: ' . $url);

	exit();
	
}