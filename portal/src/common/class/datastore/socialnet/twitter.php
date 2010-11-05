<?php

class Twitter
{
    public static function init()
    {
        self::$instance = new Twitter();
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    private function  __construct()
    {
        $this->datastore = array(
            'username'          => '',
            'password'          => ''
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
            return '<a href="http://www.twitter.com/'.$this->username.'" title="Follow us on Twitter!"><img width="32" height="32" alt="Follow us on Twitter!" src="'.LPRMS::page('common/img/icons/socialnet/twitter.png').'" /></a>';
        return '';
    }

    private static $instance = NULL;

    private $datastore = array();
}

?>
