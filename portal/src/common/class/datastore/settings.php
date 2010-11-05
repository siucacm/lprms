<?php

class Settings {

    public static function init()
    {
        self::$instance = new Settings();
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    private function  __construct()
    {
        $this->datastore = array(
            'theme'             => 'default',
            'url'               => 'http://'.$_SERVER['SERVER_NAME'],
            'name'              => 'LPRMS @ SF.net',
            'tag'               => 'LAN Party Registration & Management System',
            'host'              => 'SourceForge.net',
            'hostlink'          => 'http://www.sourceforge.net',
            'recaptcha_pub'     => '',
            'recaptcha_pri'     => '',
            'dateformat'        => 'M j, Y @ g:iA',
            'timezone'          => 'America/Chicago',
            'google_webmaster'  => '',
            'google_analytics'  => '',
            'email'             => 'salukilan@gmail.com',
            'terms'             => 'By registering on this site, you agree to this pseudo set of terms that exist for no particular reason. Foo.'
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

    private static $instance = NULL;

    private $datastore = array();
}
?>
