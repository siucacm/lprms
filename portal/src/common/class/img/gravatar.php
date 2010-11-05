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
class GravatarIMG extends IMG {
    function __construct($id)
    {
        parent::__construct($id, 0, IMG::GRAVATAR);
    }

    public function prepare_img($size)
    {
        if ($this->id == 0 || $size == 0) return;
        $user = Library::get_user_mini($this->id);

        $url = 'http://www.gravatar.com/avatar/'.md5($user->email).'.png?d=monsterid&s='.$size;
        $img = $this->open($url);
        return $img;
    }
}
?>
