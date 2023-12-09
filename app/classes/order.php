<?php

class Order {

	public $id;

	public $item;

	public $sizeID;
	public $genderID;
	public $colorID;

	public $quantity;
	public $price;
	public $discount;

	public $text;

	function __construct($id) {

		//set id
		$this->id = $id;

		//fetch data
		if ($row = DB::row('* FROM ecommerce_orders WHERE id=?', [$id])) {

			//set basic data
			$this->price = $row['price'];
			$this->discount = $row['discount'];
			$this->quantity = $row['quantity'];

			//set objects
			$this->item = new Item($row['itemID'], ['name', 'type']);
			//$this->colorID = new Color($row['colorID']);
			//$this->genderID = new Gender($row['genderID']);
			//$this->sizeID = new Size($row['sizeID']);

			//run construct functions
			$this->text();
		}
	}

	private function text() {

		//size
		if (isset($this->size)) $size = DB::find('name FROM items_sizes WHERE id=?', [$this->sizeID]);

		//generate normal text
		$text = $this->item->name;
		$text .= ' (' . $this->item->type->name;
		if (isset($this->genderID) && count($this->item->type->genders) > 1) $text .= ' ' . $this->item->gender->name;
		if (isset($this->sizeID) && count($this->item->type->sizes) > 1) $text .= ' ' . $size;
		if (isset($this->colorID) && count($this->item->type->colors) > 1) $text .= ' ' . $this->item->color->name;
		$text .= ')';

		$texts[] = $text;

		//generate long text
		$text = $this->item->type->name;
		if (isset($this->genderID) && count($this->item->type->genders) > 1) $text .= ' - ' . $this->item->gender->name;
		$text .= '<br>';
		if (isset($this->sizeID)) $text .= 'Taglia: ' . $size . '<br>';
		if (isset($this->colorID) && $this->item->color->name) $text .= 'Colore: ' . $this->item->color->name . '<br>';

		$texts[] = $text;

		$this->text = $texts;
	}
}
