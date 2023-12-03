<?php

//theme
$this->set('theme_floating', true);

//get variables
$page = $_GET['page'] ?? 1;

//setup variables
$size = 12;
$start = ($page - 1) * $size;
$pageN = ceil(DB::count('posts') / $size);

//fetch posts
$posts = DB::select('* FROM posts ORDER BY time DESC LIMIT ?, ?', [$start, $size]);

//store variables
$this->set('posts', $posts);
$this->set('page', $page);
$this->set('pageN', $pageN);