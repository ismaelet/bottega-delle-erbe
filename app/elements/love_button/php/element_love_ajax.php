<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/system/setup/setup.php');

$id = $_POST['id'];
$loved = $_POST['loved'];

DB::delete('feed WHERE srcID=? AND objectID=?', [$user->id, $id]);

if ($loved) DB::delete('likes WHERE userID=? AND desID=?', [$user->id, $id]);

else if (!DB::exists('likes WHERE userID=? AND desID=?', [$user->id, $id])) {

	$likeID = DB::add('likes (userID, desID) VALUES (?, ?)', [$user->id, $id]);
	
	$sellID = DB::find('userID FROM designs WHERE id=?', [$id]);

	DB::add('feed (feedID, userID, srcID, objectID, type) VALUES (?, ?, ?, ?, ?)', [$likeID, $sellID, $user->id, $id, 3]);
}
