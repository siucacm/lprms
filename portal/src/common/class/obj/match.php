<?php

class Match extends Object {
    function __construct($id = 0)
    {
        parent::__construct($id, 'game_match');
    }

    public function load()
    {
        parent::load();
        $this->load_players();
    }

    private $players = array();

    public function count_players()
    {
        return count($this->players);
    }

    public function prepare()
    {
        parent::prepare();
    }

    private function load_players()
    {
        $table = MySQL::table('ref_player_match');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `id_match` = \''.$this->id.'\';');
        MySQL::logout();
        if ($result !== FALSE)
            for ($i = 0; $i < count($result); $i++)
            {
                $entry = $result[$i];
                if ($this->team == 1)
                {
                    $this->players[$entry['id_player']] = Library::get_team($entry['id_player']);
                }
                else
                {
                    $this->players[$entry['id_player']] = Library::get_user($entry['id_player']);
                }
            }
    }

    public static final function calc_round($rounds, $tree_position)
    {
        $level = floor(log($tree_position+1, 2));
        return ($rounds - $level);
    }
}
?>
