<?php

class Page {
    public static final function render()
    {
        $uid = Session::uid();
        $user = Library::get_user_mini($uid);
        if ($user->role != 1)
            LPRMS::redirect('');
        self::sanitize();
        switch(self::$action)
        {
            case 'user':            self::page_user();
            case 'tournament':      self::page_tournament();
            case 'event':           self::page_event();
            case 'settings':        self::page_settings();
            case '':                self::page_home();
            default:                LPRMS::redirect('admin');
        }
    }

    private static final function sanitize()
    {
        if (isset($_GET['action']))
            self::$action = SQL::alphanum($_GET['action']);
        if (isset($_GET['item']))
            self::$item = SQL::alphanum($_GET['item']);
    }

    private static $action = '';
    private static $item = '';
    
    private static final function page_user()
    {
        self::header();
        echo '<span class="page_title">User List</span>
			<hr />
			<div class="content_ml">';
			self::content_box('Users', self::list_users(), FALSE);
			echo '</div>

			<div class="content_mr">';
			self::content_box('Information', '');
			echo '</div>
		</div>';
        self::footer();
    }

    private static final function page_settings()
    {

    }

    private static final function page_home()
    {
        self::header();
        echo '<span class="page_title">Dashboard</span>
			<hr />
			<div class="content_l">';
			self::content_box('Latest Users', self::latest_users());
			echo '</div>

			<div class="content_r">';
			self::content_box('Events', self::list_events());
			echo '</div>
		</div>';
        self::footer();
    }

    private static final function list_users()
    {
        $u_list = Library::list_user_ids();
        ob_start();
        echo '<div id="list_user">';
        echo '<ul>';
        for ($i = 0; $i < count($u_list); $i++)
        {
            $uid = $u_list[$i];
            $user = Library::get_user_mini($uid);
            echo '<li>';
            if (self::$item != $uid)
            {
                echo '<a href="'.LPRMS::page('admin/user/'.$uid).'">';
                echo $user->username;
                echo '</a>';
            }
            else
                echo '<span class="list_selected">'.$user->username.'</span>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
        return ob_get_clean();
    }

    private static final function latest_users()
    {
        $u_list = Library::list_user_ids();
        $u_list = array_reverse($u_list);
        ob_start();
        echo '<table style="width: 100%">';
        for ($i = 0; $i < count($u_list) && $i < 20; $i++)
        {
            $user = Library::get_user_mini($u_list[$i]);
            echo '<tr><td>';
            echo $user->joined;
            echo '</td>';
            echo '<td>';
            echo $user->gamertag.' ('.$user->username.')';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        return ob_get_clean();
    }

        private static final function list_events()
    {
        $e_list = Library::list_event_ids();
        $e_list = array_reverse($e_list);
        ob_start();
        echo '<table style="width: 100%">';
        for ($i = 0; $i < count($e_list) && $i < 20; $i++)
        {
            $event = Library::get_event($e_list[$i]);
            echo '<tr><td>';
            echo '<span style="font-size: 200%; font-variant: small-caps; font-weight: 600">'.$event->name.'</span><br /><br />';
            echo '</td>';
            echo '<td>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        return ob_get_clean();
    }

    private static final function header()
    {
        $uid = Session::uid();
        $user = Library::get_user($uid);
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="generator" content="LPRMS v1.0" />
		<style type="text/css" media="screen">
			@import url('.LPRMS::page('common/widgets/css/admin.css').');
		</style>
		<title>Administrative Panel</title>
	</head>

	<body>
		<div id="top_bar">
			<div class="top_bar_l">
				<span class="sitename">'.LPRMS::name().'</span> - <span class="visit"><a href="'.LPRMS::home().'">Visit Site</a></span>
			</div>
			<div class="top_bar_r">
				Welcome, '.$user->gamertag.' | Logout
			</div>
		</div>

		<div id="nav">
                <ul>
                    <li><a href="'.LPRMS::page('admin').'">Dashboard</a></li>
                    <li><a href="'.LPRMS::page('admin/user').'">User List</a></li>
                    <li><a href="'.LPRMS::page('admin/event').'">Event List</a></li>
                    <li><a href="'.LPRMS::page('admin/tournament').'">Tournament List</a></li>
                    <li><a href="'.LPRMS::page('admin/email').'">E-mail</a></li>
                    <li><a href="'.LPRMS::page('admin/settings').'">Settings</a></li>
                </ul>
		</div>

		<div id="content">';
    }

    private static final function footer()
    {
        echo '<div id="disclaimer">
			<small class="disclaimer">Powered by LPRMS @ SourceForge.NET</small>
                </div>
	</body>
</html>';
        exit;
    }

    private static final function content_box($name, $content, $padding = TRUE)
    {
        echo '<div class="box">';
        if ($name != '')
            echo '
                        <div class="box_h">
				<div class="box_h_l"></div>
				<div class="box_h_r"></div>
				<div class="box_h_m">'.$name.'</div>
			</div>';
        $class = ($padding)?'box_c':'box_c_nopad';
        echo '
			<div class="'.$class.'">
			'.$content.'
			</div>
		</div>';
    }
}

?>
