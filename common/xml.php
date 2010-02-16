<?php
/*
 * XML Parser 1.0
 * Author: Sarah Harvey
 * Last Modified: February 15, 2010
*/

function xml_xparse($str, $pos = 0)
{
	$array = array();
	//echo '"'.$str.'"'."\n";
	//echo "\n\nENTER FUNCTION\n";
	while ($pos < strlen($str))
	{
		//echo 'line 14 - $pos = '.$pos.', strlen($str) = '.strlen($str)."\n";
		if (stripos($str, '<![CDATA[', $pos) == $pos)
		{
			$astr = substr($str, 9, strlen($str) - 12);
			//echo 'line 18 - CDATA detected: '."\n";
			return $astr;
		}
		$start = stripos($str, '<', $pos);
		//echo 'line 22 - $start = '.$start.', $pos = '.$pos."\n";
		if ($start === FALSE) break;
		$start++;
		//echo 'line 25 - $start = '.$start.', $pos = '.$pos."\n";
		$end = stripos($str, '>', $start);
		//echo 'line 27 - $end = '.$end.', $pos = '.$pos."\n";
		if ($end === FALSE) break;
		$tagstr = substr($str, $start, $end - $start);
		//echo 'line 30 - $tagstr = '.$tagstr."\n";
		$tag = array();
		$tmp = stripos($tagstr, ' ');
		if ($tmp !== FALSE)
		{
			$tag['name'] = substr($tagstr, 0, $tmp);
			$tag['attr'] = substr($tagstr, $tmp+1);
		}
		else
			$tag['name'] = $tagstr;
		//print_r($tag);
		$pos = $end + 1;
		//echo 'line 42 - $pos = '.$pos."\n";
		if ($tag['name'] != '?xml')
		{
			$endtag = stripos($str, '</'.$tag['name'].'>', $pos);
			//echo 'line 46 - $endtag = '.$endtag.', $pos = '.$pos."\n";
			if ($endtag === FALSE) break;
			$content = substr($str, $pos, $endtag - $pos);
			//echo $content;
			$result = xml_xparse($content);
			if ($result === FALSE)
				$tag['content'] = $content;
			else
				$tag['content'] = $result;
			//echo $content."\n";
			//print_r($result);
			//echo 'line 56 - $tag[\'content\'] = '.$tag['content']."\n";
			$pos = $endtag + strlen($tag['name'])+3;
		}
		$array[] = $tag;
		//print_r($tag);
		//print_r($array);
		//echo "LOOP \n\n";
	}
	//print_r($array);
	//echo "=== END ===\n";
	return $array;
	//return '';
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