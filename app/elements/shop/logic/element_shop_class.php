<?php

class Shop {
	
	public $id = 0;
	public $seed = 0;
	public $resN = 0;
	public $size = 40;
	public $search = '';
	public $type = false;
	public $use = false;
	public $gender = false;
	public $group = false;
	public $tag = false;
	public $sort = 'pop';
	public $page = 1;
	public $edit = false;

	function __construct() {
		if (isset($_GET['id'])) $this->id = $_GET['id'];
		if (isset($_GET['search'])) $this->search = trim(strtolower($_GET['search']));
		if (isset($_GET['type'])) $this->type = $_GET['type'];
		if (isset($_GET['use'])) $this->use = $_GET['use'];
		if (isset($_GET['gender'])) $this->gender = $_GET['gender'];
		if (isset($_GET['group'])) $this->group = $_GET['group'];
		if (isset($_GET['tag'])) $this->tag = $_GET['tag'];
		if (isset($_GET['page'])) $this->page = $_GET['page'];
		if (isset($_GET['edit']) && admin()) $this->edit = true;

		//set sorting
		if (isset($_GET['sort'])) $this->sort = $_GET['sort'];
		else if ($this->id) {

			switch (DB::find('sort FROM stores WHERE userID=?', $this->id)) {

				case 3: $this->sort = 'cus'; break;
				case 2: $this->sort = 'new'; break;
				default: $this->sort = 'pop'; break;
			}
		}
	}
}