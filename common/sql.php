<?php

switch($global['core']['sql']['type'])
{
	case MYSQL: require_once('mysql.php'); break;
	case MSSQL: require_once('mssql.php'); break;
	default: die(error_sql('type'));
}

//Common SQL Functions

function sql_renn($value)
{
	$badstuff  = array("\n", "\t", "\r", "\000", "\\", "\"", "'", ">", "<", "=", "+", "-", "[", "]", ";");
	$goodstuff = array(""  , ""  , "" , ""     , ""  , ""  , "" , "" , "" , "" , "" , "" , "" , "" , "" );
	$value = str_replace($badstuff, $goodstuff, $value);
	return $value;
}

function sql_ren($value)
{
	$badstuff  = array("\n", "\t", "\r", "\000", "\\", "\"", "'", ">", "<", "=", "+", "-", "[", "]", ";");
	$goodstuff = array(""  , ""  , ""  , ""    , ""  , ""  , "" , "" , "" , "" , "" , "" , "" , "" , "" );
	$value = str_replace($badstuff, $goodstuff, $value);
	if ($value)
		$value = "'$value'";
	else
		$value = "'0'";
	return $value;
}

function sql_res($string)
{
	$badstuff  = array("\n", "\t", "\r", "\000", "\\"  , "\"", "'"  , "+", "-", "=", ";");
	$goodstuff = array(""  , ""  , ""  , ""    , "\\\\", ""  , "\\'", "" , "" , "" , "" );
	$string = str_replace($badstuff, $goodstuff, $string);
	$string = '"'.$string.'"';
	return $string;
	//return preg_replace("([\000\010\011\012\015\032\042\047\134\140])", "\\${1}", $p_str);
}

function sql_load_config()
{
	global $global;
	sql_login();
	$array = sql_query('SELECT * FROM `'.sql_table('core_settings').'`;');
	sql_logout();
	if ($array === TRUE) die(error_sql('missing'));
	
	foreach ($array as $i)
		$global['core']['config'][$i['key']] = $i['value'];
}

function get_theme()
{
	global $global;
	return $global['core']['config']['theme'];
}

function get_name()
{
	global $global;
	return $global['core']['config']['name'];
}

function get_base_url()
{
	global $global;
	return $global['core']['config']['baseUrl'];
}

function get_theme_dir()
{
	global $global;
	return $global['core']['config']['baseUrl'].'/themes/'.get_theme();
}

function get_home_dir()
{
	global $global;
	return $global['core']['config']['homeDir'];
}

function sql_table($table)
{
	global $global;
	return strtolower($global['core']['sql']['prefix'].$table);
}

function sql_num_queries()
{
	global $global;
	return $global['stats']['queries'];
}

?>
