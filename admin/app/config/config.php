<?php

$rootPath = dirname(__DIR__, 3);

require_once $rootPath . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->safeLoad();

global $sysData;

$sysData = [

	//General settings
	'static' => false,
	'timezone' => 'Europe/Rome',

	//E-mail
	'mail-host' => $_ENV['MAIL_HOST'] ?? '',
	'mail-username' => $_ENV['MAIL_USERNAME'] ?? '',
	'mail-password' => $_ENV['MAIL_PASSWORD'] ?? '',

	//Name
	'name' => 'Bottega delle Erbe',
	'name-full' => 'La Bottega delle Erbe',
	'desc-it' => '',
	'desc-shr-it' => 'Erboristeria Predazzo',
	'desc-en' => '',
	'desc-shr-en' => 'Erboristeria Predazzo',
	'desc-pt' => '',
	'desc-shr-pt' => 'Erboristeria Predazzo',

	//Language
	'lang' => 'it',
	'lang-all' => [['Italiano', 'it'], ['English', 'en']],
	'multi-lang' => false,

	//Logo
	'logo' => '/app/resources/logo/logo.jpg',

	//Business data
	'VAT' => '01317350229',

	//Contacts
	'cont-fb' => '',
	'cont-fb-link' => 'https://www.facebook.com/La-Bottega-Delle-Erbe-1613952845505325',
	'cont-inst' => '',
	'cont-inst-link' => '',
	'cont-yt' => '',
	'cont-sp' => '',
	'cont-tw' => '',
	'cont-mail' => 'info@bottegadelleerbe.com',
	'cont-mail-link' => 'mailto:info@bottegadelleerbe.com',
	'cont-tel' => '',
	'cont-whats' => '',
	'cont-tel' => '0462 502484',
	'cont-tel-link' => 'tel:0462502484',
	'cont-tele' => '',
	'cont-pin' => '',
	'cont-pin-link' => '',
	'cont-tiktok' => '',
	'cont-tiktok-link' => '',
	'cont-address' => 'Via IX Novembre, 8,<br>38037 Predazzo (TN)',

	//Third party integrations
	'google-analytics' => false,
	'facebook-pixel' => false,

	//Styling
	'c1' => '#1d3a35',
	'c1-hover' => '#2F5C54',
	'c2' => '#4a9f88',
	'c3' => '#c89542',
	'c4' => '#5c3814',

	'main-font-name' => 'Raleway',
	'main-font-url' => 'Raleway:wght@100;300;400;500;600;700',
	'side-font-name' => 'Playfair Display',
	'side-font-url' => 'Playfair+Display:ital@0;1',
	'text-font-name' => 'Open Sans',
	'text-font-url' => 'Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400',

];

//local server settings
$sysData['hostname'] = $_ENV['DB_HOST'] ?? 'localhost';
$sysData['database'] = $_ENV['DB_DATABASE'] ?? '';
$sysData['username'] = $_ENV['DB_USERNAME'] ?? '';
$sysData['password'] = $_ENV['DB_PASSWORD'] ?? '';