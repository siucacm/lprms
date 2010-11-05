<?php

class Library {
    public static final function init()
    {
        require_once('object.php');
        require_once('event.php');
        require_once('game.php');
        require_once('match.php');
        require_once('team.php');
        require_once('tournament.php');
        require_once('user.php');
        require_once('location.php');
        require_once('map.php');
        require_once('steam.php');
        require_once('xfire.php');
    }

    public static final function dump()
    {
        //foreach (self::$userlist as $user) echo $user;
        //foreach (self::$eventlist as $event) echo $event;

        foreach(self::$locationlist as $location) echo $location;
    }

    public static final function populate()
    {
        MySQL::login();
        $table = MySQL::table('core_users');
        $result = MySQL::query('SELECT `id` FROM '.$table.';');
        if ($result !== FALSE && count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            self::$userlist[$result[$i]['id']] = new User($result[$i]['id']);
        }

        $table = MySQL::table('core_events');
        $result = MySQL::query('SELECT `id` FROM '.$table.';');
        if ($result !== FALSE && count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            self::$eventlist[$result[$i]['id']] = new Event($result[$i]['id']);
        }

        $table = MySQL::table('core_teams');
        $result = MySQL::query('SELECT `id` FROM '.$table.';');
        if ($result !== FALSE && count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            self::$teamlist[$result[$i]['id']] = new Team($result[$i]['id']);
        }

        $table = MySQL::table('core_locations');
        $result = MySQL::query('SELECT `id` FROM '.$table.';');
        if ($result !== FALSE && count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            self::$locationlist[$result[$i]['id']] = new Location($result[$i]['id']);
        }

        $table = MySQL::table('game_tournament');
        $result = MySQL::query('SELECT `id` FROM '.$table.';');
        if ($result !== FALSE && count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            self::$tournamentlist[$result[$i]['id']] = new Tournament($result[$i]['id']);
        }

        $table = MySQL::table('game_match');
        $result = MySQL::query('SELECT `id` FROM '.$table.';');
        if ($result !== FALSE && count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            self::$matchlist[$result[$i]['id']] = new Match($result[$i]['id']);
        }
        
        MySQL::logout();
    }

    public static final function get_user($id)
    {
        $id = SQL::num($id);
        if (!isset(self::$userlist[$id])) return FALSE;
        $user = self::$userlist[$id];
        if ($user->is_init() === FALSE)
                $user->load();
        return $user;
    }

    public static final function get_user_mini($id)
    {
        $id = SQL::num($id);
        if (!isset(self::$userlist[$id])) return 0;
        $user = self::$userlist[$id];
        if ($user->is_init() === FALSE)
                $user->load_mini();
        return $user;
    }

    public static final function list_user_ids()
    {
        return array_keys(self::$userlist);
    }

    public static final function get_event($id)
    {
        if (!isset(self::$eventlist[$id])) return FALSE;
        $event = self::$eventlist[$id];
        if ($event->is_init() === FALSE)
                $event->load();
        return $event;
    }

    public static final function list_event_ids()
    {
        return array_keys(self::$eventlist);
    }

    public static final function list_team_ids()
    {
        return array_keys(self::$teamlist);
    }

    public static final function get_location($id)
    {
        if (!isset(self::$locationlist[$id])) return FALSE;
        $location = self::$locationlist[$id];
        if ($location->is_init() === FALSE)
                $location->load();
        return $location;
    }

    public static final function get_team($id)
    {
        if (!isset(self::$teamlist[$id])) return FALSE;
        $team = self::$teamlist[$id];
        if ($team->is_init() === FALSE)
                $team->load();
        return $team;
    }

    public static final function get_tournament($id)
    {
        if (!isset(self::$tournamentlist[$id])) return FALSE;
        $tournament = self::$tournamentlist[$id];
        if ($tournament->is_init() === FALSE)
                $tournament->load();
        return $tournament;
    }

    public static final function get_match($id)
    {
        if (!isset(self::$matchlist[$id])) return FALSE;
        $match = self::$matchlist[$id];
        if ($match->is_init() === FALSE)
                $match->load();
        return $match;
    }

    private static $userlist = array();
    private static $eventlist = array();
    private static $locationlist = array();
    private static $gamelist = array();
    private static $teamlist = array();
    private static $tournamentlist = array();
    private static $matchlist = array();

    private static $roles = array();
    private static $class_prefix = array();
    private static $class_desc = array();

    public static final function get_role_by_id($id)
    {
        if (count(self::$roles) == 0) self::load_roles();
        if (isset(self::$roles[$id])) return self::$roles[$id];
        return 'None';
    }

    public static final function get_class_prefix_by_id($id)
    {
        if (count(self::$class_prefix) == 0) self::load_classes();
        if (isset(self::$class_prefix[$id])) return self::$class_prefix[$id];
        return '';
    }

    public static final function get_class_desc_by_id($id)
    {
        if (count(self::$class_desc) == 0) self::load_classes();
        if (isset(self::$class_desc[$id])) return self::$class_desc[$id];
        return 'None';
    }

    public static final function load_roles()
    {
        $table = MySQL::table('type_roles');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.';');
        MySQL::logout();
        for ($i = 0; $i < count($result); $i++)
            self::$roles[$result[$i]['id']] = $result[$i]['name'];
    }

    public static final function load_classes()
    {
        $table = MySQL::table('type_attendees');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.';');
        MySQL::logout();
        for ($i = 0; $i < count($result); $i++)
        {
            self::$class_prefix[$result[$i]['id']] = $result[$i]['prefix'];
            self::$class_desc[$result[$i]['id']] = $result[$i]['description'];
        }
    }

    public static final function parse_date($date)
    {
        $utime = strtotime($date);
        return date('F j, Y', $utime);
    }

    public static final function parse_datetime($datetime)
    {
        $utime = strtotime($datetime);
        return date(LPRMS::conf('dateformat'), $utime);
    }

    public static final function parse_phone($phone)
    {
        $part3 = substr($phone, -4);
        $part2 = substr($phone, -7, 3);
        $part1 = substr($phone, -10, 3);
        return $part1.'-'.$part2.'-'.$part3;
    }
}
?>
