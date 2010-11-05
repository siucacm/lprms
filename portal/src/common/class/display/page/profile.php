<?php

class Page {
    public static final function render()
    {
        self::sanitize();
        if (self::$username != '')
        {
            Display::header();
            $uid = User::get_id_by_username(self::$username);
            $user = Library::get_user($uid);
            if ($user == NULL || $user === FALSE)
            {
                echo '<h1 class="title">'.self::$username.'</h1>';
                echo 'No such user exists!';
            }
            else
            {
                echo self::html_profile($user);
            }
            Display::footer();
        }
        else
        {
            Display::header();
            echo '<h1 class="title">Profile List</h1>';
            $userlist = Library::list_user_ids();
            echo '<table class="table_list">';
            echo '<tr><th></th><th>User</th><th>Classification</th><th>Steam ID</th><th>XFire ID</th></tr>';
            echo "\n\n";
            foreach ($userlist as $value)
            {
                $user = Library::get_user_mini($value);
                echo '<tr>';
                echo '<td>'.Image::html($user->get_gravatar(32), $user->gamertag).'</td>';
                echo '<td>'.HTML::link_text($user->link(),$user->gamertag).'</td>';
                echo '<td>'.Library::get_role_by_id($user->role).'</td>';
                echo '<td>'.$user->link_steam().'</td>';
                echo '<td>'.$user->link_xfire().'</td>';
                echo '</tr>';
                echo "\n\n";
            }
            echo '</table>';
            Display::footer();
        }
    }

    private static function sanitize()
    {
        if (isset($_GET['username']))
            self::$username = SQL::alphanum($_GET['username']);
    }

    private static $username = '';

    private static function html_profile(User $user)
    {
        ob_start();
        echo '<h1 class="title">'.$user->gamertag.' ('.$user->username.')</h1>';
	echo '<div class="profile">
	<div class="avatar">
		'.Image::html($user->get_gravatar()).'<br /><br />
		'.$user->uid().'<br />
		<small class="classification">'.Library::get_role_by_id($user->role).'</small>
	</div>
            <div class="blurb">'.$user->blurb.'<br /><br />
            <table class="table_list_left">
            <tr><th>Steam</th><td>'.$user->link_steam().'</td></tr>
            <tr><th>XFire</th><td>'.$user->link_xfire().'</td></tr>
            </table>
            </div>
	</div>
	<div class="info">
        <h2 class="infoheader">Teams</h2>

	<h2 class="infoheader">Events Attended</h2>';
	echo '</div> ';
        $html = ob_get_clean();
        return $html;
    }

    public function html_events()
    {
        ob_start();
        if (count($this->eventClassID()) > 0)
        {
            foreach ($this->events() as $key => $value)
            {
                echo '<h3 class="infoheader">'.HTML::link_text('#',$value->name).'</h3>';
                echo '<ul>';

                echo '</ul>';
            }
        }
        else echo 'No events';
        $html = ob_get_clean();
        return $html;
    }

    public function html_teams()
    {

    }
}

?>
