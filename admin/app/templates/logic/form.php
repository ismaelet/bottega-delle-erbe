<?php

//load template parts
load_module('form');

//get id
$id = $_GET['id'] ?? false;

//style
$this->styles->add(__ROOT__.'/app/templates/styles/form.css');

//load logic
$this->add_logic('admin', 'template');
require_once(__ROOT__.'/pages/logic/'.$this->name.'.php');

//setup variables
$error = $error ?? false;
$done = $done ?? false;
$inputs = $inputs ?? false;
$page['free'] = $free ?? false;
$page['edit'] = $id ? true : false;
$page['upload'] = $upload ?? false;
$page['confirmation'] = $confirmation ?? false;
$url_query = explode('&', $_SERVER['REQUEST_URI'], 2)[1] ?? '';
$page['back_url'] = $back_url ?? 'list?'.$url_query;

//fetch data
if ($page['edit']) $entry = $entry ?? DB::row('* FROM '.$tbl.' WHERE '.$index.'=?', [$id]);
else $entry = false;

//setup title
if ($page['edit']) $page['title'] = 'Modifica: '.$entry[$index_show];
else $page['title'] = $title ?? $this->title;

//add
if (isset($_POST['add'])) {

	if (function_exists('expand_add')) $error = expand_add($tbl, $inputs);
	else form_db_add($tbl, $inputs);

	if (!$error) header('Location: '.$page['back_url']);

}

//edit
if (isset($_POST['edit'])) {

	if (function_exists('expand_edit')) $error = expand_edit($tbl, $inputs, $index, $id);
	else form_db_update($tbl, $inputs, $index, $id);

	if (!$error) header('Location: '.$page['back_url']);

}

//store variables
$this->set('page', $page);
$this->set('entry', $entry);
$this->set('inputs', $inputs);
$this->set('error', $error);
$this->set('done', $done);