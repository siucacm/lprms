<?php
class Image extends Object
{
    function __construct($id)
    {
        parent::__construct('core_events');

        $this->data = array(
            'id'                => $id,
            'id_album'          => '',
            'file'              => '',
            'title'             => ''
        );

    }

    protected function prepare()
    {
        $this->data = array(
            'id'                => SQLFormat::num($this->id),
            'id_album'          => SQLFormat::num($this->id_album),
            'file'              => SQLFormat::string($this->file),
            'title'             => SQLFormat::string($this->title)
        );
    }

    public static function renderUnknown($size = 64)
    {
        $image = imagecreatetruecolor(self::SIZE_UNKNOWN, self::SIZE_UNKNOWN);
        $color = imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
        imagestring($image, 5, (self::SIZE_UNKNOWN - imagefontwidth(5))/2, (self::SIZE_UNKNOWN - imagefontheight(5))/2, '?', $color);
        $image2 = imagecreatetruecolor($size, $size);
        imagecopyresized($image2, $image, 0, 0, 0, 0, $size, $size, self::SIZE_UNKNOWN, self::SIZE_UNKNOWN);
        header('Content-Type: image/png');
        imagepng($image2);
        imagedestroy($image);
        imagedestroy($image2);
    }

    const SIZE_UNKNOWN = 16;
}
?>
