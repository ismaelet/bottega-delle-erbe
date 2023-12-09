<?php

class Shop_setup extends Shop {

	function setup_Shop() {

		$searchSQL = $typeSQL = $useSQL = $gendSQL = $groupSQL = $tagSQL = '';
		
		//general filters
		$filtSQL = ' status=1 AND type IN (SELECT tag FROM items_types WHERE category="product") ';

		$start = $this->page ? $this->size * ($this->page - 1) : 1;

		if ($this->sort == 'new') $order = ' ID DESC ';
		else if ($this->sort == 'pop') $order = ' rsales DESC, sales DESC, name ASC ';
		else if ($this->sort == 'cus') $order = ' sort ASC ';

		//filter by keyword
		if ($this->search) {

			$searchSQL = "
				AND (
					name LIKE '%$this->search%' OR
					type IN (SELECT tag FROM items_types WHERE name LIKE '%$this->search%' OR names LIKE '%$this->search%') 
				)
			";
		}

		//filters by type
		if ($this->type) {

			$res_type = DB::select('ID FROM items_types WHERE tag=?', [$this->type]);

			if ($row_type = $res_type->fetch_assoc()) {

				$typeID = $row_type['ID'];
				$typeSQL = "AND type='$this->type'";
			}
		}

		//filters by use
		if ($this->use) {

			$res_use = DB::select('id FROM items_uses WHERE tag=?', [$this->use]);

			if ($row_use = $res_use->fetch_assoc()) {

				$useID = $row_use['id'];
				$useSQL = "AND uses LIKE '%$this->use%'";
			}
		}

		//filters by gender
		if (in_array($this->gender, ['m', 'f'])) {

			$res_gender = DB::select('ID FROM items_genders WHERE tag=?', [$this->gender]);

			if ($row = $res_gender->fetch_assoc()) {

				$gendID = $row['ID'];
				$gendSQL = "AND typeID IN (SELECT ID FROM items_types WHERE gender=$gendID OR gender=3)";
			}
		}

		//filters by group
		if ($this->group) {

			$groupSQL = "AND typeID IN (SELECT ID FROM items_types WHERE category='$this->group')";
		}

		//filter by tag
		if ($this->tag) {
			$tagSQL = "AND desID IN (SELECT desID FROM designs_tags WHERE tags LIKE '%$this->tag%')";
		}

		//get items
		$where = $filtSQL." ".$searchSQL." ".$typeSQL." ".$useSQL." ".$gendSQL." ".$groupSQL." ".$tagSQL;
		$limit = $start.', '.$this->size;

		$sql = "ID FROM items WHERE type NOT IN (SELECT tag FROM items_types WHERE category='herb') AND ".$where." ORDER BY ".$order." LIMIT ".$limit;

		$this->seed = DB::select($sql);

		//get item number
		$this->resN = DB::count('items WHERE '.$where);
	 }
 }