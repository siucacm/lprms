<?php

class Mail {
    public static function replace($text, $user)
    {
        $body = str_replace(
                array(
                    '%name%',
                    '%place%',
                    '%username%',
                    '%email%',
                    '%confirmurl%',
                    '%host%',
                    '%eventlist%',
                    '%ip%',
                    '%reseturl%',
                    '%active%'
                ),
                array(
                    self::formulate_name($user),
                    LPRMS::conf('name'),
                    $user->username,
                    $user->email,
                    $user->link_confirm(),
                    LPRMS::conf('host'),
                    self::get_event_list(),
                    $_SERVER['REMOTE_ADDR'],
                    $user->link_reset(),
                    ($user->active == 0)?'Unconfirmed':'Confirmed'
                ),
                $text
                );
        return $body;
    }

    public static function mail_registered(User $user)
    {
        $body = self::replace(TextConf::REGISTER, $user);
        
        self::xmail(
                LPRMS::conf('admin'),
                self::formulate_name($user).' <'.$user->email.'>',
                LPRMS::conf('name').' Registration Details',
                $body
                );
    }

    public static function mail_reminder(User $user)
    {
        $body = self::replace(TextConf::REMINDER, $user);

        self::xmail(
                LPRMS::conf('admin'),
                self::formulate_name($user).' <'.$user->email.'>',
                LPRMS::conf('name').' - Information for SalukiLAN 2010',
                $body
                );
    }

    public static function mail_confirmed(User $user)
    {
        $body = self::replace(TextConf::THANKYOU, $user);

        self::xmail(
                LPRMS::conf('admin'),
                self::formulate_name($user).' <'.$user->email.'>',
                LPRMS::conf('name').' - Account Confirmed',
                $body
                );
    }

    public static function mail_forgot(User $user)
    {
        $body = self::replace(TextConf::FORGOT, $user);

        self::xmail(
                LPRMS::conf('admin'),
                self::formulate_name($user).' <'.$user->email.'>',
                LPRMS::conf('name').' - Password Reset Request',
                $body
                );
    }

    public static function mail_reset(User $user)
    {
        $body = self::replace(TextConf::RESETTED, $user);

        self::xmail(
                LPRMS::conf('admin'),
                self::formulate_name($user).' <'.$user->email.'>',
                LPRMS::conf('name').' - Password Reset Confirmation',
                $body
                );
    }

    private static function formulate_name(User $user)
    {
        $name = $user->username;
        if ($user->first_name != '')
        {
            if ($user->last_name != '')
                $name = $user->first_name.' '.$user->last_name;
            else
                $name = $user->first_name;
        }
        return $name;
    }

    private static function xmail($from, $to, $subject, $body)
    {
        @mail(
                $to,
                $subject,
                $body,
                'From: '.$from."\r\n".'Bcc: '.LPRMS::conf('admin')
                );
    }

    private static function get_event_list()
    {
        $eventlist = Library::list_event_ids();
        $str = '';
        foreach ($eventlist as $id)
        {
            $event = Library::get_event($id);
            if (!$event->active()) continue;
            $str .= ' - '.$event->name;
            $str .= "\r\n";
            $str .= '  -- '.$event->date().' ('.$event->duration().' hours)';
            $str .= "\r\n";
            $str .= '  -- '.$event->location();
            $str .= "\r\n";
            $str .= '  -- '.$event->link();
            $str .= "\r\n";
            $str .= "\r\n";
        }
        if ($str == '') $str = 'No upcoming events'."\r\n"."\r\n";
        return $str;
    }

}
?>
