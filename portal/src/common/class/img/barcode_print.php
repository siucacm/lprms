<?php

class BarcodePrintIMG extends IMG {
    function __construct($id, $eid)
    {
        parent::__construct($id, $eid, IMG::BARCODE_PRINT);
    }

    public function prepare_img($size)
    {
        if ($this->id == 0) return;
        $user = Library::get_user($this->id);
        if ($user === FALSE)
        {
            $name = "";
            $gamertag = "";
        }
        else
        {
            $name = $user->name();
            $gamertag = $user->gamertag;
        }
        $id = SQL::zerofill($this->id);
        $rsrc_print = imagecreatetruecolor(800, 262);
        $rsrc = $this->open('http://www.barcodesinc.com/generator/image.php?code='.$id.'&style=196&type=C128B&width=240&height=132&xres=2&font=1');
        $white = imagecolorallocate($rsrc, 255, 255, 255);
        $black = imagecolorallocate($rsrc, 0, 0, 0);
        $white1 = imagecolorallocate($rsrc_print, 255, 255, 255);
        imagefill($rsrc_print, 0, 0, $white1);
        imagefilledrectangle($rsrc, 0, 0, 240, 22, $white);
        imagefilledrectangle($rsrc, 0, 100, 240, 132, $white);

        $eid = $this->id2;
        if ($eid != 0)
        {
            $e_list = $user->eventClassID();
            if (isset($e_list[$eid]))
                $id = Library::get_class_prefix_by_id($e_list[$eid]).$id;
        }
        self::center_text(4, 4, $id, $rsrc, $black);
        self::center_text(4, 102, $gamertag, $rsrc, $black);
        self::center_text(2, 116, $name, $rsrc, $black);
        imagecopyresized($rsrc_print, $rsrc, 320, 0, 0, 0, 480, 262, 240, 131);
        imagedestroy($rsrc);
        $salukilan_img = imagecreatefromjpeg(LPRMS::root().'content/cache/generic/salukilan.jpg');
        imagecopy($rsrc_print, $salukilan_img, 0, 0, 0, 0, 320, 262);
        imagedestroy($salukilan_img);
        
        return $rsrc_print;
    }

    private static final function center_text($size, $y, $text, $im, $color)
    {
        $fw = imagefontwidth($size);
        $istrlen = strlen($text)*$fw;
        $x = (imagesx($im) - $istrlen)/2;
        imagestring($im, $size, $x, $y, $text, $color);
    }
}
?>