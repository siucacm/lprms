<?php

function calc_root()
{
        $me = __FILE__;
	$you = $_SERVER['SCRIPT_FILENAME'];
	$me = str_replace('\\', '/', $me);
	$you = str_replace('\\', '/', $you);
	$me = explode('/', $me);
	$you = explode('/', $you);

	$str = '';

	for ($i = 0; $i < count($me); $i++)
		if ($me[$i] != $you[$i]) break;
	for ($j = count($you)-2; $j >= $i; $j--)
		$str .= '../';
	for (; $i < count($me) - 1; $i++)
		$str .= $me[$i].'/';

	$final = explode('/', $str);
	if ($final[count($final) - 1] == 'common')
	{
		$str = '';
		for ($i = 0; $i < count($final) - 2; $i++)
			$str .= $final[$i].'/';
	}
	else
		$str .= '../';

	return $str;
}

?>
