<?php

//get variables
$id = isset($_GET['id']) ? (int) $_GET['id'] : false;

//redirect if not found
if (!DB::exists('items WHERE id=?', [$id])) redirect('shop');

//setup variables
$promo = false;

$item = new Item($id, ['*']);

$this->title = $item->name;

//add order
if (isset($_POST['submit'])) {

	$data = [
		'itemId' => $item->id,
		'price' => $item->price,
		'quantity' => $_POST['quantity'],
	];

	Cart::add($data);

}

//store variables
$this->set('item', $item);
$this->set('promo', $promo);