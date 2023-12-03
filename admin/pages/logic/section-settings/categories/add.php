<?php

//setup page
$tbl = 'admin_categories';
$index = 'id';
$index_show = 'name';

//form
$inputs = [
	[
		'type' => 'text',
		'name' => 'name',
		'lbl' => 'Nome',
	],
	[
		'type' => 'text',
		'name' => 'slug',
		'lbl' => 'Slug',
	],
];

//edit
function expand_edit($tbl, $inputs, $index, $id) {

	$old = DB::find('slug FROM admin_categories WHERE id=?', $id);

	DB::update('admin_categories SET name=?, slug=? WHERE ID=?', [$_POST['name'], $_POST['slug'], $id]);
	DB::update('admin_sections SET category=? WHERE category=?', [$_POST['slug'], $old]);

	if (file_exists($file = __ROOT__.'/app/resources/icons/navigation/'.$old.'.svg')) rename($file, __ROOT__.'/app/resources/icons/navigation/'.$_POST['slug'].'.svg');

}