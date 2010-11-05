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
class AvatarIMG extends IMG {
    function __construct($id)
    {
        parent::__construct($id, 0, IMG::AVATAR);
    }

    public function prepare_img($size)
    {
        if ($this->id == 0 || $size == 0) return;
        $user = Library::get_user_mini($this->id);
        
        switch ($user->type_avatar)
        {
            case 1: $img = $this->gen_gravatar($user, $size); break;
            case 2: $img = $this->gen_steam($user, $size); break;
            case 3: $img = $this->gen_xfire($user, $size); break;
            default: $img = $this->gen_auto($user, $size); break;
        }
        $im = imagecreatetruecolor($size, $size);
        imagecopyresized($im, $img, 0, 0, 0, 0, $size, $size, imagesx($img), imagesy($img));
        imagedestroy($img);
        return $im;
    }

    private function gen_auto(User $user, $size)
    {
        $steam = $user->steam();
        $xfire = $user->xfire();
        $img = NULL;
        $url = 'http://www.gravatar.com/avatar/'.md5($user->email).'.png?d=monsterid&s='.$size;
        $handle = curl_init('http://www.gravatar.com/avatar/'.md5($user->email).'?d=404');
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        if($httpCode == 404)
        {
            if (($steam->id_numeric != 0 || $steam->id != '') && $steam->valid)
                if ($size >= 64)
                    $img = $this->open($steam->iconFull);
                else if ($size >= 32)
                    $img = $this->open($steam->iconMedium);
                else
                    $img = $this->open($steam->icon);
            else if ($xfire->id != '' && $xfire->valid)
                $img = $this->open($xfire->icon);
        }
        if ($img == NULL)
            $img = $this->open($url);
        return $img;
    }

    private function gen_steam(User $user, $size)
    {
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

        if ($img == NULL)
        {
            $img = imagecreatetruecolor(80, 80);
            $white = imagecolorallocate($img, 255, 255, 255);
            imagestring($img, 1, 5, 5, $err, $white);
        }
        return $img;
    }

    private function gen_xfire(User $user, $size)
    {
        $xfire = $user->xfire();
        $img = NULL;
        if ($xfire->id != 0)
            if ($xfire->valid)
                $img = $this->open($xfire->icon);
            else
                $err = 'Invalid ID';
        else
            $err = 'No IMG';

        if ($img == NULL)
        {
            $img = imagecreatetruecolor(80, 80);
            $white = imagecolorallocate($img, 255, 255, 255);
            imagestring($img, 1, 5, 5, $err, $white);
        }
        return $img;
    }

    private function gen_gravatar(User $user, $size)
    {
        $url = 'http://www.gravatar.com/avatar/'.md5($user->email).'.png?d=monsterid&s='.$size;
        $img = $this->open($url);
        return $img;
    }
}
?>
