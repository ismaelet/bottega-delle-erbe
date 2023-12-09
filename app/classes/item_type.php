<?php

class Type {

	public $id;
	public $tag = false;
	public $name; public $names;
	public $category;

	function __construct($tag) {

		$this->tag = $tag;

		if ($tag && $row = DB::row('* FROM items_types WHERE tag=?', [$tag])) {

			$this->tag = $row['tag'];
			$this->name = $row['name'];
			$this->names = $row['names'];
			$this->category = $row['category'];
		}
	}
}