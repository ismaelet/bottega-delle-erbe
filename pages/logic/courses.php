<?php

//theme
$this->set('theme_floating', true);

//get variables
$page = $_GET['page'] ?? 1;

//setup variables
$size = 5;
$start = ($page - 1) * $size;
$pageN = ceil(DB::count('courses') / $size);

//fetch courses
$courses = DB::select('* FROM courses ORDER BY id DESC LIMIT ?, ?', [$start, $size]);

//store variables
$this->set('courses', $courses);
$this->set('page', $page);
$this->set('pageN', $pageN);