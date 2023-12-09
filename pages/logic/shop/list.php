<?php

//setup variables
$items = DB::select('id FROM items WHERE type IN (SELECT tag FROM items_types WHERE category="product") ORDER BY name ASC');

//store variables
$this->set('items', $items);
$this->set('letter', '');