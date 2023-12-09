<?php

//get variables
$id = $_GET['id'] ?? false;

//fetch course data
$course = DB::row('* FROM courses WHERE id=?', $id);

if (!$course) redirect('courses');

$this->title($course['title']);

//fetch more courses
$coursesM = DB::select('* FROM courses WHERE id<>? ORDER BY id DESC LIMIT 4', $id);

//store variables
$this->set('course', $course);
$this->set('coursesM', $coursesM);