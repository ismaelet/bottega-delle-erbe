<?php

function load_module($name) {

	$module = false;

	if (file_exists($file = __ROOT__.'/app/modules/'.$name.'.php')) $module = $file;
	else if (file_exists($file = __ROOT__.'/system/modules/'.$name.'.php')) $module = $file;

	if ($module) include_once($module);
}