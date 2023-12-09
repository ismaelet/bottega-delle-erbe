<?php

//select table
$tbl = 'items';
$index = 'id';
$query['index'] = 'time';

//handle search
$query['filter'] = "
	id=? OR
	name LIKE CONCAT('%',?,'%') OR
	type IN (SELECT tag FROM items_types WHERE name LIKE CONCAT('%',?,'%')) OR
	ingredients LIKE CONCAT('%',?,'%')
";

//select fields
$fields = [
	['title' => 'ID', 'name' => 'id', 'size' => 's'],
	['title' => 'Nome', 'name' => 'name', 'size' => 'l'],
	['title' => 'Tipo', 'name' => 'type', 'type' => 'find', 'find' => 'name FROM items_types WHERE tag=?', 'size' => 2],
	['title' => 'Prezzo', 'name' => 'price', 'size' => 2, 'parse' => 'float'],
	['title' => 'Data di aggiunta', 'name' => 'time', 'parse' => 'date-day', 'size' => 2],

	['type' => 'btn'],
];

$buttons = [
	['type' => 'edit'],
	['type' => 'delete'],
];

function expand_results(&$entry, $field, $key, $row) {

	if ($field['name'] == 'price') $entry['value'] = formatc($entry['value']) . ' €';
}
