<?php

function sql_error($query = '')
{
	return ' <pre>('.mysql_error().':'.$query.')</pre>';
}

function sql_logout()
{
	global $global;
	if (mysql_close($global['link']) === FALSE) die(error_sql('disconnect').sql_error());
	$global['link'] = FALSE;
}

function sql_login()
{
	global $global;
	$sql = $$global['core']['sql'];
	$link = $global['link'];

	if ($link !== FALSE) sql_logout();
	
	$link = mysql_connect($sql['hostname'].':'.$sql['port'], $sql['username'], $sql['password'], TRUE);
	if ($link === FALSE) die(error_sql('connect').sql_error());
	
	if (mysql_select_db($sql['database'], $link) === FALSE) die(error_sql('connect').sql_error());
	
	$global['link'] = $link;
}

function sql_test($params)
{
	$link = mysql_connect($params['hostname'], $params['username'], $params['password'], TRUE);
	if ($link === FALSE) return sql_error();
	else {
		if (mysql_select_db($params['database'], $link) === FALSE)
			return sql_error();
		mysql_close($link);
		return '<pre>Success!</pre>';
	}
}

function sql_query($query, $size = 0)
{
	global $global;
	$link = $global['link'];

	$resource = mysql_query($query, $link);
	if ($resource === FALSE)
	{
		$errmsg = error_sql('query').sql_error($query);
		sql_logout();
		die($errmsg);
	}
	elseif ($resource === TRUE)
		return TRUE;
	
	$array = array();
	
	if ($size == 0) $size = mysql_num_rows($resource);
	while (($row = mysql_fetch_assoc($resource)) && $size--)
			array_push($array, $row);
	mysql_free_result($resource);
	$global['stats']['queries']++;
	return $array;
}

?>
