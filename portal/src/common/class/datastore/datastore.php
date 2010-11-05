<?php
class Datastore
{
    public static function init()
    {
        self::$instance = new Datastore();
    }

    private function __construct()
    {
        LPRMS::load_class('datastore/settings.php');
        LPRMS::load_class('datastore/text.php');
        LPRMS::load_class('datastore/library.php');
        LPRMS::load_class('datastore/socialnet/twitter.php');
        LPRMS::load_class('datastore/socialnet/facebook.php');
        LPRMS::load_class('datastore/socialnet/steam.php');
        LPRMS::load_class('datastore/socialnet/xfire.php');
        LPRMS::load_class('datastore/socialnet/myspace.php');
        LPRMS::load_class('datastore/obj/object.php');

        $data = SQLProcedure::getInstance()->getSettings();

        foreach (array('config','text','twitter','facebook','myspace','steam','twitter') as $value)
                if (!isset($data[$value])) $data[$value] = array();

        Settings::init();
        Settings::getInstance()->inject($data['config']);
        date_default_timezone_set(Settings::getInstance()->timezone);

        Text::init();
        Text::getInstance()->inject($data['text']);

        Twitter::init();
        Twitter::getInstance()->inject($data['twitter']);

        Facebook::init();
        Facebook::getInstance()->inject($data['facebook']);

        MySpace::init();
        MySpace::getInstance()->inject($data['myspace']);

        Steam::init();
        Steam::getInstance()->inject($data['steam']);

        XFire::init();
        XFire::getInstance()->inject($data['xfire']);

        $this->list = array(
            'user'          => NULL,
            'event'         => NULL,
            'match'         => NULL,
            'tournament'    => NULL,
            'image'         => NULL,
            'album'         => NULL,
            'location'      => NULL
        );
    }

    public function loadComponent($component)
    {
        switch ($component)
        {
            case 'location':
                LPRMS::load_class('datastore/obj/location.php');
                $data = SQLProcedure::getInstance()->getLocationList();
                foreach ($data as $value)
                {
                    $location = new Location($value['id']);
                    $location->inject($value);
                    $this->list['location'][$value['id']] = $location;
                }
                break;
            case 'event':
                LPRMS::load_class('datastore/obj/event.php');
                $r = SQLProcedure::getInstance()->getEventList();
                Library::buildEventMapping($r);
                foreach ($r as $value)
                {
                    $event = new Event($value['data']['id']);
                    $event->inject($value);
                    $this->list['event'][$value['data']['id']] = $event;
                }
                break;
            default:
        }
    }

    public function  __get($name)
    {
        if (isset($this->list[$name]))
        {
            if ($this->list[$name] == NULL) $this->loadComponent($name);
            return $this->list[$name];
        }
        return NULL;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function __toString()
    {
        ob_start();
        foreach ($this->list as $key => $unused)
        {
            $this->loadComponent($key);
            echo '<h2>'.$key.'</h2>';
            echo '<pre>';
            print_r($this->list[$key]);
            echo '</pre>';
        }
        return ob_get_clean();
    }

    private static $instance = NULL;

    private $list;
}
?>
