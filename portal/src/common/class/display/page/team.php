<?php

class Page {
    public static final function render()
    { /*
        self::sanitize();
        if (self::$team != '')
            if (Session::active())
            {
                switch (self::$action)
                {
                    case 'join':
                    case 'leave':
                    case 'create':
                    case 'delete':
                    case 'kick':
                    case '':
                }
            }
            else ;
        else
            {
            Display::header();
            echo '<h1 class="title">Teams</h1>';
            $teamlist = Library::list_team_ids();
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
        }*/
        Display::header();
        echo '<h1 class="title">Teams</h1>';
        echo 'Coming soon';
        Display::footer();
    }

    private static final function sanitize()
    {
        if (isset($_GET['team']))
            self::$sanitized = SQL::alphanum($_GET['team']);
        if (isset($_GET['action']))
            self::$action = SQL::alphanum($_GET['action']);
        if (isset($_GET['target']))
            self::$target = SQL::alphanum($_GET['target']);
    }

    private static $sanitized = '';
    private static $action = '';
    private static $target = '';
}
?>
