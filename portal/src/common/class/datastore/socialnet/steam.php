<?php

class Steam
{
    public static function init()
    {
        self::$instance = new Steam();
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
            return '<a href="http://steamcommunity.com/groups/'.$this->name.'" title="Join us on Steam!"><img width="32" height="32" alt="Join us on Steam!" src="'.LPRMS::page('common/img/icons/socialnet/steam.png').'" /></a>';
        return '';
    }

    private static $instance = NULL;

    private $datastore = array();
}

?>
