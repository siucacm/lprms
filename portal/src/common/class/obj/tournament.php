<?php

class Tournament extends Object {
    function __construct($id = 0)
    {
        parent::__construct($id, 'game_tournament');
    }

    public function __toString()
    {
        $str = parent::__toString();
        foreach ($this->tree_match as $key => $value)
                $str .= $value->__toString();
        return $str;
    }

    public function load()
    {
        parent::load();
        $this->load_matches();
    }

    public function load_matches()
    {
        if (count($this->tree_match) == 0)
        {
            $table = MySQL::table('game_match');
            MySQL::login();
            $results = MySQL::query('SELECT * FROM '.$table.' WHERE `id_tournament` = '.$this->id);
            MySQL::logout();
            if ($results !== FALSE && count($results) > 0)
            {
                for ($i = 0; $i < count($results); $i++)
                {
                    $this->tree_match[$results[$i]['tree_position']] = Library::get_match($results[$i]['id']);
                }
            }
        }
    }

    public function generate_matches()
    {
        if (count($this->tree_match) == 0)
        {
            $num_matches = pow(2,$this->rounds) - 1;
            for ($i = 0; $i < $num_matches; $i++)
            {
                echo Match::calc_round($this->rounds, $i);
                $m = new Match();
                $m->create_new();
                $m->id_tournament = $this->id;
                $m->tree_position = $i;
                $m->team = $this->team;
                $m->id_game = $this->id_game;
                $m->id_type = $this->id_type;
                $m->id_owner = $this->id_owner;
                $m->id_event = $this->id_event;
                $m->capacity = 2;
                $m->commit();
                $this->tree_match[$i] = $m;
            }
        }
    }

    public function num_players()
    {
        $num = 0;
        foreach ($this->tree_match as $key => $value)
                $num += $value->num_players();
        return $num;
    }

    public function capacity()
    {
        return pow(2,$this->rounds);
    }

    public function next_free_match_id()
    {
        foreach ($this->tree_match as $key => $value)
        {
            if (Match::calc_round($this->rounds, $key) == $this->rounds)
                if ($value->num_players < 2)
                    return $value->id;
        }
        return FALSE;
    }

    public function get_mid_from_uid($uid)
    {
        $uid = MySQL::num($uid);
        if ($this->team == 1) return FALSE;
        $ret = FALSE;
        $table = MySQL::table('ref_player_match');
        MySQL::login();
        foreach ($this->tree_match as $key => $value)
        {
            $result = MySQL::query('SELECT `id_match` FROM '.$table.' WHERE `team` = \'1\' AND `id_player` = \''.$uid.'\';');
            if (count($result) == 0) continue;
            $match = Library::get_match($result[0]['id_match']);
            $ret = $result[0]['id_match'];
            break;
        }
        return $ret;
    }

    public function generate_tree_img()
    {
        
    }

    public function generate_tree_linkmap()
    {
        
    }

    private $tree_match = array();

    public function prepare()
    {
        parent::prepare();
    }
}
?>
