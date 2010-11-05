<?php

class Map {
    public static final function form_map($xml)
    {
	$map = array();
	$array = self::get_xml($xml);
	if ($array === FALSE) return FALSE;
	$map['background'] = $array[1]['content'][0]['content'];
	$map['scale'] = $array[1]['content'][1]['content'];
	$map['room'] = array();
	for ($i = 0, $j = 0; $i < count($array[1]['content'][2]['content']); $i++)
	{
		$tmp = $array[1]['content'][2]['content'][$i];
		if ($tmp['name'] == 'table')
		{
			$map['room']['table'][$j] = array();
			for ($k = 0; $k < count($tmp['content']); $k++)
				$map['room']['table'][$j][$tmp['content'][$k]['name']] = $tmp['content'][$k]['content'];
			$j++;
			continue;
		}
		$map['room'][$tmp['name']] = $tmp['content'];
	}
	return $map;
    }

    private static function xml_xparse($str, $pos = 0)
    {
	$array = array();
	while ($pos < strlen($str))
	{
		if (stripos($str, '<![CDATA[', $pos) === $pos)
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
			$result = self::xml_xparse($content);
			if ($result === FALSE)
				$tag['content'] = $content;
			else
				$tag['content'] = $result;
			$pos = $endtag + strlen($tag['name'])+3;
		}
		$array[] = $tag;
	}
	if (count($array) == 0) return FALSE;
	return $array;
    }

    private static function get_xml($url)
    {
	$handle = fopen($url, 'r');
	if ($handle === FALSE) return FALSE;
	$str = '';
	while (!feof($handle))
		$str .= fread($handle, 4096);
	fclose($handle);
	$array = self::xml_xparse($str);
	return $array;
    }

    public static function gen_map_js($eid)
    {
        $event = Library::get_event($eid);
        if ($event === FALSE || $event == NULL) return;
	$seats = $event->get_seat_list();
	if (count($seats) == 0) return;
	echo '<div id="popup"></div>';
	foreach ($seats as $k1 => $v1)
	{
		foreach ($v1 as $k2 => $v2)
		{
                        $user = Library::get_user($v2);
                        if ($user === FALSE || $user == NULL) continue;
			echo '<div id="seat_'.$k1.$k2.'" style="display: none; text-align: center;">';
			echo '<span style="font-variant: small-caps; font-size:150%;">'.$user->gamertag.'</span><br />';
			echo Image::html($user->get_gravatar(64)).'<br />';
                        $classArray = $user->eventClassID();
                        $prefix = Library::get_class_prefix_by_id($classArray[$eid]);
			echo $prefix.$user->uid();
			echo '</div>';
		}
	}
    }

    public static function gen_map_html($eid)
    {
            $event = Library::get_event($eid);
            if ($event === FALSE || $event == NULL) return;
            $seats = $event->get_seat_list();
            if ($event->map == '') return;
            $xml = LPRMS::root().'/'.$event->map;
            $array = self::form_map($xml);
            echo '<map name="map" id="map">';
            $numtables = count($array['room']['table']);
            $strnt = sprintf('%X', $numtables);
            for ($i = 0; $i < count($array['room']['table']); $i++)
            {
                    $tmp = $array['room']['table'][$i];
                    $horiz = (($tmp['rotate'])/90) % 2;
                    $label = sprintf('%0'.strlen($strnt).'X',$i);
                    if ($horiz)
                    {
                            $x = $tmp['x']*$array['scale'];
                            $y = $tmp['y']*$array['scale'];
                            $l = $tmp['l']*$array['scale'];
                            $w = $tmp['w']*$array['scale'];

                            $seatsize = floor($l/$tmp['seats']) - 6;

                            for ($j = 0; $j < $tmp['seats']; $j++)
                            {
                                    $seat = sprintf("%d", $j);
                                    switch((ceil($tmp['rotate']/90))%4)
                                    {
                                            case 1:
                                                    $cy = $y - 3 - $seatsize/2;
                                                    $cx = $x + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                    break;
                                            case 3:
                                                    $cy = $y + 3 + $w + $seatsize/2;
                                                    $cx = $x + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                    break;
                                    }
                                    if (isset($seats[$label][$seat]))
                                    {
                                        $uid = $seats[$label][$seat];
                                        $user = Library::get_user($uid);
                                            echo '<area shape="circle" coords="'.$cx.','.$cy.','.($seatsize/2).'" href="'.$user->link().'" onmouseover="popup(\'seat_'.$label.$seat.'\')" onmouseout="popout()" alt="'.$user->gamertag.'" />'."\n";
                                    }
                                    else if (Session::active())
                                    {
                                        $user = Library::get_user(Session::uid());
                                        $u_ev = $user->events();
                                        if (isset($u_ev[$event->id]) && $tmp['reserved'] == 0)
                                            echo '<area shape="circle" coords="'.$cx.','.$cy.','.($seatsize/2).'" href="'.LPRMS::home().'/event/'.$event->sanitized.'/reserve/'.$label.$seat.'" alt="" />'."\n";
                                    }
                            }
                    }
                    else
                    {
                            $x = $tmp['x']*$array['scale'];
                            $y = $tmp['y']*$array['scale'];
                            $l = $tmp['w']*$array['scale'];
                            $w = $tmp['l']*$array['scale'];

                            $seatsize = floor($w/$tmp['seats']) - 6;

                            for ($j = 0; $j < $tmp['seats']; $j++)
                            {
                                    $seat = sprintf("%d", $j);
                                    switch((ceil($tmp['rotate']/90))%4)
                                    {
                                            case 2:
                                                    $cx = $x - 3 - $seatsize/2;
                                                    $cy = $y + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                    break;
                                            case 0:
                                                    $cx = $x + 3 + $l + $seatsize/2;
                                                    $cy = $y + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                    break;
                                    }
                                    if (isset($seats[$label][$seat]))
                                    {
                                        $uid = $seats[$label][$seat];
                                        $user = Library::get_user($uid);
                                            echo '<area shape="circle" coords="'.$cx.','.$cy.','.($seatsize/2).'" href="'.$user->link().'" onmouseover="popup(\'seat_'.$label.$seat.'\')" onmouseout="popout()" alt="'.$user->gamertag.'" />'."\n";
                                    }
                                    else if (Session::active())
                                    {
                                        $user = Library::get_user(Session::uid());
                                        $u_ev = $user->events();
                                        if (isset($u_ev[$event->id]) && $tmp['reserved'] == 0)
                                            echo '<area shape="circle" coords="'.$cx.','.$cy.','.($seatsize/2).'" href="'.LPRMS::home().'/event/'.$event->sanitized.'/reserve/'.$label.$seat.'" alt="" />'."\n";
                                    }
                            }
                    }
            }
            echo '</map>';
    }

    public static function gen_map_img($thumbnail = FALSE)
    {
            $eid = 0;
            if (isset($_GET['eid'])) $eid = $_GET['eid'];
            else die('Invalid event id');
            $event = Library::get_event($eid);
            if ($event === FALSE || $event == NULL) return;
            $seats = $event->get_seat_list();
            $xml = LPRMS::root().$event->map;
            if ($thumbnail && file_exists($xml.'.th.png'))
            {
                    header('Content-Type: image/png');
                    $im = imagecreatefrompng($xml.'.th.png');
                    imagepng($im);
                    imagedestroy($im);
                    exit;
            }
            $array = self::form_map($xml);
            if ($array === FALSE) return;
            $folder = substr($xml, 0, strripos($xml, '/'));
            $im = imagecreatefrompng($folder.'/'.$array['background']);
            $bg = imagecolorallocate($im, 255, 255, 255);
            $tc = imagecolorallocate($im, 0, 0, 0);
            $free = imagecolorallocate($im, 0, 255, 0);
            $res = imagecolorallocate($im, 127, 0, 127);
            $taken = imagecolorallocate($im, 255, 0, 0);
            $numtables = count($array['room']['table']);
            $strnt = sprintf('%X', $numtables);
            $numseats = 0;
            $reserved = 0;
            for ($i = 0; $i < count($array['room']['table']); $i++)
            {
                    $tmp = $array['room']['table'][$i];
                    $horiz = (($tmp['rotate'])/90) % 2;
                    $label = sprintf('%0'.strlen($strnt).'X',$i);
                    if ($horiz)
                    {
                            $x = $tmp['x']*$array['scale'];
                            $y = $tmp['y']*$array['scale'];
                            $l = $tmp['l']*$array['scale'];
                            $w = $tmp['w']*$array['scale'];

                            imagerectangle($im, $x, $y, $l+$x, $w+$y, $tc);

                            if ($thumbnail === FALSE)
                            {

                                    $strx = $x + ($l - (imagefontwidth(5)*strlen($label)))/2;
                                    $stry = $y + ($w - (imagefontheight(5)))/2;

                                    imagestring($im, 5, $strx, $stry, $label, $tc);
                                    //imagerectangle($im, $strx, $stry, $strx+(imagefontwidth(5)*strlen($label)), $stry+(imagefontheight(5)), $tc);

                                    $seatsize = floor($l/$tmp['seats']) - 6;

                                    for ($j = 0; $j < $tmp['seats']; $j++)
                                    {
                                            $seat = sprintf("%d", $j);
                                            switch((ceil($tmp['rotate']/90))%4)
                                            {
                                                    case 1:
                                                            $cy = $y - 3 - $seatsize/2;
                                                            $cx = $x + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                            break;
                                                    case 3:
                                                            $cy = $y + 3 + $w + $seatsize/2;
                                                            $cx = $x + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                            break;
                                            }
                                            if (isset($seats[$label][$seat]))
                                                    imagefilledellipse($im, $cx, $cy, $seatsize, $seatsize, $taken);
                                            else if ($tmp['reserved'] == 1)
                                                    imagefilledellipse($im, $cx, $cy, $seatsize, $seatsize, $res);
                                            else
                                                    imagefilledellipse($im, $cx, $cy, $seatsize, $seatsize, $free);
                                            imageellipse($im, $cx, $cy, $seatsize, $seatsize, $tc);

                                            $stx = ($cx - $seatsize/2) + ($seatsize - imagefontwidth(5))/2;
                                            $sty = ($cy - $seatsize/2) + ($seatsize - imagefontheight(5))/2;
                                            imagestring($im, 5, $stx, $sty, $seat, $tc);

                                            if ($tmp['reserved'] == 0) $numseats++;
                                            else $reserved++;
                                    }
                            }
                    }
                    else
                    {
                            $x = $tmp['x']*$array['scale'];
                            $y = $tmp['y']*$array['scale'];
                            $l = $tmp['w']*$array['scale'];
                            $w = $tmp['l']*$array['scale'];

                            imagerectangle($im, $x, $y, $l+$x, $w+$y, $tc);

                            if ($thumbnail === FALSE)
                            {
                                    $strx = $x + ($l - (imagefontheight(5)))/2;
                                    $stry = $y + ($w + (imagefontwidth(5)*strlen($label)))/2;

                                    imagestringup($im, 5, $strx, $stry, $label, $tc);
                                    //imagerectangle($im, $strx, $stry, $strx+(imagefontheight(5)), $stry-(imagefontwidth(5)*strlen($label)), $tc);

                                    $seatsize = floor($w/$tmp['seats']) - 6;

                                    for ($j = 0; $j < $tmp['seats']; $j++)
                                    {
                                            $seat = sprintf("%d", $j);
                                            switch((ceil($tmp['rotate']/90))%4)
                                            {
                                                    case 2:
                                                            $cx = $x - 3 - $seatsize/2;
                                                            $cy = $y + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                            break;
                                                    case 0:
                                                            $cx = $x + 3 + $l + $seatsize/2;
                                                            $cy = $y + 3 + $seatsize/2 + $j*($seatsize + 6);
                                                            break;
                                            }
                                            if (isset($seats[$label][$seat]))
                                                    imagefilledellipse($im, $cx, $cy, $seatsize, $seatsize, $taken);
                                            else
                                                    imagefilledellipse($im, $cx, $cy, $seatsize, $seatsize, $free);
                                            imageellipse($im, $cx, $cy, $seatsize, $seatsize, $tc);

                                            $stx = ($cx - $seatsize/2) + ($seatsize - imagefontheight(5))/2;
                                            $sty = ($cy - $seatsize/2) + ($seatsize + imagefontwidth(5))/2;
                                            imagestringup($im, 5, $stx, $sty, $seat, $tc);

                                            if ($tmp['reserved'] == 0) $numseats++;
                                            else $reserved++;
                                    }
                            }
                    }

            }

            if ($thumbnail === FALSE)
            {

                    imagestring($im, 4, 6*$array['scale'], 80*$array['scale'], 'Reservable Seats: '.$numseats, $tc);
                    imagestring($im, 4, 6*$array['scale'], 81*$array['scale'], 'Restricted Seats: '.$reserved, $tc);
            }

            if ($thumbnail)
            {
                    $sc = 400;
                    $imth = imagecreatetruecolor($sc, round($sc/imagesx($im)*imagesy($im)));
                    $bgth = imagecolorallocate($imth, 255, 255, 255);
                    imagefill($imth, 0, 0, $bgth);
                    imagecopyresized($imth, $im, 0, 0, 0, 0, $sc, round($sc/imagesx($im)*imagesy($im)), imagesx($im), imagesy($im));

                    header('Content-Type: image/png');
                    imagepng($imth, $xml.'.th.png');
                    imagedestroy($im);
                    imagedestroy($imth);

                    $im = imagecreatefrompng($xml.'.th.png');
                    imagepng($im);
                    imagedestroy($im);
                    exit;
            }
            header('Content-Type: image/png');
            imagepng($im);
            imagedestroy($im);
            exit;
    }

    public static final function header()
    {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="generator" content="LPRMS v1.0" />
		<style type="text/css" media="screen">
				@import url('.LPRMS::theme_dir().'/style.css);
				@import url('.LPRMS::page('common/widgets/css/hover.css').');
                body { margin-top: 100px; }
		</style>

		<title>'.LPRMS::name().' - map</title>
	</head>

	<body>';
    }

    public static final function footer()
    {
        echo '</body>
</html>';
    }

    public static final function glink()
    {
        //http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=1255+Lincoln+Dr,+Carbondale,+IL&sll=37.715603,-89.218426&sspn=0.078081,0.143852&ie=UTF8&hq=&hnear=1255+Lincoln+Dr,+Carbondale,+Jackson,+Illinois+62903&ll=37.713074,-89.218383&spn=0.009761,0.017982&z=16&iwloc=A
    }
    
}
?>
