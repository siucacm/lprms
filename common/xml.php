<?php
/*
 * Simple XML Parser until someone figures out how to use the XML parsing classes in PHP
*/

function xml_xparse($str, $pos = 0)
{
	$array = array();
	while ($pos < strlen($str))
	{
		if (stripos($str, '<![CDATA[', $pos) == $pos)
		{
			$astr = substr($str, 9, strlen($str) - 12);
			return $astr;
		}
		$start = stripos($str, '<', $pos);
		if ($start === FALSE) break;
		$start++;
		$end = stripos($str, '>', $start);
		if ($end === FALSE) break;
		$tagstr = substr($str, $start, $end - $start);
		$tag = array();
		$tmp = stripos($tagstr, ' ');
		if ($tmp !== FALSE)
		{
			$tag['name'] = substr($tagstr, 0, $tmp);
			$tag['attr'] = substr($tagstr, $tmp+1);
		}
		else
			$tag['name'] = $tagstr;
		$pos = $end + 1;
		if ($tag['name'] != '?xml')
		{
			$endtag = stripos($str, '</'.$tag['name'].'>', $pos);
			if ($endtag === FALSE) break;
			$content = substr($str, $pos, $endtag - $pos);
			$result = xml_xparse($content);
			if ($result === FALSE)
				$tag['content'] = $content;
			else
				$tag['content'] = $result;
			$pos = $endtag + strlen($tag['name'])+3;
		}
		$array[] = $tag;
	}
	return $array;
}

function get_xml($url)
{
	$handle = fopen($url, 'r');
	if ($handle === FALSE) return FALSE;
	$str = '';
	while (!feof($handle))
		$str .= fread($handle, 4096);
	fclose($handle);
	$array = xml_xparse($str);
	return $array;
}

?>