<?php

class BarcodeIMG extends IMG {
    function __construct($id, $eid)
    {
        parent::__construct($id, $eid, IMG::BARCODE);
    }

    public function prepare_img($size)
    {
        if ($this->id == 0) return;
        $user = Library::get_user($this->id);
        $id = SQL::zerofill($user->id);
        $rsrc = $this->open('http://www.barcodesinc.com/generator/image.php?code='.$id.'&style=196&type=C128B&width=256&height=128&xres=2&font=3');
        $white = imagecolorallocate($rsrc, 255, 255, 255);
        $black = imagecolorallocate($rsrc, 0, 0, 0);
        imagefilledrectangle($rsrc, 0, 0, 256, 24, $white);
        imagefilledrectangle($rsrc, 0, 84, 256, 128, $white);
        $eid = $this->id2;
        if ($eid != 0)
        {
            $e_list = $user->eventClassID();
            if (isset($e_list[$eid]))
                $id = Library::get_class_prefix_by_id($e_list[$eid]).$id;
        }
        self::center_text(5, 4, $id, $rsrc, $black);
        self::center_text(5, 92, $user->gamertag, $rsrc, $black);
        self::center_text(2, 108, $user->username, $rsrc, $black);
        
        return $rsrc;
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