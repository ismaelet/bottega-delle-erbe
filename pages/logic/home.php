<?php

//theme
$this->set('theme_color', 'dark');
$this->set('theme_floating', true);

//setup variables
$res_items = DB::select('ID FROM items WHERE status=1 AND hidden=0 AND type NOT IN (SELECT tag FROM items_types WHERE category="herb") ORDER BY ID DESC LIMIT ?', 20);
$res_posts = DB::select('* FROM posts ORDER BY time DESC LIMIT ?', 6);

$highlightedProduct = new Item(413);
