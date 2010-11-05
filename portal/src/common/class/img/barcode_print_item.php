<?php

class BarcodeItemPrintIMG extends IMG {
    function __construct($id, $eid)
    {
        parent::__construct($id, $eid, IMG::BARCODE_ITEM);
    }

    public function prepare_img($size)
    {
        if ($this->id == 0) return;
        $id = 'I'.SQL::zerofill($this->id);
        $rsrc_print = imagecreatetruecolor(875, 323);
        $rsrc = $this->open('http://www.barcodesinc.com/generator/image.php?code='.$id.'&style=196&type=C128B&width=290&height=108&xres=2&font=1');
        $white = imagecolorallocate($rsrc, 255, 255, 255);
        $black = imagecolorallocate($rsrc, 0, 0, 0);
        $white1 = imagecolorallocate($rsrc_print, 255, 255, 255);
        imagefill($rsrc_print, 0, 0, $white1);
        imagefilledrectangle($rsrc, 0, 90, 290, 108, $white);

        self::center_text(4, 92, $id, $rsrc, $black);
        imagecopyresized($rsrc_print, $rsrc, 0, 0, 0, 0, 870, 321, 290, 107);
        imagedestroy($rsrc);
        
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