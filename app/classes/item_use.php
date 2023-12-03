<?php

class Uses {

	public $id;
	public $tag = false;
	public $name;

	function __construct($tag) {

		$this->tag = $tag;

		if ($tag && $row = DB::row('* FROM items_uses WHERE tag=?', [$tag])) {

			$this->tag = $row['tag'];
			$this->name = $row['name'];

		}
	}
}