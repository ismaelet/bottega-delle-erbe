<?php

//get url of a file
function file_url($file, $view = false) {

	if ($view && $file[0] != '/') $url = file_time(path_img_dir($view->url) . $file);
	else $url = file_time($file);

	return __HROOT__.$url;
}

//avoid cache if the chached file is not up to date
function file_time($file) {

	if (!strpos($file, '?=') && file_exists($url = __ROOT__.$file)) $file .= '?='.filemtime($url);
	
	return $file;
}

//put the image as background image
function background_image($img, $view = false) {

	return 'style="background-image: url('.file_url($img, $view).');"';
}

//put a svg as background image
function img_svg($img, $view = false) {

	return 'style="mask: url('.file_url($img, $view).'); -webkit-mask: url('.file_url($img, $view).') center;"';
}

//get the url of an icon
function icon_url($icon, $view = false) {

	$file = $icon.'.svg';

	if ($view) $file = path_img_dir($view->url) . $file;
	else $file = __ICON__ . $file;

	return __HROOT__ . file_time($file);

}

//put an icon as background image
function icon_css($icon) {

	return 'style="background-image: url(' . icon_url($icon) . ');"';

}

//put a svg icon as background image
function icon_svg($icon, $view = false) {

	return 'style="mask: url(' . icon_url($icon, $view) . '); -webkit-mask: url(' . icon_url($icon, $view) . ') center;"';

}

//embedded icon
function icon_embed($icon, $view = false) {

	return file_get_contents(__ROOT__ . __ICON__ . $icon . '.svg');
	
}

//html url
function html_link($url = '') {

	return __HROOT__ . '/' .$url;

}

//get the url of a page's image folder 
function path_img_dir($page_url) {

	$url = substr($page_url, strpos($page_url, 'pages') - 1);

	$url = str_replace(['/views/', '.php'], ['/images/', '/'], $url);

	return $url;

}

//parse a url from php to html
function parse_html($url, $full = true) {

	$url = str_replace("\\", "/", $url);

	if (strpos($url, __ROOT__) !== false) $url = $full ? __HROOT__.'/'.substr($url, strlen(__ROOT__) + 1) : '/'.substr($url, strlen(__ROOT__) + 1);
	
	return $url;
}

//get all files in a folder
function scan($path, $ext = '*') {

	$files = [];

	if (strpos($path, __ROOT__) === false) $path = __ROOT__.$path;

	foreach (glob($path.'/*.'.$ext) as $file) $files[] = $file;

	return $files;
}

//get all files in the subfolders of a folder
function scans($path, $ext = '*') {

	$files = [];

	foreach (glob(__ROOT__.$path.'/*', GLOB_ONLYDIR) as $dir) array_push($files, ...scan($dir, $ext));

	return $files;

}