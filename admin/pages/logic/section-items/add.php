<?php

//setup page
$tbl = 'items';
$index = 'id';
$index_show = 'name';

//form
$inputs = [
	[
		'type' => 'text',
		'name' => 'name',
		'lbl' => 'Nome',
		'required' => true,
	],
	[
		[
			'type' => 'select',
			'name' => 'type',
			'lbl' => 'Tipo',
			'query' => '* FROM items_types ORDER BY name ASC',
			'field_id' => 'tag',
			'field_show' => 'name',
		],
		[
			'type' => 'text',
			'name' => 'tech',
			'lbl' => 'Dati tecnici (opzionale)',
		],
	],
	[
		[
			'type' => 'textarea',
			'name' => 'info',
			'lbl' => 'Descrizione (opzionale)',
		],
		[
			'type' => 'textarea',
			'name' => 'ingredients',
			'lbl' => 'Ingredienti (opzionale)',
		],
	],
	[
		[
			'type' => 'textarea',
			'name' => 'methods',
			'lbl' => "Modi d'uso (opzionale)",
		],
		[
			'type' => 'textarea',
			'name' => 'warnings',
			'lbl' => 'Avvertenze (opzionale)',
		],
	],
	[
		'type' => 'number',
		'step' => .01,
		'name' => 'price',
		'lbl' => 'Prezzo (usare punto, non virgola)',
		'pholder' => 'Prezzo',
	],
	[
		'type' => 'none',
		'lbl' => 'Esigenze',
	],
];

//uses
$start = 0;
$step = 4;
$blocks = ceil(DB::count('items_uses') / $step);

for ($i = 1; $i <= $blocks; $i++) {

	$fields = [];

	$uses = DB::select('* FROM items_uses ORDER BY id ASC LIMIT ?, ?', [$start, $step]);

	while ($use = $uses->fetch_assoc()) {

		$input = [
			'type' => 'cbx',
			'name' => 'use[]',
			'val' => $use['tag'],
			'ignore' => true,
			'txt' => $use['name'],
		];

		if ($id && DB::exists("items WHERE id=? AND uses LIKE CONCAT('%',?,'%')", [$id, $use['tag']])) $input['checked'] = true;

		$fields[] = $input;

	}

	$inputs[] = $fields;

	$start += $step;

}

//images
if ($id) $inputs[] = ['type' => 'file', 'name' => 'file', 'lbl' => 'Immagine (opzionale)',];
else $inputs[] = ['type' => 'file', 'name' => 'file', 'lbl' => 'Immagine'];

//submit
function expand_add($tbl, $inputs) {

	$id = form_db_add($tbl, $inputs);

	DB::update('items SET uses=? WHERE id=?', [implode(',', $_POST['use']), $id]);

	$error = upload_item_img($id);

	return $error;
	
}

//edit
function expand_edit($tbl, $inputs, $index, $id) {

	$typeOld = DB::find('type FROM items WHERE id=?', [$id]);
	$typeNew = $_POST['type'];

	if (empty($_FILES['file']['tmp_name']) && $typeNew <> $typeOld) {

		$folder = __DROOT__.'/uploads/items/'.$typeNew;

		if (!file_exists($folder)) mkdir($folder, 0777, true);

		$file = __DROOT__.'/uploads/items/'.$typeOld.'/'.$id.'.jpg';
		if (file_exists($file)) rename($file, $folder.'/'.$id.'.jpg');

		$file = __DROOT__.'/uploads/items/'.$typeOld.'/'.$id.'_m.jpg';
		if (file_exists($file)) rename($file, $folder.'/'.$id.'_m.jpg');

	}

	form_db_update($tbl, $inputs, $index, $id);

	DB::update('items SET uses=? WHERE id=?', [implode(',', $_POST['use']), $id]);

	$error = upload_item_img($id);

	return $error;

}

//upload image
function upload_item_img($id) {

	$error = false;

	if (!empty($_FILES['file']['tmp_name'])) {

		//upload HD
		$file_data = [
			'url' => __DROOT__.'/uploads/items/'.$_POST['type'].'/'.$id.'.jpg',
			'size' => 1024,
		];

		$error = upload_img($file_data);

		//upload MD
		if (!$error) {

			$file_data = [
				'url' => __DROOT__.'/uploads/items/'.$_POST['type'].'/'.$id.'_m.jpg',
				'size' => 450,
				'quality' => 70,
			];

			$error = upload_img($file_data);

		}

	}

	return $error;

}