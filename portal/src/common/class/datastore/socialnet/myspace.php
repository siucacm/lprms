<?php

class MySpace
{
    public static function init()
    {
        self::$instance = new MySpace();
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    private function  __construct()
    {
        $this->datastore = array(
            'username'      => '',
            'password'      => ''
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
        return $this->username != '' && $this->password != '';
    }

    public function icon()
    {
        if ($this->username != '')
            return '<a href="http://www.myspace.com/'.$this->username.'" title="Friend us on MySpace!"><img width="32" height="32" alt="Friend us on MySpace!" src="'.LPRMS::page('common/img/icons/socialnet/myspace.png').'" /></a>';
        return '';
    }

    private static $instance = NULL;

    private $datastore = array();
}

?>
