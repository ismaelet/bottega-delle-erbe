<?php

global $user;

//load resources
$this->styles->add(__ROOT__ . '/app/templates/styles/header.css');
$this->scripts->add(__ROOT__ . '/app/templates/scripts/header.js');

//setup variables
$header = [];
$h_drop = '';

//theme
$theme_color = 'light';
$theme_floating = false;

//elements
$h_comp = [];

$h_comp['logo'] = false;
$h_comp['name-bar'] = false;
$h_comp['srch-bar'] = true;
$h_comp['lang-bar'] = false;
$h_comp['login'] = false;
$h_comp['force-mob'] = false;
$h_comp['privacy'] = false;
$h_comp['wishlist'] = false;

//name
$h_name = 'Bottega <span class="txt-c1">delle</span> Erbe';
$h_name_m = $h_name;

//links
$h_links = [];

$h_links[] = ['title' => 'Home', 'loc' => 'home', 'url' => __HROOT__ . '/'];
$h_links[] = ['title' => 'Carrello (' . order_count() . ')', 'loc' => 'cart', 'url' => __HROOT__ . '/cart', 'cart' => true, 'mob' => true];
//$h_links[] = ['title' => 'Preferiti', 'loc' => 'wishlist', 'url' => __HROOT__.'/w§ishlist', 'logged' => true, 'mob' => true];
$h_links[] = ['title' => 'Login', 'loc' => 'login', 'url' => __HROOT__ . '/login', 'logged' => false, 'mob' => true];
//$h_links[] = ['title' => 'Profilo', 'loc' => 'profile', 'url' => __HROOT__.'/profile', 'logged' => true, 'mob' => true];
$h_links[] = ['title' => 'Prodotti', 'megamenu' => 'shop', 'loc' => 'shop', 'url' => __HROOT__ . '/shop'];
$h_links[] = ['title' => 'Esigenze', 'megamenu' => 'uses', 'loc' => 'shop'];
$h_links[] = ['title' => 'Erbe e Altro', 'loc' => 'herbs', 'url' => __HROOT__ . '/herbs', 'megamenu' => 'herbs'];
$h_links[] = ['title' => 'Corsi', 'loc' => 'courses', 'url' => __HROOT__ . '/courses'];
$h_links[] = ['title' => 'Novità', 'loc' => 'blog', 'url' => __HROOT__ . '/blog'];
$h_links[] = ['title' => 'Contatti', 'loc' => 'contacts', 'url' => __HROOT__ . '/contacts'];
$h_links[] = ['title' => 'Gestione', 'loc' => 'admin', 'url' => '/admin', 'manager' => true];

//dropdowns
$header['megamenus']['shop']['size'] = 4;
$header['megamenus']['shop']['link'] = ['Lista alfabetica', html_link('shop/list')];

$res = DB::select('names, tag FROM items_types WHERE category="product" ORDER BY id ASC');

while ($row = $res->fetch_assoc($res)) {

	$category['title'] = $row['names'];
	$category['link'] = html_link('shop?type=' . $row['tag']);
	$category['list'] = [];

	$links = DB::select('id, name FROM items WHERE type=? ORDER BY name ASC LIMIT 7', [$row['tag']]);

	while ($link = $links->fetch_assoc($res)) $category['list'][] = [$link['name'], html_link('shop/item?id=' . $link['id'])];

	$linksN = DB::count('items WHERE type=?', [$row['tag']]);

	if ($linksN > 7) $category['list'][] = ['<strong>Mostra tutti</strong>', html_link('shop?type=' . $row['tag'])];

	$header['megamenus']['shop']['categories'][] = $category;
}

$header['megamenus']['uses']['size'] = 6;
$header['megamenus']['uses']['link'] = ['Lista alfabetica', html_link('shop/list')];

$res = DB::select('name, tag FROM items_uses ORDER BY id ASC');

while ($row = $res->fetch_assoc($res)) {

	$category['title'] = $row['name'];
	$category['link'] = html_link('shop?use=' . $row['tag']);
	$category['list'] = [];

	$links = DB::select("id, name FROM items WHERE uses LIKE CONCAT('%',?,'%') ORDER BY name ASC LIMIT 5", [$row['tag']]);

	while ($link = $links->fetch_assoc($res)) $category['list'][] = [$link['name'], html_link('shop/item?id=' . $link['id'])];

	$linksN = DB::count("items WHERE uses LIKE CONCAT('%',?,'%')", [$row['tag']]);

	if ($linksN > 5) $category['list'][] = ['<strong>Mostra tutti</strong>', html_link('shop?use=' . $row['tag'])];

	$header['megamenus']['uses']['categories'][] = $category;
}

$header['megamenus']['herbs']['size'] = 5;

$res = DB::select('names, tag FROM items_types WHERE category="herb" ORDER BY id ASC');

while ($row = $res->fetch_assoc($res)) {

	$category['title'] = $row['names'];
	$category['link'] = html_link('herbs#' . $row['tag']);
	$category['list'] = [];

	$category['list'][] = ['Mostra tutti', html_link('herbs#' . $row['tag'])];

	$header['megamenus']['herbs']['categories'][] = $category;
}

//login bar
$h_log_out = array('Login', '/login');
$h_log_in = $user->id ? array($user->username, '/profile') : false;

//store variabiles
$this->set('header', $header);
$this->set('theme_color', $theme_color);
$this->set('theme_floating', $theme_floating);
$this->set('h_comp', $h_comp);
$this->set('h_name', $h_name);
$this->set('h_name_m', $h_name_m);
$this->set('h_links', $h_links);
$this->set('h_log_out', $h_log_out);
$this->set('h_log_in', $h_log_in);
$this->set('h_drop', $h_drop);
