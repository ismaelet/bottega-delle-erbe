<?php

//setup page
$this->template = 'main';

//setup variabiles
$error = false;

//load modules
load_module('login');

//login
if (isset($_POST['submit'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$remember = isset($_POST['remember']);
	$url = $_POST['url'] ?? false;

	$error = login($username, $password, $url, true);
}

//store variables
$this->set('error', $error);