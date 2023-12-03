<?php

//get variables
$id = $_GET['id'] ?? false;

//fetch post data
$post = DB::row('* FROM posts WHERE id=?', $id);

if (!$post) redirect('blog');

$this->title($post['title']);

//fetch more posts
$postsM = DB::select('* FROM posts WHERE id<>? ORDER BY time DESC LIMIT 3', $id);

//store variables
$this->set('post', $post);
$this->set('postsM', $postsM);