<?php
require_once('error.php');
require_once('const.php');

if (!defined('LPRMS') || LPRMS === FALSE)
	die($global['error']['core']['nodefine']);

//All core variables will be initialized/stored here, including with comments

//Global link identifier
$global['link'] = FALSE;

//Number of queries
$global['stats']['queries'] = 0;

//Core configuration from config.inc.php
$global['core']['sql']['type'] = MYSQL;
$global['core']['sql']['hostname'] = 'localhost';
$global['core']['sql']['port'] = 3306;
$global['core']['sql']['username'] = 'lprms';
$global['core']['sql']['password'] = 'lprms';
$global['core']['sql']['database'] = 'lprms';
$global['core']['sql']['prefix'] = '';

$global['core']['config'] = array();
$global['core']['config']['theme'] = 'default';
$global['core']['config']['baseUrl'] = 'http://localhost';

//rest of the includes
require_once('config.inc.php');
require_once('sql.php');

sql_load_config();
/*
require_once('session.php');
require_once('sqlfunc.php');
require_once('postfunc.php');
require_once('js.php');
require_once('form.php');
require_once('display.php');
*/
?>
