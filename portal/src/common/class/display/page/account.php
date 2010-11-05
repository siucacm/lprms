<?php

class AccountPage {
    public static function render($args) {
        if (isset($args[0]))
            switch ($args[0]) {
                case 'register':    self::render_register(); break;
                case 'login':       self::render_login(); break;
                case 'forgot':      self::render_forgot(); break;
                case 'logout':      self::render_logout(); break;
                case 'edit':
                case 'confirm':
                case 'reset':
                case 'info':
                default:            LPRMS::redirect('account');
            }
        else
            self::render_index();

        exit;
    }

    public static function render_index()
    {
        if (Session::active())
        {
            Display::header();
            Display::footer();
        }
        else LPRMS::redirect('account/login');
    }

    public static function render_register()
    {
        LPRMS::load_class('page/components/forms/form_registeruser.php');
        Display::header();
        echo '<h1>Register an account</h1>';
        Form_RegisterUser::render();
        Display::footer();
    }

    public static function render_forgot()
    {
        LPRMS::load_class('page/components/forms/form_forgotuser.php');
        Display::header();
        echo '<h1>Forgot your password?</h1>';
        Form_ForgotUser::render();
        Display::footer();
    }

    public static function render_login()
    {
        LPRMS::load_class('page/components/forms/form_loginuser.php');
        Display::header();
        echo '<h1>Login</h1>';
        Form_LoginUser::render();
        Display::footer();
    }

    public static final function render_old()
    {
        self::sanitize();
        if (Session::active())
        {
            $user = new User(Session::uid());
            switch (self::$action)
            {
                case 'logout':  self::logout(); break;
                case 'edit':    self::display_edit($user); break;
                case '':        self::display($user); break; //self::display($user); break;
                default: LPRMS::go_home();
            }
        }
        else
        {
            switch (self::$action)
            {
                case 'login':       self::display_login(); break;
                case 'register':    self::display_register(); break;
                case 'registered':  self::display_registered(); break;
                case 'noactive':    self::display_noactive(); break;
                case 'confirm':     self::display_confirm(self::$c); break;
                case 'forgot':      self::display_forgot(); break;
                case 'forgotted':   self::display_forgotted(); break;
                case 'reset':       self::display_reset(self::$c); break;
                case 'resetted':    self::display_resetted(); break;
                default:            LPRMS::redirect('account/login');
            }
            LPRMS::redirect('account/login');
        }
    }

    private static function sanitize()
    {
        if (isset($_GET['action']))
            self::$action = SQL::alphanum($_GET['action']);
        if (isset($_GET['c']))
            self::$c = SQL::hex($_GET['c']);
    }

    private static function logout()
    {
        Session::destroy();
        LPRMS::go_home();
    }

    private static function display(User $user)
    {
        Display::header();
        echo '<h1 class="title">Account Details for '.$user->username;
        echo HTML::link_text(LPRMS::page('account/logout'),'logout &raquo;', 'nav_text link');
        echo '</h1>';
        echo '<div class="acct">
	<div class="acct_avatar">
		'.Image::html($user->get_gravatar(80)).'<br /><br />
        </div>
            <div class="acct_info">';
                echo '<h3 class="infoheader">Account Information</h3>';

                echo '<table class="table_list_left">';
                echo '<tr><th>User ID</th><td>'.$user->uid().'</td></tr>';
                echo '<tr><th>Username</th><td>'.$user->username.'</td></tr>';
                echo '<tr><th>Display Name</th><td>'.$user->gamertag.'</td></tr>';
                echo '<tr><th>E-mail</th><td>'.$user->email.'</td></tr>';
                echo '<tr><td colspan="2">&nbsp;</td></tr>';
                echo '<tr><th>First Name</th><td>'.$user->first_name.'</td></tr>';
                echo '<tr><th>Last Name</th><td>'.$user->last_name.'</td></tr>';
                echo '<tr><th>Phone Number</th><td>'.Library::parse_phone($user->phone).'</td></tr>';
                echo '<tr><th>Birthday</th><td>'.Library::parse_date($user->birthday).'</td></tr>';
                echo '<tr><th>Join Date</th><td>'.Library::parse_datetime($user->joined).'</td></tr>';
                echo '<tr><td colspan="2">&nbsp;</td></tr>';
                echo '<tr><th>Steam ID (profile)</th><td>'.$user->id_steam.'</td></tr>';
                echo '<tr><th>Steam ID (numeric)</th><td>'.$user->num_steam.'</td></tr>';
                echo '<tr><th>XFire ID</th><td>'.$user->id_xfire.'</td></tr>';
                echo '</table>';
                echo "\n";
                echo HTML::link_text(LPRMS::page('account/edit'),'edit &raquo;', 'link nav_text');
        echo '</div>';
	echo '</div>';
        $e_list = $user->events();
        echo '<h2 class="infoheader">Registered Events</h2>';
        if (count($e_list) == 0) echo 'No registered events; Go and '.HTML::link_text(LPRMS::page('event'),'JOIN AN EVENT!');
        else
        {
            echo '<table class="table_list_left">';
            foreach ($e_list as $key => $value)
            {
                echo '<tr>';
                echo '<th>'.Image::html(LPRMS::page('content/cache/user/'.$user->id.'/barcode_'.$key.'.png')).'</th>';
                echo '<td>';
                echo '<h2>'.HTML::link_text($value->link(),$value->name).'</h2>';
                echo 'Date: '.$value->date().'<br />';
                echo 'Duration: '.$value->duration().' hours<br />';
                echo 'Location: '.HTML::link_text($value->location->link_map(),$value->location()).'<br />';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
        }
        echo '<h2 class="infoheader">User Barcodes</h2>';
        echo "\n";
        echo '<table class="table_list_left">';
        echo '<tr><th>Generic barcode</th><td>'.Image::html(LPRMS::page('content/cache/user/'.$user->id.'/barcode.png')).'</td></tr>';

        echo '</table>';
        Display::footer();
    }

    private static function display_registered()
    {
        Display::header();
        echo '<span style="font-variant: small-caps; font-size: 200%;">Thank you for registering! Please check your e-mail for a confirmation link before you can login.</span>';
        echo '<br /><br />';
        echo Image::html(LPRMS::page('common/img/thankyou.png'));
        Display::footer();
    }

    private static function display_forgotted()
    {
        Display::header();
        echo '<span style="font-variant: small-caps; font-size: 200%;">Password reset instructions have been sent; please check your e-mail.</span>';
        echo '<br /><br />';
        Display::footer();
    }

    private static function display_resetted()
    {
        Display::header();
        echo '<span style="font-variant: small-caps; font-size: 200%;">Your password has been reset. You may now login.</span>';
        echo '<br /><br />';
        Display::footer();
    }

    private static function display_noactive()
    {
        Display::header();
        echo '<span style="font-variant: small-caps; font-size: 200%;">Your account is not active; please check your e-mail for a link to activate your account.</span>';
        echo '<br /><br />';
        Display::footer();
    }

    private static function display_confirm($c)
    {
        $uid = User::get_id_by_hash($c);
        $user = Library::get_user_mini($uid);
        $str = '';
        if ($user === FALSE || $user == NULL) $str = '<span style="font-variant: small-caps; font-size:200%;">Invalid hash!</span>';
        else
        {
            $user->active = 1;
            $user->commit();
            Mail::mail_confirmed($user);
            $hstr = '<span style="font-variant: small-caps; font-size:200%;">Your account has been successfully confirmed. You may now login and join an event.<br /><br /></span>';
            $eventlist = Library::list_event_ids();
            $str = '';
            foreach ($eventlist as $id)
            {
                $event = Library::get_event($id);
                if (!$event->active()) continue;
                $str .= '<h2 class="title">'.$event->name.'</h2>';
                $str .= "\r\n";
                $str .= '<ul>';
                $str .= '<li>'.$event->date().' ('.$event->duration().' hours)</li>';
                $str .= '<li>'.$event->location().'</li>';
                $str .= '<li>'.HTML::link_text($event->link(), $event->link()).'</li>';
                $str .= '</ul>';
                $str .= "\r\n";
                $str .= "\r\n";
            }
            if ($str == '') $str = 'No upcoming events';
        }

        Display::header();
        echo $hstr;
        echo '<h1 class="title">Upcoming Events</h1>';
        echo '<div style="padding:0 20px;">';
        echo $str;
        echo '</div>';
        echo '<br /><br />';
        //echo Image::html(LPRMS::page('common/img/thankyou.png'));
        Display::footer();
    }

    private static function display_reset($c)
    {
        $uid = User::get_id_by_hash($c);
        $user = Library::get_user_mini($uid);
        if ($user === FALSE || $user == NULL) $str = '<span style="font-variant: small-caps; font-size:200%;">Invalid hash!</span>';
        else
        {
            $form = new Form('acct_reset', 'Change password');
            $form->add_hidden(array('name' => 'confirm', 'value' => $user->confirm));

            $form->add_field(array('label' => 'Enter new password: ', 'name' => 'password1', 'value' => '', 'type' => 'password'));
            $form->add_field(array('label' => 'Confirm password: ', 'name' => 'password2', 'value' => '', 'type' => 'password'));
        }

        Display::header();
        echo '<h1 class="title">Reset Password</h1>';
        echo Error::view_persistent_error();
        $form->render();
        echo '<br /><br />';
        //echo Image::html(LPRMS::page('common/img/thankyou.png'));
        Display::footer();
    }

    private static function display_register()
    {
        $form = new Form('acct_register', 'Register');

        $form->add_field(array('label' => 'Username: ', 'name' => 'username', 'value' => ''));
        $form->add_field(array('label' => 'E-mail Address: ', 'name' => 'email', 'value' => ''));
        $form->add_field(array('label' => 'Password: ', 'name' => 'password1', 'value' => '', 'type' => 'password'));
        $form->add_field(array('label' => 'Confirm password: ', 'name' => 'password2', 'value' => '', 'type' => 'password'));

        $form->add_separator();

        $form->add_field(array('label' => 'Display Name: ', 'name' => 'gamertag', 'value' => ''));
        $form->add_field(array('label' => 'First Name: ', 'name' => 'first_name', 'value' => ''));
        $form->add_field(array('label' => 'Last Name: ', 'name' => 'last_name', 'value' => ''));
        $form->add_field(array('label' => 'Phone Number: ', 'name' => 'phone', 'value' => ''));
        $form->add_date('Birthday: ');
        $form->add_recaptcha();
        
        Display::header();
        echo '<h1 class="title">Register</h1>';
        echo Error::view_persistent_error();
        $form->render();
        Display::footer();
    }

    private static function display_login()
    {
        $form = new Form('acct_login', 'Login &raquo;');
        $form->add_field(array('label' => 'Username: ', 'name' => 'username'));
        $form->add_field(array('label' => 'Password: ', 'name' => 'password', 'type' => 'password'));

        Display::header();
        echo '<h1 class="title">Login</h1>';
        echo Error::view_persistent_error();
        $form->render();

        echo '<div style="width:100%; text-align: center;">';
        echo '<br /><br />'.HTML::link_text(LPRMS::page('account/register'),'REGISTER!');
        echo '<br />'.HTML::link_text(LPRMS::page('account/forgot'),'Forgot your password?');
        echo '</div>';
        Display::footer();
    }

    private static function display_forgot()
    {
        $form_u = new Form('acct_forgot_username', 'Reset &raquo;');
        $form_u->add_field(array('label' => 'Username: ', 'name' => 'username'));

        $form_e = new Form('acct_forgot_email', 'Reset &raquo;');
        $form_e->add_field(array('label' => 'Email: ', 'name' => 'email'));

        Display::header();
        echo '<h1 class="title">Reset password</h1>';
        echo Error::view_persistent_error();
        $form_u->render();
        echo '<br /><br />';
        $form_e->render();

        echo '<br /><br />'.HTML::link_text(LPRMS::page('account/register'),'Register for an account');
        Display::footer();
    }

    private static function display_edit(User $user)
    {
        $form = new Form('acct_edit', 'Save Changes');
        $form->add_text(array('label' => 'ID: ', 'value' => $user->uid()));
        $form->add_text(array('label' => 'Username: ', 'value' => $user->username));
        $form->add_text(array('label' => 'Join Date: ', 'value' => Library::parse_datetime($user->joined)));

        $form->add_separator();

        $form->add_field(array('label' => 'E-mail Address: ', 'name' => 'email', 'value' => $user->email));
        $form->add_field(array('label' => 'Enter new password: ', 'name' => 'password1', 'value' => '', 'type' => 'password'));
        $form->add_field(array('label' => 'Confirm password: ', 'name' => 'password2', 'value' => '', 'type' => 'password'));

        $form->add_separator();

        $form->add_field(array('label' => 'Display Name: ', 'name' => 'gamertag', 'value' => $user->gamertag));
        $form->add_field(array('label' => 'First Name: ', 'name' => 'first_name', 'value' => $user->first_name));
        $form->add_field(array('label' => 'Last Name: ', 'name' => 'last_name', 'value' => $user->last_name));
        $form->add_field(array('label' => 'Phone: ', 'name' => 'phone', 'value' => $user->phone));
        $form->add_text(array('label' => 'Birthday: ', 'value' => Library::parse_date($user->birthday)));

        $form->add_separator();
        $form->add_field(array('label' => 'Steam ID (profile): ', 'name' => 'id_steam', 'value' => $user->id_steam));
        $form->add_text(array('label' => '', 'value' => 'e.g. http://steamcommunity.com/id/<b>username</b>'));
        $form->add_field(array('label' => 'Steam ID (numeric): ', 'name' => 'num_steam', 'value' => $user->num_steam));
        $form->add_text(array('label' => '', 'value' => 'e.g. http://steamcommunity.com/profiles/<b>0000000000000000</b>'));
        $form->add_field(array('label' => 'XFire ID: ', 'name' => 'id_xfire', 'value' => $user->id_xfire));
        $form->add_hidden(array('name' => 'id', 'value' => $user->oid()));
        $form->add_hidden(array('name' => 'username', 'value' => $user->username));
        $form->add_hidden(array('name' => 'confirm', 'value' => $user->confirm));

        
        Display::header();
        echo '<h1 class="title">Edit Profile';
        echo HTML::link_text(LPRMS::page('account'),'back &raquo;','link nav_text');
        echo '</h1>';
        echo Error::view_persistent_error();
        $form->render();
        Display::footer();
    }

    private static $action = '';
    private static $c = '';
}

?>
