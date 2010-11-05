<?php

class Location extends Object {
    function __construct($id)
    {
        parent::__construct($id, 'core_locations');
    }

    public function map($size = 256)
    {
        $size = SQL::num($size);
        $map_params = implode(',', array($this->address1, $this->address2, $this->city, $this->state, $this->zip, $this->country));
        $map_params = str_replace(',,',',', $map_params);
        $map_params = str_replace(' ','+', $map_params);
        if (substr($map_params, 0, 1) == ',') $map_params = substr($map_params, 1);
        if (substr($map_params, -1) == ',') $map_params = substr($map_params, 0, -1);
        $url = 'http://maps.google.com/maps/api/staticmap?center='.$map_params.'&zoom='.self::ZOOM.'&size='.$size.'x'.$size.'&format=png&maptype=roadmap&sensor=false';
        return $url;
    }

    public function link_map()
    {
        $map_params = implode(',', array($this->address1, $this->address2, $this->city, $this->state, $this->zip, $this->country));
        $map_params = str_replace(',,',',', $map_params);
        $map_params = str_replace(' ','+', $map_params);
        if (substr($map_params, 0, 1) == ',') $map_params = substr($map_params, 1);
        if (substr($map_params, -1) == ',') $map_params = substr($map_params, 0, -1);
        $url = 'http://maps.google.com/maps?q='.$map_params;
        return $url;
    }

    public function html_display()
    {
        ob_start();
        echo $this->name;
        echo '<br />';
        if ($this->room != '')
        {
            echo $this->room;
            if ($this->floor != '') echo ', ';
        }
        echo $this->floor;
        echo '<br />';

        echo $this->address1.'<br />';
        echo $this->address2.'<br />';

        $str = $this->city;
        if ($str != '') $str .= ', ';
        $str .= $this->state;
        if ($str != '') $str .= ' ';
        $str .= $this->zip;
        echo $str.'<br />';

        echo $this->country;
        return ob_get_clean();
    }

    public function prepare()
    {
        
    }

    const ZOOM = 14;
}
?>
