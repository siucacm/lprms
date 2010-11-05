<?php

class Image {

    public static final function error_img($errmsg)
    {
        $w = (strlen($errmsg)+4)*imagefontwidth(self::FONT_SIZE);
        $h = (3)*imagefontheight(self::FONT_SIZE);
        $im = imagecreatetruecolor($w,$h);
        $white = imagecolorallocate($im, 255, 255, 255);
        imagestring($im, self::FONT_SIZE,
                imagefontwidth(self::FONT_SIZE)*2,
                imagefontheight(self::FONT_SIZE),
                $errmsg, $white);
        header ('Content-type: image/png');
        imagepng($im);
        imagedestroy($im);
        exit;
    }

    public static final function location_img($event_name)
    {
        $eid = Event::get_id_by_sanitized($event_name);
        if ($eid == 0) self::error_img('invalid eid');
        $event = Library::get_event($eid);
        $mapurl = $event->location->map();
        $fp = fopen($mapurl, 'rb');
        header("Content-Type: image/png");
        fpassthru($fp);
        fclose($fp);
        exit;
    }

    public static final function html($url, $alt = '')
    {
        return '<img src="'.$url.'" alt="'.$alt.'" />';
    }

    public static final function render_tournament_tree($tid)
    {
        
    }

    public static final function render_map_th($eid)
    {

    }

    const FONT_SIZE = 3;
}
?>
