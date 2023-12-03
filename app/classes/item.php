<?php

class Item {

	public $id;

	public $name;
	public $type;
	public $price;
	public $priceString;

	public $tech;
	public $infos = [];
	public $description;
	public $ingredients;
	public $warnings;
	public $methods;

	public $url;
	public $img;

	public $status;

	function __construct($id) {

		//set basic data
		$this->id = $id;
		$this->url = __HROOT__ . '/shop/item?id=' . $id;

		//get data
		if ($row = DB::row('* FROM items WHERE id=?', [$id])) {

			//set basic data
			$this->name = $row['name'];
			$this->price = $row['price'];
			$this->priceString = formatc($this->price) . ' €';
			$this->status = $row['status'];

			//data
			$this->tech = str_replace(', ', ' &middot; ', $row['tech']);

			//infos
			$this->description = empty($row['info']) ? false : $row['info'];
			$this->methods = empty($row['methods']) ? false : $row['methods'];
			$this->ingredients = empty($row['ingredients']) ? false : $row['ingredients'];
			$this->warnings = empty($row['warnings']) ? false : $row['warnings'];

			if ($this->description) $this->infos[] = ['Descrizione', $this->description];
			if ($this->methods) $this->infos[] = ['Modi d\'uso', $this->methods];
			if ($this->ingredients) $this->infos[] = ['Sostanze funzionali', $this->ingredients];
			if ($this->warnings) $this->infos[] = ['Avvertenze', $this->warnings];

			//set objects
			$this->type = new Type($row['type']);

			//run construct functions
			$this->image();
		}
	}

	//generate item image url as a background
	private function image() {

		$imgs = [];

		//generate url
		$imgs[] = $main = file_exists(__ROOT__ . $file = '/uploads/items/' . $this->type->tag . '/' . $this->id . '.jpg') ? $file : file_time(__IMG__ . 'items/' . $this->type->tag . '.png');
		$imgs[] = file_exists(__ROOT__ . $file = '/uploads/items/' . $this->type->tag . '/' . $this->id . '.jpg') ? $file : $main;

		$this->img = $imgs;
	}
}
