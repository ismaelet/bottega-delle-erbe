<?php

function logout() {

	global $user;

	setcookie('auth_token', null, -1);

	DB::delete('auth_tokens WHERE userID=?', $user->id);

	session_destroy();
	
	redirect('');
}