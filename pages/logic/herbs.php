<?php

//theme
$this->set('theme_floating', true);

//categories
$categories = DB::select('* FROM items_types WHERE category="herb"');

//add order
if (isset($_POST['add'])) {

	$item = new Item($_POST['id']);

	$data = [
		'itemId' => $item->id,
		'price' => $item->price,
		'quantity' => $_POST['quantity'],
	];

	Cart::add($data);

}

//store variables
$this->set('categories', $categories);