<?php

class Game extends Object {
    function __construct($id)
    {
        parent::__construct($id, 'type_game');
    }

    public function link_steam()
    {
        if ($this->id_steam != '')
                return HTML::link_text('http://www.steamcommunity.com/app/'.$this->id_steam,$this->name);
        return '';
    }

    public function link_xfire()
    {
        if ($this->id_xfire != '')
                return HTML::link_text('http://www.xfire.com/game/'.$this->id_xfire,$this->name);
        return '';
    }

    public function img_tag()
    {
        if ($this->image != '')
                return Image::html(LPRMS::home().$this->image, $this->name);
        return '';
    }

    public function prepare()
    {

    }
}
?>
