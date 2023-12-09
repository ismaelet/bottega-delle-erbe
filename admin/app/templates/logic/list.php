<?php

//load logic
$this->add_logic('admin', 'template');

$this->styles->add(__ROOT__.'/app/templates/styles/list.css');
$this->scripts->add(__ROOT__.'/app/templates/scripts/list.js');

require_once(__ROOT__.'/pages/logic/'.$this->name.'.php');

//delete entry
if (isset($_POST['delete'])) {
	
	DB::delete($tbl.' WHERE '.$index.'=?', [$_POST[$index]]);
	
}

//setup variables
$values = [];

$pageN = $_GET['page'] ?? 1;

$query['add'] = $add ?? true;
$query['block'] = $query['block'] ?? 50;
$query['from'] = ($pageN - 1) * $query['block'];
$query['fields'] = $query['fields'] ?? '*';

if (isset($_GET['index'])) $query['index'] = $_GET['index'];
else $query['index'] = $query['index'] ?? $index;

if (isset($_GET['order'])) $query['order'] = $_GET['order'];
else $query['order'] = $query['order'] ?? 'desc';

//search
$search = isset($_GET['search']) ? trim($_GET['search']) : false;

if ($search) {

	$query['filter'] = 'WHERE '.$query['filter'];
	for ($i = 0; $i < substr_count($query['filter'], '?'); $i++) $values[] = $search;

} else $query['filter'] = '';	

//limit
$query['limit'] = 'LIMIT '.$query['from'].', '.$query['block'];

//query
$query_limit = $query['fields'].' FROM '.$tbl.' '.$query['filter'].' ORDER BY '.$query['index'].' '.strtoupper($query['order']).' '.$query['limit'];
$query_all = $tbl.' '.$query['filter'];

$res = DB::select($query_limit, $values);

$resultsN = DB::count($query_all, $values);
$pagesN = ceil($resultsN / $query['block']);

include_once('list/results.php');

//store variables
$this->set('index', $index);
$this->set('query', $query);
$this->set('search', $search);
$this->set('results', $results);
$this->set('fields', $fields);
$this->set('buttons', $buttons);
$this->set('pageN', $pageN);
$this->set('pagesN', $pagesN);