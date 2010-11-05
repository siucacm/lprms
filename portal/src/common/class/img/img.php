<?php

abstract class IMG {
    function  __construct($id, $id2 = 0, $type = self::NONE)
    {
        $this->id = $id;
        $this->id2 = $id2;
        $this->type = $type;
    }

    public function cache($size = 0)
    {
        $location = LPRMS::root().'content/cache/';
        switch ($this->type)
        {
            case self::AVATAR:
                if ($size == 0) return;
                $location .= 'user/'.$this->id.'/';
                if (!file_exists($location)) mkdir($location, 0777);
                $location .= 'avatar_'.$size.'.png'; break;
            case self::GRAVATAR:
                if ($size == 0) return;
                $location .= 'user/'.$this->id.'/';
                if (!file_exists($location)) mkdir($location, 0777);
                $location .= 'gravatar_'.$size.'.png'; break;
            case self::STEAM:
                if ($size == 0) return;
                $location .= 'user/'.$this->id.'/';
                if (!file_exists($location)) mkdir($location, 0777);
                $location .= 'steam_'.$size.'.png'; break;
            case self::XFIRE:
                if ($size == 0) return;
                $location .= 'user/'.$this->id.'/';
                if (!file_exists($location)) mkdir($location, 0777);
                $location .= 'xfire_'.$size.'.png'; break;
            case self::BARCODE:
                $location .= 'user/'.$this->id.'/';
                if (!file_exists($location)) mkdir($location, 0777);
                if ($this->id2 != 0)
                    $location .= 'barcode_'.$this->id2.'.png';
                else
                    $location .= 'barcode.png';
                break;
            case self::BARCODE_PRINT:
                $location .= 'print/user/';
                if (!file_exists($location)) mkdir($location, 0777);
                if ($this->id2 != 0)
                    $location .= 'barcode_'.$this->id.'_'.$this->id2.'.png';
                else
                    $location .= 'barcode_'.$this->id.'_generic.png';
                break;
            case self::BARCODE_ITEM:
                $location .= 'print/item/';
                if (!file_exists($location)) mkdir($location, 0777);
                $location .= 'barcode_item_'.$this->id.'.png';
                break;
            case self::LAYOUT:
            case self::LAYOUT_TH:
            case self::MAP:
            case self::TREE:
            default:
        }
        $im = $this->prepare_img($size);
        imagepng($im, $location);
        chmod($location, 0666);
        imagedestroy($im);
        usleep(100000);
    }

    private $type = self::NONE;
    protected $id = 0;
    protected $id2 = 0;

    abstract public function prepare_img($size);

    const NONE = 0;
    const AVATAR = 1;
    const BARCODE = 2;
    const LAYOUT = 3;
    const LAYOUT_TH = 4;
    const MAP = 5;
    const TREE = 6;
    const GRAVATAR = 7;
    const STEAM = 8;
    const XFIRE = 9;
    const BARCODE_PRINT = 10;
    const BARCODE_ITEM = 11;

    public function open($url)
    {
        $data = file_get_contents($url);
        if ($data === FALSE) echo '<!-- '.$url.' -->';
        if ($data === FALSE)
            return imagecreatetruecolor(32, 32);
        return imagecreatefromstring($data);
    }
}
?>
