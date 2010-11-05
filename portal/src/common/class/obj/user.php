<?php

class User extends Object {
    function __construct($id = 0)
    {
        parent::__construct($id, 'core_users');
    }

    public function  __toString()
    {
        $str = parent::__toString();
        $str .= 'Role: '.Library::get_role_by_id($this->role);
        $str .= "\n";
        $str .= 'Designations: '."\n";
        foreach ($this->eventClassID as $key => $value)
                $str .= "\t".Library::get_class_desc_by_id($value).' ('.Library::get_event($key)->name.')'."\n";
        $str .= 'Teams:'."\n";
        foreach ($this->teams as $key => $value)
                $str .= "\t".$value->name."\n";
        $str .= 'Match IDs:'."\n";
        foreach ($this->matches as $key => $value)
                $str .= "\t".$value->id."\n";
        $str .= 'Tournament IDs:'."\n";
        foreach ($this->tournaments as $key => $value)
                $str .= "\t".$value->id."\n";
        $str .= "\n\n";
        return $str;
    }

    public function join_event($eid)
    {
        $eid = MySQL::num($eid);
        $event = Library::get_event($eid);
        $min_age = Library::get_event($eid)->min_age;
        $birthday = $this->birthday;
        $u_now = time();
        $u_ma = strtotime($birthday.' +'.$min_age.' years');
        if ($u_ma > $u_now) return;
        if ($event === FALSE) return;
        $designation = (time() - strtotime($event->datetime_start) > 0)?4:5;
        MySQL::login();
        MySQL::replace('ref_user_event', array('id_user' => $this->oid(), 'id_event' => $eid, 'id_designation' => $designation), '');
        MySQL::logout();
        $this->fetch_events();
    }

    public function leave_event($eid)
    {
        $eid = MySQL::num($eid);
        MySQL::login();
        MySQL::delete('ref_user_event','WHERE `id_user` = \''.$this->oid().'\' AND `id_event` = \''.$eid.'\'');
        MySQL::logout();
        $this->fetch_events();
    }

    public function join_team($tid)
    {
        $tid = MySQL::num($tid);
        $team = Library::get_team($tid);
        if ($team->num_players() >= $team->size && $team->size != 0) return;
        MySQL::login();
        MySQL::replace('ref_user_team', array('id_user' => $this->oid(), 'id_team' => $tid), '');
        MySQL::logout();
        $team->load();
        $this->fetch_teams();
    }

    public function leave_team($tid)
    {
        $tid = MySQL::num($tid);
        $team = Library::get_team($tid);
        MySQL::login();
        MySQL::delete('ref_user_team', 'WHERE `id_user` = \''.$this->oid().'\' AND `id_team` = \''.$tid.'\'');
        MySQL::logout();
        $team->load();
        $this->fetch_teams();
    }

    public function join_match($mid)
    {
        $mid = MySQL::num($mid);
        $match = Library::get_match($mid);
        if ($match->id_tournament != 0) return FALSE;
        if ($match->capacity <= $match->count_players() && $match->capacity > 0) return FALSE;
        if ($match->team == 1) return FALSE;
        MySQL::login();
        MySQL::replace('ref_player_match', array('id_player' => $this->oid(), 'id_match' => $mid, 'team' => 0), '');
        MySQL::logout();
        $match->load();
        $this->fetch_matches();
        return TRUE;
    }

    public function leave_match($mid)
    {
        $mid = MySQL::num($mid);
        $match = Library::get_match($mid);
        if ($match->id_tournament != 0) return;
        MySQL::login();
        MySQL::delete('ref_player_match', 'WHERE `id_player` = \''.$this->oid().'\' AND `id_match` = \''.$mid.'\';');
        MySQL::logout();
        $match->load();
        $this->fetch_matches();
    }

    public function join_tournament($tid)
    {
        $tid = MySQL::num($tid);
        if ($tid == 0) return FALSE;
        $tournament = Library::get_tournament($tid);
        $mid = $tournament->next_free_match_id();
        if ($mid === FALSE) return FALSE;
        $match = Library::get_match($mid);
        echo $match;
        if ($match->capacity <= $match->count_players() && $match->capacity > 0) return FALSE;
        if ($match->team == 1) return FALSE;
        MySQL::login();
        MySQL::replace('ref_player_match', array('id_player' => $this->oid(), 'id_match' => $mid, 'team' => 0), '');
        MySQL::logout();
        $match->load();
        $this->fetch_matches();
        $this->fetch_tournaments();
        return TRUE;
    }

    public function leave_tournament($tid)
    {
        $tid = MySQL::num($tid);
        $tournament = Library::get_tournament($tid);
        if ($tournament->started == 1) return;
        $mid = $tournament->get_mid_from_uid($this->id);
        if ($mid === FALSE) return;
        MySQL::login();
        MySQL::delete('ref_player_match', 'WHERE `id_player` = \''.$this->oid().'\' AND `id_match` = \''.$mid.'\';');
        MySQL::logout();
        $match->load();
        $this->fetch_matches();
        $this->fetch_tournaments();
    }


    public function load()
    {
        parent::load();
        $this->fetch_events();
        $this->fetch_teams();
        $this->fetch_matches();
        $this->fetch_tournaments();
    }

    public function load_mini()
    {
        parent::load();
    }

    public function steam()
    {
        if ($this->steam == NULL)
        {
            $this->steam = new Steam($this->id);
            $this->steam->id = $this->id_steam;
            $this->steam->id_numeric = SQL::num($this->num_steam);
            $this->steam->load();
        }
        return $this->steam;
    }

    public function name()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function xfire()
    {
        if ($this->xfire == NULL)
        {
            $this->xfire = new XFire($this->id);
            $this->xfire->id = $this->id_xfire;
            $this->xfire->load();
        }
        return $this->xfire;
    }

    public function get_gravatar($size = 256)
    {
        $img = 'content/cache/user/'.$this->id.'/avatar_'.$size.'.png';
        if (!file_exists(LPRMS::root().$img)) Cacher::update_user($this->id);
        return LPRMS::page($img);
    }

    public function link()
    {
        return LPRMS::home().'/profile/'.$this->username;
    }

    public function link_steam()
    {
        if ($this->steam()->id != '')
                return '<img src="'.LPRMS::page('content/cache/user/'.$this->id.'/steam_32.png').'" alt="" align="middle" />'.
                    HTML::link_text('http://steamcommunity.com/id/'.$this->steam()->id,$this->steam()->display);
        if ($this->steam()->id_numeric != 0)
                return '<img src="'.LPRMS::page('content/cache/user/'.$this->id.'/steam_32.png').'" alt="" align="middle" />'.
                    HTML::link_text('http://steamcommunity.com/profiles/'.$this->steam()->id_numeric,$this->steam()->display);
        return '';
    }

    public function link_xfire()
    {
        if ($this->xfire()->id != '')
        {
            $display = $this->xfire()->display;
            if ($display == '') $display = $this->xfire()->id;
                return '<img src="'.LPRMS::page('content/cache/user/'.$this->id.'/xfire_32.png').'" alt="" align="middle" />'.
                        HTML::link_text('http://xfire.com/profile/'.$this->xfire()->id,$display);
        }
        return '';
    }

    public function teams()
    {
        return $this->teams;
    }

    public function events()
    {
        return $this->events;
    }

    public function eventClassID()
    {
        return $this->eventClassID;
    }

    public function eventSeat()
    {
        return $this->eventSeat;
    }

    public function link_confirm()
    {
        return LPRMS::page('account/confirm/'.$this->confirm);
    }

    public function link_reset()
    {
        return LPRMS::page('account/reset/'.$this->confirm);
    }

    public function commit()
    {
        parent::commit();
        $this->steam();
        $this->xfire();
        Cacher::update_user($this->id);
    }

    public function uid()
    {
        return SQL::zerofill($this->id);
    }

    private $events = array();
    private $eventClassID = array();
    private $eventSeat = array();
    private $teams = array();
    private $matches = array();
    private $tournaments = array();
    private $steam = NULL;
    private $xfire = NULL;

    private function fetch_matches()
    {
        $table = MySQL::table('ref_player_match');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `id_player` = \''.$this->oid().'\' AND `team` = \'0\';');
        MySQL::logout();
        if ($result !== FALSE)
            for ($i = 0; $i < count($result); $i++)
            {
                $entry = $result[$i];
                $this->matches[$entry['id_match']] = Library::get_match($entry['id_match']);
            }
    }

    private function fetch_tournaments()
    {
        $table = MySQL::table('ref_player_match');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `id_player` = \''.$this->oid().'\' AND `team` = \'0\';');
        MySQL::logout();
        if ($result !== FALSE)
            for ($i = 0; $i < count($result); $i++)
            {
                $entry = $result[$i];
                $match = Library::get_match($entry['id_match']);
                if ($match->id_tournament != 0)
                {
                    $this->tournaments[$match->id_tournament] = Library::get_tournament($match->id_tournament);
                }
            }
    }

    private function fetch_teams()
    {
        $table = MySQL::table('ref_user_team');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `id_user` = '.$this->oid().';');
        MySQL::logout();
        $this->teams = array();
        if (count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            {
                $tid = $result[$i]['id_team'];
                $this->teams[$tid] = Library::get_team($tid);
            }
        }
    }

    private function fetch_events()
    {
        $table = MySQL::table('ref_user_event');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `id_user` = '.$this->oid().';');
        MySQL::logout();
        $this->eventClassID = array();
        $this->events = array();
        if (count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            {
                $eid = $result[$i]['id_event'];
                $this->eventClassID[$eid] = $result[$i]['id_designation'];
                $this->eventSeat[$eid] = $result[$i]['seat'];
                $this->events[$eid] = Library::get_event($eid);
            }
        }
    }

    public function prepare()
    {
        parent::prepare();
        unset($this->id);
        $this->first_name   = MySQL::alphanum($this->first_name);
        $this->last_name    = MySQL::alphanum($this->last_name);
        $this->password     = MySQL::alphanum($this->password);
        $this->confirm      = MySQL::alphanum($this->confirm);
        $this->email        = MySQL::email($this->email);
        $this->username     = MySQL::alphanum($this->username);
        $this->phone        = MySQL::num($this->phone);
        $this->birthday     = MySQL::bday($this->birthday);
        $this->joined       = MySQL::bday($this->joined);
        $this->gamertag     = MySQL::string($this->gamertag);
        $this->blurb        = MySQL::string($this->blurb);
        $this->role         = MySQL::num($this->role);
        $this->id_steam     = MySQL::alphanum($this->id_steam);
        $this->num_steam     = MySQL::num($this->num_steam);
        $this->id_xfire     = MySQL::alphanum($this->id_xfire);
        $this->id_twitter   = MySQL::alphanum($this->id_twitter);
        $this->active       = MySQL::num($this->active);
    }

    public static final function username_exists($username)
    {
        $username = SQL::alphanum($username);
        $table = MySQL::table('core_users');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `username` = \''.$username.'\';');
        MySQL::logout();
        if ($result === FALSE || count($result) > 0) return TRUE;
        return FALSE;
    }

    public static final function email_exists($email)
    {
        $email = SQL::email($email);
        $table = MySQL::table('core_users');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `email` = \''.$email.'\';');
        MySQL::logout();
        if ($result === FALSE || count($result) > 0) return TRUE;
        return FALSE;
    }

    public static final function get_username_by_id($uid)
    {
        $table = MySQL::table('core_users');
        $uid = SQL::num($uid);
        MySQL::login();
        $result = MySQL::query('SELECT `username` FROM '.$table.' WHERE `id` = \''.$uid.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return FALSE;
        return $result[0]['username'];
    }

    public static final function get_id_by_username($username)
    {
        $table = MySQL::table('core_users');
        $username = SQL::alphanum($username);
        MySQL::login();
        $result = MySQL::query('SELECT `id` FROM '.$table.' WHERE `username` = \''.$username.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return FALSE;
        return $result[0]['id'];
    }

    public static final function get_email_by_id($uid)
    {
        $table = MySQL::table('core_users');
        $uid = SQL::num($uid);
        MySQL::login();
        $result = MySQL::query('SELECT `email` FROM '.$table.' WHERE `id` = \''.$uid.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return FALSE;
        return $result[0]['email'];
    }

    public static final function get_id_by_email($email)
    {
        $table = MySQL::table('core_users');
        $email = SQL::email($email);
        MySQL::login();
        $result = MySQL::query('SELECT `id` FROM '.$table.' WHERE `email` = \''.$email.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return FALSE;
        return $result[0]['id'];
    }

    public static final function get_id_by_hash($hash)
    {
        $table = MySQL::table('core_users');
        $hash = SQL::hex($hash);
        MySQL::login();
        $result = MySQL::query('SELECT `id` FROM '.$table.' WHERE `confirm` = \''.$hash.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return FALSE;
        return $result[0]['id'];
    }

}
?>
