<?php

$this->styles->add(__ROOT__.'/app/templates/styles/footer.css');

//elements
$f_comp['logo'] = false;
$f_comp['contacts'] = true;

//links
$f_cols = [
	[
		'title' => 'Esplora',
		'links' => [
			['Contatti', 'contacts'],
			['Corsi', 'courses'],
			['Novità', 'blog'],
		]
	],
	[
		'title' => 'Prodotti',
		'links' => [
			['Negozio', 'shop'],
			['Piante', 'herbs'],
			['Tisane', 'herbs#hte'],
			['Infusi e altro', 'herbs#inf'],
		]
	],
];

//contacts
$f_contacts = ['mail', 'call', 'fb', 'inst', 'addr'];