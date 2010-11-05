<?php

class Facebook
{
    public static function init()
    {
        self::$instance = new Facebook();
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    private function  __construct()
    {
        $this->datastore = array(
            'id'            => '',
            'name'          => '',
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
        return $this->id != '';
    }

    public function icon()
    {
        if ($this->active())
            return '<a href="http://www.facebook.com/'.$this->name.'" title="Fan us on Facebook!"><img width="32" height="32" alt="Fan us on Facebook!" src="'.LPRMS::page('common/img/icons/socialnet/facebook.png').'" /></a>';
        return '';
    }

    private static $instance = NULL;

    private $datastore = array();
}

?>
