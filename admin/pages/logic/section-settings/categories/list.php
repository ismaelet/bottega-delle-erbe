<?php

//select table
$index = 'id';
$tbl = 'admin_categories';

//handle search
$query['filter'] = "name LIKE CONCAT('%',?,'%') OR category LIKE CONCAT('%',?,'%')";

//select fields
$fields = [
	['title' => 'Nome', 'name' => 'name', 'size' => 'l'],
	['title' => 'Slug', 'name' => 'slug', 'size' => 'l'],

	['type' => 'btn'],
];

$buttons = [
	['type' => 'edit'],
	['type' => 'delete'],
];