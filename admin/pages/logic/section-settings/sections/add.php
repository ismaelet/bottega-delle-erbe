<?php

//setup page
$tbl = 'admin_sections';
$index = 'id';
$index_show = 'name';

//form
$inputs = [
	[
		'type' => 'text',
		'name' => 'name',
		'lbl' => 'Titolo',
	],
	[
		'type' => 'text',
		'name' => 'slug',
		'lbl' => 'Slug',
	],
	[
		'type' => 'select',
		'name' => 'category',
		'lbl' => 'Categoria',
		'query' => '* FROM admin_categories ORDER BY manager ASC, name ASC',
		'field_id' => 'slug',
		'field_show' => 'name',
	],
	[
		'type' => 'text',
		'name' => 'url',
		'lbl' => 'URL',
	],
	[
		'type' => 'text',
		'name' => 'template',
		'lbl' => 'Template',
	],
	[
		'type' => 'cbx',
		'name' => 'hidden',
		'lbl' => 'Nascosto',
		'txt' => 'non apparirà nel menu laterale',
	],
];