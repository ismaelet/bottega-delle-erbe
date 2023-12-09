<?php

//select table
$index = 'id';
$tbl = 'admin_sections';
$query['index'] = 'category ASC, slug ASC, name';
$query['order'] = 'asc';

//handle search
$query['filter'] = "name LIKE CONCAT('%',?,'%') OR slug LIKE CONCAT('%',?,'%') OR category LIKE CONCAT('%',?,'%') OR category IN (SELECT slug FROM admin_categories WHERE name LIKE CONCAT('%',?,'%'))";

//select fields
$fields = [
	['title' => 'Nome', 'name' => 'name', 'size' => 'l'],
	['title' => 'Slug', 'name' => 'slug', 'size' => 'm'],
	['title' => 'Gruppo', 'name' => 'category', 'type' => 'find', 'find' => 'name FROM admin_categories WHERE slug=?', 'size' => 'm'],
	['title' => 'URL', 'name' => 'url', 'size' => 'l',],
	['title' => 'Template', 'name' => 'template', 'size' => 'm',],
	['title' => 'Visibile', 'name' => 'hidden', 'size' => 's', 'switch' => ['NO', 'SI']],

	['type' => 'btn'],
];

//buttons
$buttons = [
	['type' => 'edit'],
	['type' => 'delete'],
];