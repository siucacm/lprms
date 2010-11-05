<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of steam
 *
 * @author Sarah
 */
class XFireIMG extends IMG {
    function __construct($id)
    {
        parent::__construct($id, 0, IMG::XFIRE);
    }

    public function prepare_img($size)
    {
        if ($this->id == 0 || $size == 0) return;
        $user = Library::get_user_mini($this->id);
        
        $xfire = $user->xfire();

        $img = NULL;
        if ($xfire->id != '')
            if ($xfire->valid)
                $img = $this->open($xfire->icon);
            else
                $err = 'Invalid ID';
        else
            $err = 'No IMG';

        $im = imagecreatetruecolor($size, $size);
        if ($img == NULL)
        {
            $white = imagecolorallocate($im, 255, 255, 255);
            imagestring($im, 1, 5, 5, $err, $white);
        }
        else
        {
            imagecopyresized($im, $img, 0, 0, 0, 0, $size, $size, imagesx($img), imagesy($img));
            imagedestroy($img);
        }
        return $im;
    }
}
?>
