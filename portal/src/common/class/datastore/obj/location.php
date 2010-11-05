<?php

class Location extends Object {
    function __construct($id)
    {
        parent::__construct('core_locations');

        $this->data = array(
            'id'        => $id,
            'name'      => '',
            'address1'  => '',
            'address2'  => '',
            'city'      => '',
            'state'     => '',
            'zip'       => '',
            'country'   => '',
            'floor'     => '',
            'room'      => ''
        );
    }
    
    public function map($size = 256) {
        $size = SQL::num($size);
        $map_params = implode(',', array($this->address1, $this->address2, $this->city, $this->state, $this->zip, $this->country));
        $map_params = str_replace(',,',',', $map_params);
        $map_params = str_replace(' ','+', $map_params);
        if (substr($map_params, 0, 1) == ',') $map_params = substr($map_params, 1);
        if (substr($map_params, -1) == ',') $map_params = substr($map_params, 0, -1);
        $url = 'http://maps.google.com/maps/api/staticmap?center='.$map_params.'&zoom='.self::ZOOM.'&size='.$size.'x'.$size.'&format=png&maptype=roadmap&sensor=false';
        return $url;
    }

    public function link_map() {
        $map_params = implode(',', array($this->address1, $this->address2, $this->city, $this->state, $this->zip, $this->country));
        $map_params = str_replace(',,',',', $map_params);
        $map_params = str_replace(' ','+', $map_params);
        if (substr($map_params, 0, 1) == ',') $map_params = substr($map_params, 1);
        if (substr($map_params, -1) == ',') $map_params = substr($map_params, 0, -1);
        $url = 'http://maps.google.com/maps?q='.$map_params;
        return $url;
    }

    protected function prepare()
    {
        $this->data = array(
            'id'        => SQLFormat::num($this->id),
            'name'      => SQLFormat::string($this->name),
            'address1'  => SQLFormat::string($this->address1),
            'address2'  => SQLFormat::string($this->address2),
            'city'      => SQLFormat::string($this->city),
            'state'     => SQLFormat::alphanum($this->state),
            'zip'       => SQLFormat::alphanum($this->zip),
            'country'   => SQLFormat::alphanum($this->country),
            'floor'     => SQLFormat::string($this->floor),
            'room'      => SQLFormat::string($this->room)
        );
    }

    const ZOOM = 14;
}
?>
