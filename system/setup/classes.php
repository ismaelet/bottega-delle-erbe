<?php

load_classes();

function load_classes() {

	//load system classes
	$classes = glob(__ROOT__.'/system/classes/*.php', GLOB_BRACE);
	foreach($classes as $class) include_once($class);

	//load app classes
	$classes = glob(__ROOT__.'/app/classes/*.php', GLOB_BRACE);
	foreach($classes as $class) include_once($class);
}
