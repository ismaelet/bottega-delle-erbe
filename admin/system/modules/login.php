<?php

//normal login
function login($username, $password, $url = false, $remember = false) {

	global $user;

	//fetch user data
	$row = DB::row('id, password FROM users WHERE (username=? || mail=?) AND guest=0', [$username, $username]);

	if ($row) {

		$id = $row['id'];
		$dbPassword = $row['password'];

		//update old passwords
		if ($dbPassword[0] != '$' && ($password == $dbPassword || md5($password) == $dbPassword)) {
			
			$dbPassword = password_hash($password, PASSWORD_DEFAULT);
			DB::update('users SET password=? WHERE id=?', [$dbPassword, $id]);
			
		}

		//login if the password is correct
		if (password_verify($password, $dbPassword)) {

			//remove old accesses
			DB::delete('auth_tokens WHERE expiration < NOW() AND userID=?', [$id]);

			//set redirect location
			if (!$url) $url = sysData('logged-redirect');

			//remember me
			if ($remember) {
				
				$selector = bin2hex(random_bytes(6));
				$validator = bin2hex(random_bytes(12));
				$validatorHash = hash('sha256', $validator);

				DB::add('auth_tokens (selector, validator, userID, expiration) VALUES (?, ?, ?, (NOW() + INTERVAL 1 MONTH))', [$selector, $validatorHash, $id]);

				setcookie('auth_token', $selector . '_' . $validator, time() + 60 * 60 * 24 * 30);

			}

			//transfer session cart data to user if set
			if ($user->id && DB::table('ecommerce_carts')) {

				$tempCart = DB::row('id, quantity, tot FROM ecommerce_carts WHERE buyerID=? AND status=0', [$user->id]);

				if ($tempCart) {

					$userCartId = DB::find('id FROM ecommerce_carts WHERE buyerID=? AND status=0', [$id]);

					//if the user has a cart transfer the session orders to it
					if ($userCartId) {

						DB::update('ecommerce_orders SET cartId=? WHERE cartId=?', [$userCartId, $tempCart['id']]);
						DB::update('ecommerce_carts SET quantity=quantity+?, tot=tot+? WHERE cartId=?', [$tempCart['quantity'], $tempCart['tot'], $userCartId]);
						DB::delete('ecommerce_carts WHERE id=?', [$tempCart['id']]);

					//otherwise convert the session cart to the user cart
					} else {

						DB::update('ecommerce_carts SET buyerID=? WHERE id=?', [$id, $tempCart['id']]);
						DB::update('ecommerce_orders SET buyerID=? WHERE cartId=?', [$id, $tempCart['id']]);

					}

				}

			}

			//login
			$_SESSION['user'] = $id;

			if (isset($_SESSION['login_attempts'])) unset($_SESSION['login_attempts']);

			//redirect
			redirect($url);

		}

	}

	if (isset($_SESSION['login_attempts'])) $_SESSION['login_attempts']++;
	else $_SESSION['login_attempts'] = 1;

	return 'error_wrong';

}

//direct login
function login_direct($token) {

	$validToken = false;

	$token = explode('_', $token);

	$selector = $token[0];

	if (isset($token[1]) && $row = DB::row('userID, validator FROM auth_tokens WHERE selector=? AND expiration>NOW()', [$selector])) {

		$validator = $token[1];
		$validatorHash = hash('sha256', $validator);

		if (hash_equals($validatorHash, $row['validator'])) {

			//login
			$id = $row['userID'];

			DB::update('auth_tokens SET expiration=(NOW() + INTERVAL 1 MONTH) WHERE userID=?', [$id]);

			setcookie('auth_token', $selector . '_' . $validator, time() + 60 * 60 * 24 * 30);

			$_SESSION['user'] = $id;

			$validToken = true;

			//remove old accesses
			DB::delete('auth_tokens WHERE expiration < NOW() AND userID=?', [$id]);

		}

	}

	if (!$validToken) setcookie('auth_token', null, -1, "/");

}

//generate a guest account
function guest_login() {

	global $user;

	$id = DB::add('users (guest) VALUES (1)');

	$_SESSION['user'] = $id;

	$user = new User($id);

	return $id;

}