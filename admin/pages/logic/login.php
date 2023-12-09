<?php

//setup variabiles
$error = false;

//load modules
load_module('login');

//login
if (isset($_POST['submit'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	echo $error = login($username, $password);
	
}

//store variables
$this->set('error', $error);