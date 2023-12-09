<?php

//setup page
$tbl = 'items';
$index = 'id';

//form
$inputs = [
	[
		'type' => 'file',
		'name' => 'file',
		'lbl' => 'File CSV',
		'required' => true,
	],
	[
		'type' => 'error',
		'error' => 'file-type',
		'txt' => 'Il file deve essere un CSV',
	],
	[
		'type' => 'cbx',
		'name' => 'update',
		'txt' => 'È solo un aggiornamento',
		'checked' => true,
	],
	[
		'type' => 'error',
		'error' => 'no-match',
	],
	
];

//submit
function expand_add($tbl, &$inputs) {

	//setup variables
	$update = $_POST['update'] ?? false;

	//get file content
	$file = file($_FILES['file']['tmp_name']);

	//remove the first row if it's a description
	if (strtolower(substr(explode(';', $file[0])[0], 0, 4)) == 'nome') array_shift($file);

	//check if the file is a csv
	$csv_mimetypes = ['text/csv', 'text/plain', 'application/csv', 'text/comma-separated-values', 'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel', 'text/anytext', 'application/octet-stream', 'application/txt',];

	if (in_array($_FILES['file']['type'], $csv_mimetypes)) {

		$errors = [];

		//process rows
		foreach ($file as $row) {
			
			$row = explode(';', $row);

			$entry['name'] = ucfirst(strtolower($row[0]));

			if (!empty($entry['name'])) {

				$fields = [];
				$values = [];
				$placeholders = [];

				$entry['type'] = $row[1];
				$entry['tech'] = $row[2];
				$entry['info'] = $row[3];
				$entry['methods'] = $row[4];
				$entry['ingredients'] = $row[5];
				$entry['warnings'] = $row[6];
				$entry['price'] = format(str_replace(',', '.', $row[7]));

				$entry['id'] = DB::find('id FROM items WHERE name=?', [$entry['name']]);

				//setup query
				foreach ($entry as $field => $value) {

					if ($field != 'id' && (!$entry['id'] || ($field != 'name' && $field != 'type')) && (!$update || !empty($value))) {
						$fields[] = $entry['id'] ? $field.'=?' : $field;
						$values[] = $value;
						$placeholders[] = '?';
					}

				}

				if ($entry['id']) $values[] = $entry['id'];

				$fields = implode(',', $fields);
				$placeholders = implode(',', $placeholders);

				//update
				if ($entry['id']) DB::update('items SET '.$fields.' WHERE id=?', $values);

				//check for errors in case of update only
				else if ($update) $errors[] = $entry['name'];

				//add
				else {
					DB::add('items ('.$fields.') VALUES ('.$placeholders.')', $values);
				}

			}

		}

		//log missing entries in case of update
		if (!empty($errors)) {

			$inputs[3]['txt'] = count($errors) > 1 ? implode(' non esiste<br>', $errors) : implode('', $errors).' non esiste';

			return 'no-match';

		}

	}  else return 'file-type';

}