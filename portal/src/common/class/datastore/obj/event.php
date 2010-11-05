<?php

class Event extends Object
{
    function __construct($id)
    {
        parent::__construct('core_events');

        $this->data = array(
            'id'                => $id,
            'name'              => '',
            'sanitized'         => '',
            'datetime_start'    => '',
            'datetime_end'      => '',
            'price'             => '',
            'id_location'       => '',
            'id_map'            => '',
            'capacity'          => '',
            'information'       => '',
            'reminder'             => '',
            'agreement'         => '',
            'min_age'           => ''
        );

        $this->extra = array(
            'link'              => '',
            'link_location'     => '',
            'link_map'          => '',
            'duration'          => '',
            'duration_h'        => '',
            'location'          => '',
            'address'           => '',
            'location_name'     => '',
            'active'            => '',
            'registered'        => '',
            'onsite'            => '',
            'full'              => ''
        );
    }

    public function __get($var)
    {
        if (!isset($this->extra[$var]))
        {
            $result = parent::__get($var);
            if ($var == 'information' || $var == 'agreement' || $var == 'rules')
                return str_replace("\n", '<br />', $result);
            else
                return $result;
        }

        $result = $this->extra[$var];
        
        if ($var == 'location')
        {
            if ($result == '') return '';
            $a = explode("\n", $result);
            $str1 = implode(', ', array($a[0], $a[1]));
            if (substr($str1, 0, 2) == ', ') $str1 = substr($str1, 2);
            if (substr($str1, -2) == ', ') $str1 = substr($str1, 0, -2);

            $str2 = implode("\n", array($a[2], $a[3]));
            if (substr($str2, 0, 1) == "\n") $str2 = substr($str2, 1);
            if (substr($str2, -1) == "\n") $str2 = substr($str2, 0, -1);

            $str3 = implode(', ', array($a[4], $a[5]));
            if (substr($str3, 0, 2) == ', ') $str3 = substr($str3, 2);
            if (substr($str3, -2) == ', ') $str3 = substr($str3, 0, -2);

            $str3 .= ' '.$a[6];

            $str = $str1."<br />".$str2.'<br />'.$str3.'<br />'.$a[7];
            return $str;
        }
        else if ($var == 'address')
        {
            if ($result == '') return '';
            $result = str_replace("\n", ',', $result);
            $result = str_replace(',,', ',', $result);
            if (substr($result, 0, 1) == ',') $result = substr($result, 1);
            if (substr($result, -1) == ', ') $result = substr($result, 0, -1);

            return $result;
        }
        else
            return $result;
    }

    public function inject($data)
    {
        parent::inject($data['data']);
        $this->extra = array_merge($this->extra, $data['extra']);
    }

    protected function prepare()
    {
        $this->data = array(
            'id'                => SQLFormat::num($this->data['id']),
            'name'              => SQLFormat::string($this->data['name']),
            'sanitized'         => SQLFormat::alphanum($this->data['sanitized']),
            'datetime_start'    => SQLFormat::datetime($this->data['datetime_start']),
            'datetime_end'      => SQLFormat::datetime($this->data['datetime_end']),
            'price'             => SQLFormat::float($this->data['price']),
            'id_location'       => SQLFormat::num($this->data['id_location']),
            'id_map'            => SQLFormat::num($this->data['id_map']),
            'capacity'          => SQLFormat::num($this->data['capacity']),
            'information'       => SQLFormat::string($this->data['information']),
            'reminder'          => SQLFormat::string($this->data['reminder']),
            'agreement'         => SQLFormat::string($this->data['agreement']),
            'min_age'           => SQLFormat::num($this->data['min_age'])
        );
    }

    private $extra;

}
?>
