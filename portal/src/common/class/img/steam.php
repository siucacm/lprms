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
class SteamIMG extends IMG {
    function __construct($id)
    {
        parent::__construct($id, 0, IMG::STEAM);
    }

    public function prepare_img($size)
    {
        if ($this->id == 0 || $size == 0) return;
        $user = Library::get_user_mini($this->id);
        
        $steam = $user->steam();

        $img = NULL;
        if ($steam->id_numeric != 0 || $steam->id != '')
            if ($steam->valid)
            {
                if ($size >= 64)
                    $img = $this->open($steam->iconFull);
                else if ($size >= 32)
                    $img = $this->open($steam->iconMedium);
                else
                    $img = $this->open($steam->icon);
            }
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
