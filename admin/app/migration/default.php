<?php

//menu categories table
if (!$con->query('SELECT 1 FROM admin_categories')) {


	$con->query("
		CREATE TABLE admin_categories (

			id INT(3) AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(30),
			slug VARCHAR(15),
			manager TINYINT(1) DEFAULT 0

		)
	");

	$con->query("INSERT INTO admin_categories (name, slug, manager) VALUES ('Impostazioni', 'settings', 1)");

}

//menu sections table
if (!$con->query('SELECT 1 FROM admin_sections')) {

	$con->query("
		CREATE TABLE admin_sections (

			id INT(4) AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(50),
			slug VARCHAR(30),
			category VARCHAR(15),
			template VARCHAR(10) DEFAULT 'admin',
			hidden TINYINT(1) DEFAULT 0,
			url VARCHAR(30) DEFAULT ''

		)
	");

	$con->query("INSERT INTO admin_sections (name, slug, category) VALUES ('Generali', 'general', 'settings')");
	$con->query("INSERT INTO admin_sections (name, slug, category, template) VALUES ('Menu - Categorie', 'categories/list', 'settings', 'list')");
	$con->query("INSERT INTO admin_sections (name, slug, category, template, hidden) VALUES ('Aggiungi a Menu - Categorie', 'categories/add', 'settings', 'form', 1)");
	$con->query("INSERT INTO admin_sections (name, slug, category, template) VALUES ('Menu - Sezioni', 'sections/list', 'settings', 'list')");
	$con->query("INSERT INTO admin_sections (name, slug, category, template, hidden) VALUES ('Aggiungi a Menu - Sezioni', 'sections/add', 'settings', 'form', 1)");

}

//authentication table
$con->query("
	CREATE TABLE IF NOT EXISTS auth_tokens_admin (

		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		selector VARCHAR(12),
		validator VARCHAR(64),
		userID INT(11),
		expiration TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP()

	)
");