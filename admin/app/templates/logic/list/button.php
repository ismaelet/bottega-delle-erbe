<?php

foreach ($buttons as $raw) {

	$button = [];

	$type = $raw['type'] ?? 'custom';
	$title = $raw['title'] ?? false;
	$name = $raw['name'] ?? false;
	$warning = $raw['warning'] ?? false;
	$color = $raw['color'] ?? 'c1';
	$url = $raw['url'] ?? false;

	if ($type == 'edit') {

		$title = 'Modifica';
		$color = 'blu';
		$url_query = explode('?', $_SERVER['REQUEST_URI'], 2)[1] ?? '';
		$url = 'add?id='.$row[$index].'&'.$url_query;

	} else if ($type == 'delete') {

		$title = 'Elimina';
		$name = 'delete';
		$color = 'red';
		$warning = "Sicuro di voler eliminare l\'elemento?";

	}

	$url = str_replace('{{index}}', $row[$index], $url) ?? false;

	$button['title'] = $title;
	$button['warning'] = $warning;
	$button['color'] = $color;
	$button['name'] = $name;
	$button['url'] = $url;
	$button['type'] = $url ? 'link' : 'button';

	$entry['buttons'][] = $button;

}