<?php

require_once __DIR__ . '/../../vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'))->load();

//setup global variables
global $user;

//check if to use the lighter version for ajax
$full = $full ?? true;

//set migration status
$migration = false;

//retrive and start session
session_start();

//set constants
define('__ROOT__', explode('/system', str_replace("\\", "/", __DIR__))[0]);
define('__HROOT__', str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/'), '', __ROOT__));
define('__ICON__', '/system/resources/icons/');
define('__IMG__', '/app/resources/images/');
define('__LOGO__', '/app/resources/logo/');

//classes autoloader
spl_autoload_register(function ($class) {

	$class = str_replace('\\', '/', $class);

	if (file_exists($file = __ROOT__ . '/app/classes/' . $class . '.php')) include_once($file);
	else if (file_exists($file = __ROOT__ . '/system/classes/' . $class . '.php')) include_once($file);
	else if (defined('__DROOT__') && file_exists($file = __DROOT__ . '/app/classes/' . $class . '.php')) include_once($file);
});

include_once(__ROOT__ . '/app/config/config.php');

if (!isset($sysData['admin-domain'])) $sysData['admin-domain'] = $sysData['public-domain'] . 'admin';
if (!isset($sysData['logged-redirect'])) $sysData['logged-redirect'] = '/';

date_default_timezone_set($sysData['timezone']);

//connect
if (!$sysData['static']) {
	$con = new mysqli($sysData['hostname'], $sysData['username'], $sysData['password'], $sysData['database']) or exit('Can\'t connect to the database');
	$con->query('SET NAMES utf8');
}

//load basic resources
include_once('migration.php');
include_once('classes.php');
include_once('modules.php');
include_once('functions.php');

if ($full) {

	include_once('middlewares.php');
	foreach (scan('/app/routes', 'php') as $route) include_once($route);
}

//recover login
if (!isset($_SESSION['user']) && isset($_COOKIE['auth_token'])) login_direct($_COOKIE['auth_token']);

$userID = $_SESSION['user'] ?? 0;

$user = new User($userID);

//view content
if ($full) Route::run();
