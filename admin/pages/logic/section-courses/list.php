<?php

//select table
$tbl = 'courses';
$index = 'id';

//handle search
$query['filter'] = "
	title LIKE CONCAT('%',?,'%') OR
	text LIKE CONCAT('%',?,'%')
";

//select fields
$fields = [
	['title' => 'Titolo', 'name' => 'title', 'size' => 3],
	['title' => 'Testo', 'name' => 'text', 'size' => 4, 'max' => 50],
	['title' => 'Orario', 'name' => 'schedule', 'size' => 4, 'max' => 50],

	['type' => 'btn'],
];

$buttons = [
	['type' => 'edit'],
	['type' => 'delete'],
];