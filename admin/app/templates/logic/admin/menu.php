<?php

//get user
$user = $this->get('user');

//fetch current section
$current_section = false;

if (strpos($this->name, '-')) {

	$current_path = explode('/', explode('section-', str_replace('add', 'list', $this->name))[1], 2);

	$current_section = DB::row('* FROM admin_sections WHERE category=? AND slug=?', [$current_path[0], $current_path[1]]);

}

//fetch categories
$menu['categories'] = [];

$res = DB::select('* FROM admin_categories ORDER BY manager ASC, name ASC');

while ($row = $res->fetch_assoc()) if (!$row['manager'] || manager()) {

	$category = [];

	$category['name'] = $row['name'];
	$category['slug'] = $row['slug'];

	$category['checked'] = $current_section && $category['slug'] == $current_section['category'];

	$res_sections = DB::select('* FROM admin_sections WHERE category=? AND hidden=0 ORDER BY name ASC', [$category['slug']]);

	$category['count'] = $res_sections->num_rows;

	while ($row_section = $res_sections->fetch_assoc()) {

		$section = [];

		$section['name'] = $row_section['name'];

		$section['checked'] = $current_section && $category['checked'] && $row_section['slug'] == $current_section['slug'];

		$section['url'] = empty($row_section['url']) ? html_link($row_section['category'].'/'.$row_section['slug']) : $row_section['url'];

		$category['sections'][] = $section;

	}


	$menu['categories'][] = $category;

}

//store variables
$this->set('menu', $menu);