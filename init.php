<?php
session_start();
if (!isset($_GET['dbg']))
	ini_set('display_errors',  0);
else ini_set('display_errors', 1);

ini_set('date.timezone', 'America/Mexico_City');
ini_set('session.cookie_domain', str_replace("www.", "", $_SERVER['HTTP_HOST']));

define("DIRECTORY_CONFIG", 		"config/"); 
require_once(DIRECTORY_CONFIG . 'config.php');
require_once(DIRECTORY_CONFIG . 'config_views.php');

require_once(DIRECTORY_CLASS  . 'class.object.php');
require_once(DIRECTORY_CLASS  . 'class.log.php');
require_once(DIRECTORY_CLASS  . 'class.pdo_mysql.php');
require_once(DIRECTORY_CLASS  . 'class.settings.php');
require_once(DIRECTORY_CLASS  . 'class.session.php');
require_once(DIRECTORY_CLASS  . 'class.index.php');

include_once(DIRECTORY_FUNCS . 'func.php');
$Log 		= new Log();
$obj_bd 	= new PDOMySQL( DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME );

$Settings	= new Settings();

$Session 	= new Session();
$Index		= new Index();

require_once(DIRECTORY_CLASS  . 'class.validate.php');
$Validate 	= new Validate();

require_once(DIRECTORY_CLASS . 'class.catalogue.php');
$catalogue	= new Catalogue();

require_once(DIRECTORY_CLASS  . 'class.datatable.php');

?>