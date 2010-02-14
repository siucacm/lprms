<?php

/*
This file defines an array of possible error messages to be returned.
Preferably this should be used in place of hardcoding in error messages
(which can result in inconsistencies).
*/

$global['error']['sql']['connect'] = 'Error establishing connection to SQL server; perhaps you should double-check your configuration file?';
$global['error']['sql']['disconnect'] = 'Error closing connection to SQL server.';
$global['error']['sql']['type'] = 'Invalid SQL type defined in configuration file.';
$global['error']['sql']['query'] = 'Error performing SQL query.';
$global['error']['sql']['missing'] = 'Data is missing from the database; are you sure LPRMS is installed correctly?';

$global['error']['core']['nodefine'] = 'Please visit the index page';

$global['error']['post']['missing'] = 'Invalid POST headers were sent; perhaps you should retry your query?';
$global['error']['post']['invalid'] = 'Form type is invalid; perhaps you should retry your query?';

function error_sql($type)
{
	global $global;
	return $global['error']['sql'][$type];
}

function err_die($message)
{
?>

<?php
}

?>
