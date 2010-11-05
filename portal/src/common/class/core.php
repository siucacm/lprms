<?php

class LPRMS {
    public static function init()
    {
        self::$root = calc_root();
        
        self::load_core();

        if (SQL::init() === FALSE) die('Error initializing SQL');
        Datastore::init();

        self::load_rest();

        Session::init(md5(Settings::getInstance()->url));
    }

    public static function path($file = '')
    {
        return self::$root.$file;
    }

    public static function page($page = '')
    {
        return Settings::getInstance()->url.'/'.$page;
    }

    public static function theme()
    {
        return Settings::getInstance()->theme;
    }
    
    public static function theme_dir()
    {
        return self::page('content/themes/'.self::theme());
    }

    public static function name()
    {
        return Settings::getInstance()->name;
    }

    public static function tagline()
    {
        return Settings::getInstance()->tag;
    }

    public static function post()
    {
        return self::page('post');
    }

    public static function go_home()
    {
        header('Location: '.self::page());
        exit;
    }

    public static function redirect($page)
    {
        header('Location: '.self::page($page));
        exit;
    }
    
    private static $root = '';

    public static function load_class($class)
    {
        require_once(self::path('common/class/'.$class));
    }

    private static function load_core()
    {
        self::load_class('error.php');
        self::load_class('sql/sql.php');
        self::load_class('datastore/datastore.php');
    }

    private static function load_rest()
    {
        self::load_class('session.php');
        self::load_class('display/display.php');
        self::load_class('display/page.php');

        /*
        require_once(self::root().'common/class/html.php');
        require_once(self::root().'common/class/post.php');
        require_once(self::root().'common/class/mail.php');
        require_once(self::root().'common/class/session.php');
        require_once(self::root().'common/class/display.php');
        require_once(self::root().'common/class/image.php');
        require_once(self::root().'common/class/widget.php');
        require_once(self::root().'common/class/xml.php');
        require_once(self::root().'common/class/obj/library.php');
        require_once(self::root().'common/class/recaptcha/recaptchalib.php');
        require_once(self::root().'common/class/recaptcha/recaptcha.php');
        require_once(self::root().'common/class/form/form.php');
        require_once(self::root().'common/class/form/input.php');
        require_once(self::root().'common/class/form/dropdown.php');
        require_once(self::root().'common/class/embed.php');

        require_once(self::root().'common/class/img/img.php');
        require_once(self::root().'common/class/img/avatar.php');
        require_once(self::root().'common/class/img/barcode.php');
        require_once(self::root().'common/class/img/barcode_print.php');
        require_once(self::root().'common/class/img/barcode_print_item.php');
        require_once(self::root().'common/class/img/gravatar.php');
        require_once(self::root().'common/class/img/steam.php');
        require_once(self::root().'common/class/img/xfire.php');
         * 
         */
    }

}
?>
