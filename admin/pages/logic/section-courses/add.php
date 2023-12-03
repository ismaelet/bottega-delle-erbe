<?php

//setup page
$tbl = 'courses';
$index = 'id';
$index_show = 'title';

//form
$inputs = [
	[
		'name' => 'title',
		'lbl' => 'Nome',
		'required' => true,
	],
	[
		'type' => 'textarea',
		'name' => 'text',
		'lbl' => 'Testo',
		'max' => 4000,
	],
	[
		'name' => 'schedule',
		'lbl' => 'Giorni e orario',
		'required' => true,
	],
];

if ($id) $inputs[] = ['type' => 'file', 'name' => 'file', 'lbl' => 'Immagine (opzionale)',];
else $inputs[] = ['type' => 'file', 'name' => 'file', 'lbl' => 'Immagine'];

//submit
function expand_add($tbl, $inputs) {

	$id = form_db_add($tbl, $inputs);

	$error = upload_post_img($id);

	return $error;
	
}

//edit
function expand_edit($tbl, $inputs, $index, $id) {

	form_db_update($tbl, $inputs, $index, $id);

	$error = upload_post_img($id);

	return $error;

}

//upload image
function upload_post_img($id) {

	$error = false;

	if (!empty($_FILES['file']['tmp_name'])) {

		//upload HD
		$file_data = [
			'url' => __DROOT__.'/uploads/courses/' . $id . '.jpg',
			'size' => 1920,
		];

		$error = upload_img($file_data);

		//upload MD
		if (!$error) {

			$file_data = [
				'url' => __DROOT__.'/uploads/courses/' . $id . '_m.jpg',
				'size' => 800,
				'quality' => 70,
			];

			$error = upload_img($file_data);

		}

	}

	return $error;

}