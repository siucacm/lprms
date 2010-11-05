<?php

class Text
{
    public static function init()
    {
        self::$instance = new Text();
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    private function  __construct()
    {
        $this->datastore = array(
            'user_registered'       => 'Dear %name%,

Thank you for registering at %place%! Your user details are as follows:

Username: %username%
E-mail: %email%

Please click on the following link in order to confirm your e-mail address:
%confirmurl%

Sincerely,
%host%',
            'user_forgot'           => 'Dear %name%,

Someone originating from %ip% (probably you) requested a password reset for the following account:

Username: %username%
E-mail: %email%

Please click on the following link in order to continue with the password reset:
%reseturl%

If you did not request a password reset, you may safely ignore this e-mail.

Sincerely,
%host%',
            'user_activated'        => 'Dear %name%,

You have successfully activated your account at %place%!

Now is the opportunity to register for any upcoming events and/or tournaments:

UPCOMING EVENTS:
%eventlist%

Enjoy, and we hope to see you soon!

Sincerely,
%host%',
            'user_reset'            => 'Dear %name%,

You have successfully reset your password at %place%!

Now is the opportunity to register for any upcoming events and/or tournaments:

UPCOMING EVENTS:
%eventlist%

Enjoy, and we hope to see you soon!

Sincerely,
%host%',
            'user_reminder'         => ''
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
