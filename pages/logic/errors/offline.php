<?php

load_module('logout');

if (isset($_POST['submit'])) {
	
	if (isset($_SESSION['user'])) logout();
	
	redirect('login');
}