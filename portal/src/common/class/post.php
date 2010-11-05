<?php

class PostData {
    function __construct($params)
    {
        $this->params = $params;
    }

    public function __get($var)
    {
        if (isset($this->params[$var])) return $this->params[$var];
        return '';
    }

    private $params;
}

class Post {
    public static final function validate($params)
    {
        if (!isset($params['form'])) LPRMS::go_home();
        $type = MySQL::alphanum($params['form']);
        unset($params['form']);
        switch ($type)
        {
            case 'acct_login':              self::post_login($params); break;
            case 'acct_register':           self::post_register($params); break;
            case 'acct_edit';               self::post_edit($params); break;
            case 'acct_forgot_username':    self::post_forgot_user($params); break;
            case 'acct_forgot_email':       self::post_forgot_email($params); break;
            case 'acct_reset':              self::post_reset($params); break;
            default: break;
        }
        LPRMS::go_home();
    }

    private static function post_forgot_user($params)
    {
        if (!isset($params['username']))
        {
            Error::set_persistent_error('Critical POST data is missing! Try again.');
            LPRMS::redirect('account/forgot');
        }

        $uid = User::get_id_by_username($params['username']);
        if ($uid == 0)
        {
            Error::set_persistent_error('Invalid username! Try again.');
            LPRMS::redirect('account/forgot');
        }
        $user = Library::get_user_mini($uid);
        $user->confirm = md5(rand());
        $user->commit();

        Mail::mail_forgot($user);
        LPRMS::redirect('account/forgotted');
    }

    private static function post_forgot_email($params)
    {
        if (!isset($params['email']))
        {
            Error::set_persistent_error('Critical POST data is missing! Try again.');
            LPRMS::redirect('account/forgot');
        }

        $uid = User::get_id_by_email($params['email']);
        if ($uid == 0)
        {
            Error::set_persistent_error('Invalid email! Try again.');
            LPRMS::redirect('account/forgot');
        }
        $user = Library::get_user_mini($uid);
        $user->confirm = md5(rand());
        $user->commit();

        Mail::mail_forgot($user);

        LPRMS::redirect('account/forgotted');
    }

    private static function post_reset($params)
    {
        if (!isset($params['confirm']) || !isset($params['password1']) || !isset($params['password2']))
        {
            Error::set_persistent_error('Critical POST data is missing! Try again.');
            LPRMS::redirect('account/forgot');
        }

        $uid = User::get_id_by_hash($params['confirm']);
        if ($uid == 0)
        {
            Error::set_persistent_error('Invalid hash! Try again.');
            LPRMS::redirect('account/forgot');
        }

        if ($params['password1'] != $params['password2'])
        {
            Error::set_persistent_error('Passwords do not match! Try again.');
            LPRMS::redirect('account/reset/'.$params['confirm']);
        }

        $user = Library::get_user_mini($uid);
        $user->password = md5($params['password1']);
        $user->commit();

        Mail::mail_reset($user);

        LPRMS::redirect('account/resetted');
    }

    private static function post_register($params)
    {
        if (!isset($params['username']) || !isset($params['email']) || !isset($params['password1']) || !isset($params['password2']))
        {
            Error::set_persistent_error('Critical POST data is missing! Try again.');
            LPRMS::redirect('account/register');
        }
        if ($params['password1'] != $params['password2'])
        {
            Error::set_persistent_error('Passwords do not match! Try again.');
            LPRMS::redirect('account/register');
        }
        if (User::email_exists($params['email']))
        {
            Error::set_persistent_error('E-mail '.SQL::email($params['email']).' already exists in system! Try again.');
            LPRMS::redirect('account/register');
        }
        if (User::username_exists($params['username']))
        {
            Error::set_persistent_error('Username already exists in system! Try again.');
            LPRMS::redirect('account/register');
        }
        $resp = Captcha::validate($params["recaptcha_challenge_field"], $params["recaptcha_response_field"]);
        /*if ($resp !== TRUE)
        {
            Error::set_persistent_error($resp);
            LPRMS::redirect('account/register');
        }*/

        $params['password'] = md5($params['password1']);
        unset($params['password1']);
        unset($params['password2']);
        $params['confirm'] = md5(rand());

        $params['birthday'] = SQL::num($params['year']).'-'.SQL::num($params['month']).'-'.SQL::num($params['day']);
        unset($params['year']);
        unset($params['month']);
        unset($params['day']);

        $params['joined'] = date('Y-m-d H:i:s');

        $user = new User();
        $user->create_new();
        $user->inject($params);
        Library::populate();
        $user->commit();

        Mail::mail_registered($user);
        LPRMS::redirect('account/registered');
    }

    private static function post_login($params)
    {
        $fd = new PostData($params);
        $fd->username = MySQL::alphanum($fd->username);
        $fd->password = md5($fd->password);
        $uid = User::get_id_by_username($fd->username);
        $user = Library::get_user_mini($uid);
        if ($user == NULL || $user === FALSE)
        {
            Error::set_persistent_error('Username does not exist!');
            LPRMS::redirect('account/login');
        }
        if ($user->active == 0)
        {
            LPRMS::redirect('account/noactive');
        }
        if ($fd->password == $user->password)
        {
            Session::start($uid);
            LPRMS::redirect('account');
        }
        Error::set_persistent_error('Invalid username/password combination');
        LPRMS::redirect('account/login');
    }

    private static function post_edit($params)
    {
        if ((isset($params['password1']) && isset($params['password2'])) && ($params['password1'] != $params['password2']))
        {
            Error::set_persistent_error('Passwords do not match! Try again.');
            LPRMS::redirect('account/edit');
        }

        if (!isset($params['username']) || !isset($params['id']) || !isset($params['confirm']))
        {
            Error::set_persistent_error('Some fields are missing...');
            LPRMS::redirect('account/edit');
        }

        if (isset($params['password1']) && $params['password1'] != '')
        {
            $params['password'] = md5($params['password1']);
            unset($params['password1']);
            unset($params['password2']);
        }

        $uid = User::get_id_by_username($params['username']);
        if ($uid != MySQL::num($params['id']))
        {
            Error::set_persistent_error('Username and User ID do not match');
            LPRMS::redirect('account/edit');
        }

        $uid = User::get_id_by_hash($params['confirm']);
        if ($uid != MySQL::num($params['id']))
        {
            Error::set_persistent_error('Username and hash do not match');
            LPRMS::redirect('account/edit');
        }

        unset($params['confirm']);

        $user = Library::get_user_mini($uid);
        if (isset($params['id_steam']))
        {
            $steam = new Steam($uid);
            $steam->id = $params['id_steam'];
            $steam->load_remote();
            if ($steam->valid == 1)
                $params['num_steam'] = $steam->id_numeric;
        }
        $user->inject($params);
        $user->commit();
        Cacher::update_user($uid);

        LPRMS::redirect('account');
    }
}
?>
