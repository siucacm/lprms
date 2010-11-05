<?php

class XFire
{
    public static function init()
    {
        self::$instance = new XFire();
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    private function  __construct()
    {
        $this->datastore = array(
            'username'      => '',
            'password'      => '',
            'id'            => '',
            'name'          => ''
        );
    }

    public function __get($name)
    {
        if (isset($this->datastore[$name])) return $this->datastore[$name];
        return '';
    }

    public function __set($name, $value)
    {
        $this->datastore[$name] = $value;
    }

    public function inject($array)
    {
        $this->datastore = array_merge($this->datastore, $array);
    }

    public function active()
    {
        return $this->name != '';
    }

    public function icon()
    {
        if ($this->name != '')
            return '<a href="http://www.xfire.com/communities/'.$this->name.'" title="Join us on XFire!"><img width="32" height="32" alt="Join us on XFire!" src="'.LPRMS::page('common/img/icons/socialnet/xfire.png').'" /></a>';
        return '';
    }

    private static $instance = NULL;

    private $datastore = array();
}

?>
