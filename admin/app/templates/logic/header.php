<?php

$this->styles->add(__ROOT__.'/app/templates/styles/header.css');
$this->scripts->add(__ROOT__.'/app/templates/scripts/header.js');

$user = $this->get('user');

//theme
$h_theme['color'] = 'light';
$h_theme['floating'] = false;
$h_theme['sticky'] = false;

//elements
$h_comp['logo'] = true;
$h_comp['name-bar'] = false;
$h_comp['srch-bar'] = false;
$h_comp['lang-bar'] = true;
$h_comp['login'] = true;
$h_comp['force-mob'] = false;
$h_comp['privacy'] = false;
$h_comp['wishlist'] = false;

//name
$h_name = sysData('name');
$h_name_m = $h_name;

//links
$h_links = [];
$h_links_raw = [];

$h_links_raw[] = ['title' => 'Home', 'loc' => 'home', 'url' => html_link('')];

foreach ($h_links_raw as $link) {

	$valid = true;

	//check logged filter
	if (isset($link['logged'])) {

		if ($link['logged'] && !$user->id) $valid = false;
		else if (!$link['logged'] && $user->id) $valid = false;

	}

	//check admin filter
	if (isset($link['admin']) && !$user->admin) $valid = false;

	//check cart filter
	if (isset($link['cart']) && !order_count()) $valid = false;

	//add it to the list if valid
	if ($valid) $h_links[] = $link;

}

//dropdowns
/*$h_drop['dropdown_name'] = [
	['Title', html_link('link')],
];*/

//login bar
$h_log_out = ['Login', html_link('login')];
if ($user->id) $h_log_in = [$user->username, html_link('profile')];

//store variabiles
$this->set('h_theme', $h_theme);
$this->set('h_comp', $h_comp);
$this->set('h_name', $h_name);
$this->set('h_name_m', $h_name_m);
$this->set('h_links', $h_links);