<?php

class User {

	public $id;
	public $username;
	public $fname;
	public $lname;
	public $mail;
	public $admin = false;
	public $guest = true;

	function __construct($id) {

		$this->id = $id;

		if ($row = DB::row('username, firstname, lastname, mail, admin FROM users WHERE id=? AND guest=0', [$id])) {

			$this->username = $row['username'] ?? null;
			$this->fname = $row['firstname'] ?? null;
			$this->lname = $row['lastname'] ?? null;
			$this->mail = $row['mail'] ?? null;
			$this->admin = $row['admin'] ?? false;
			$this->guest = false;

		}

	}

	function __get($name) {

		switch($name) {
			case 'icon': return $this->icon = $this->icon();
		}

	}

	//get the profile icon
	private function icon() {

		$icon = '/uploads/profile-icons/' . $this->id . '.jpg';

		if (!file_exists(__ROOT__ . $icon)) $icon = '/uploads/profile-icons/0.jpg';

		return $icon;

	}

}